<?php
    include_once "jsencoding.php";
/*
php:
    function FormClass::write_script();
    function FormClass::getIndex($writeout);
    function FormClass::dataToString($data);
    function FormClass::stringToData($str);
    function FormClass::packedString($str);
    function FormClass::unpackString($str, &offset);
javascript:
    function FormClass.openUrlInNewTab(url);
    function FormClass.form_post_newtab(url, params);
    function FormClass.form_post(url, optional params, optional target);
    function FormClass.parseArray(str);
    function FormClass.api_call({
        url: "http://daithangminh.vn/login.php",
        params: [
                    {name: "email",
                     value: "ng_dan_thanh@yahoo.com"
                    },
                    {name: "password",
                     value: "123456"
                    }
                ],
        [optional] fileuploads: [
                        {name: "attachment1",
                         filename: "aa.png",
                         content: [ binary data ]
                        },
                    ],
        func: function(bool success, string message) {
        }
    });
*/

$form_new_script_written = 0;
$form_maxIndex = 0;

class FormClass {
    public static function getIndex($writeout) {
        global $form_maxIndex;
        if ($writeout) echo $form_maxIndex;
        return $form_maxIndex++;
    }

    public static function write_script() {
        global $form_new_script_written;
        EncodingClass::write_script();
        if ($form_new_script_written == 1) return 0;
        ?>
        <script type="text/javascript">

            'use strict'

            var FormClass = {
                req : [],
                functions : [],
                wait : [],
                n : 0,

                openUrlInNewTab: function (url) {     // must exec in "onclick" event
                    window.open(url, "_blank");
                },

                form_post_newtab : function (url, params) {
                    form_post(url, params, "_blank");
                },

                form_post : function (url, params, target) {
                    var form = document.createElement("form");
                    if (params === undefined) {
                        params = [];
                        target = null;
                    }
                    else if (target === undefined) {
                        target = null;
                    }
                    var hiddenField;
                    var i;

                    form.setAttribute("method", "post");
                    form.setAttribute("action", url);
                    if (target != null) form.setAttribute("target", target);

                    for (i = 0; i < params.length; i++) {
                        hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", params[i][0]);
                        hiddenField.setAttribute("value", params[i][1]);
                        form.appendChild(hiddenField);
                    }
                    document.body.appendChild(form);
                    form.submit();
                },

                unpackString : function (params) {
                    var xlen, hlen, data;
                    if (params.offset === undefined) params.offset = 0;
                    xlen = parseInt(param.text.substr(params.offset, 1), 16);
                    params.offset += 1;
                    hlen = parseInt(param.text.substr(params.offset, xlen), 16);
                    params.offset += xlen;
                    data = param.text.substr(params.offset, hlen);
                    params.offset += hlen;
                    return data;
                },

                parseArray_o : function (params) {
                    var i, len, code, data;
                    code = params.text.substr(params.offset, 1);
                    params.offset += 1;
                    if (code == "v") {
                        return EncodingClass.utf8.decode(FormClass.unpackString(params));
                    }
                    if (code == "a") {
                        len = parseInt(FormClass.unpackString(params), 10);
                        data = [];
                        for (i = 0; i < len; i++) {
                            data.push(FormClass.parseArray_o(params));
                        }
                        return data;
                    }
                    return null;
                },

                parseArray : function (str) {
                    return parseArray_o({text: str, offset: 0});
                },

                urlencode : function (str) {

                    str = (str + '');

                    return encodeURIComponent(str)
                    .replace(/!/g, '%21')
                    .replace(/'/g, '%27')
                    .replace(/\(/g, '%28')
                    .replace(/\)/g, '%29')
                    .replace(/\*/g, '%2A')
                    .replace(/%20/g, '+');
                },

                api_call_callback : function () {
                    // If req shows "complete"
                    var i;
                    for (i = 0; i < FormClass.n; i++) {
                        if (FormClass.wait[i] == 1) {
                            if (FormClass.req[i].readyState == 4) {
                                FormClass.wait[i] = 2;
                                if (FormClass.req[i].status == 200) {
                                    FormClass.functions[i](true, FormClass.req[i].responseText);
                                }
                                else if (FormClass.req[i].statusText != "") {
                                    FormClass.functions[i](false, "Response Code: " + FormClass.req[i].status + " / " + FormClass.req[i].statusText);
                                }
                                else {
                                    FormClass.functions[i](false, "Response Code: " + FormClass.req[i].status);
                                }
                                FormClass.wait[i] = 0;
                                FormClass.req[i] = 0;
                                FormClass.functions[i] = 0;
                            }
                        }
                    }
                },

                api_call : function (calldata) {
                    var st;
                    var i, k;
                    var boundary;
                    var index, url, params, fileuploads, func;
                    var x = {
                        req: null,
                        func: calldata.func
                    };

                    url = calldata.url;
                    params = calldata.params;
                    if (calldata.fileuploads !== undefined) {
                        fileuploads = calldata.fileuploads;
                    }
                    else {
                        fileuploads = [];
                    }
                    try {
                        x.req = new XMLHttpRequest();
                    } catch (e) {
                        try {
                            x.req = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch (e) {
                            try {
                                x.req = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (oc) {
                                alert("No AJAX Support");
                                return;
                            }
                        }
                    }

                    x.req.onreadystatechange = function (x) {
                        return function () {
                            if (x.req.readyState == 4) {
                                if (x.req.status == 200) {
                                    x.func(true, x.req.responseText);
                                }
                                else if (x.req.statusText != "") {
                                    x.func(false, "Response Code: " + x.req.status + " / " + x.req.statusText);
                                }
                                else {
                                    x.func(false, "Response Code: " + x.req.status);
                                }
                            }
                        }
                    }(x);

                    if ((params.length > 0) || (fileuploads.length > 0)) {
                        x.req.open("POST", url, true);
                        i = ((new Date()).getTime());
                        boundary = i + EncodingClass.md5.encode(i);
                        x.req.setRequestHeader("Content-type", "multipart/form-data; boundary=" + boundary);
                        st = "";
                        for (i = 0; i < params.length; i++) {
                            st += "--" + boundary + "\r\n";
                            st += "Content-Disposition: form-data; ";
                            st += "name=\"" + EncodingClass.utf8.encode(params[i].name) + "\"\r\n\r\n";
                            st += EncodingClass.utf8.encode(params[i].value) + "\r\n";
                        }
                        for (i = 0; i < fileuploads.length; i++) {
                            st += "--" + boundary + "\r\n";
                            st += "Content-Disposition: form-data; ";
                            st += "name=\"" + EncodingClass.utf8.encode(fileuploads[i].name) + "\"; filename=\"" + EncodingClass.utf8.encode(fileuploads[i].filename) + "\"\r\n\r\n";
                            st += fileuploads[i].content + "\r\n";
                        }
                        st += "--" + boundary + "--\r\n";
                        var nBytes = st.length, ui8Data = new Uint8Array(nBytes);
                        for (var nIdx = 0; nIdx < nBytes; nIdx++) {
                            ui8Data[nIdx] = st.charCodeAt(nIdx) & 0xff;
                        }
                        x.req.send(ui8Data);
                    }
                    else {
                        x.req.open("GET", url, true);
                        x.req.send(null);
                    }
                }

                /*
                api_call : function (calldata) {
                    var st;
                    var i, k, x;
                    var boundary;
                    var index, url, params, fileuploads, func;

                    index = calldata.index;
                    url = calldata.url;
                    func = calldata.func;
                    params = calldata.params;
                    if (calldata.fileuploads !== undefined) {
                        fileuploads = calldata.fileuploads;
                    }
                    else {
                        fileuploads = [];
                    }
                    while (index >= FormClass.n) {
                        FormClass.req.push(0);
                        FormClass.functions.push(0);
                        FormClass.wait.push(0);
                        FormClass.n++;
                    }
                    try {
                        FormClass.req[index] = new XMLHttpRequest();
                    } catch (e) {
                        try {
                            FormClass.req[index] = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch (e) {
                            try {
                                FormClass.req[index] = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (oc) {
                                alert("No AJAX Support");
                                return;
                            }
                        }
                    }

                    FormClass.req[index].onreadystatechange = FormClass.api_call_callback;
                    FormClass.wait[index] = 1;
                    FormClass.functions[index] = func;

                    if ((params.length > 0) || (fileuploads.length > 0)) {
                        FormClass.req[index].open("POST", url, true);
                        i = ((new Date()).getTime());
                        boundary = i + EncodingClass.md5.encode(i);
                        FormClass.req[index].setRequestHeader("Content-type", "multipart/form-data; boundary=" + boundary);
                        st = "";
                        for (i = 0; i < params.length; i++) {
                            st += "--" + boundary + "\r\n";
                            st += "Content-Disposition: form-data; ";
                            st += "name=\"" + EncodingClass.utf8.encode(params[i].name) + "\"\r\n\r\n";
                            st += EncodingClass.utf8.encode(params[i].value) + "\r\n";
                        }
                        for (i = 0; i < fileuploads.length; i++) {
                            st += "--" + boundary + "\r\n";
                            st += "Content-Disposition: form-data; ";
                            st += "name=\"" + EncodingClass.utf8.encode(fileuploads[i].name) + "\"; filename=\"" + EncodingClass.utf8.encode(fileuploads[i].filename) + "\"\r\n\r\n";
                            st += fileuploads[i].content + "\r\n";
                        }
                        st += "--" + boundary + "--\r\n";
                        var nBytes = st.length, ui8Data = new Uint8Array(nBytes);
                        for (var nIdx = 0; nIdx < nBytes; nIdx++) {
                            ui8Data[nIdx] = st.charCodeAt(nIdx) & 0xff;
                        }
                        FormClass.req[index].send(ui8Data);
                    }
                    else {
                        FormClass.req[index].open("GET", url, true);
                        FormClass.req[index].send(null);
                    }
                }
                */
            };

        </script>
        <?php
        $form_new_script_written = 1;
        return 1;
    }

    public static function packedString($str) {
        $str = $str."";
        $slen = strlen($str);
        $xlen = sprintf("%x", $slen);
        $hlen = substr(sprintf("%x", strlen($xlen)), 0, 1);
        return $hlen.$xlen.$slen;
    }

    public static function dataToString($data) {
        if (is_array($data[$i])) {
            $len = sizeof($data, 0);
            $st = "a".FormClass::packedString($len);
            for ($i = 0; $i < $len; $i++) {
                $st .= FormClass::dataToString($data[$i]);
            }
        }
        else {
            $st = "v".FormClass::packedString($data);
        }
        return $st;
    }

    public static function unpackString($str, &$offset) {
		$xlen = hexdec(substr($str, $offset, 1));
		$offset += 1;
        $hlen = hexdec(substr($str, $offset, $xlen));
        $offset += $xlen;
        $data = substr($str, $offset, $hlen);
        $offset += $hlen;
		return $data;
	}

    public static function stringToData_o ($str, &$offset) {
        $code = substr($str, $offset, 1);
        $offset++;
        if ($code == "v") {
            return FormClass::unpackString($str, $offset);
        }
        if ($code == "a") {
            $len = intval(FormClass::unpackString($str, $offset));
            for ($i = 0; $i < $len; $i++) {
                $data[$i] = FormClass::stringToData_o($str, $offset);
            }
            return $data;
        }
        return null;
    }

    public static function stringToData($str) {
        $offset = 0;
        return FormClass::stringToData_o($str, $offset);
    }
};

 ?>
