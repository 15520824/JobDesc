<?php
/*
php:
    EncodingExtClass::write_script();
javascript:
    DOMElement.arc({
        width: 200,
        height: 200,
        angles: [-45, 0, 90, 180, 225],
        outerRadius: 80,
        innerRadius: 50,
        color: [[0, 0, 255], [0, 255, 255], [0, 255, 0], [255, 255, 0], [255, 0, 0]]
    });

?>
*/
include_once "jsdomelement.php";
include_once "jsthread.php";
$DOMElement_ext_script_written = 0;

class DOMElementExtClass {
    public static function write_script() {
        global $DOMElement_ext_script_written;
        if ($DOMElement_ext_script_written == 1) return;
        DOMElementClass::write_script();
        ThreadClass::write_script();
        $DOMElement_ext_script_written = 1;
        ?><script type="text/javascript">

        'use strict';

        if (function () {
            var x = {
                drawArcBuffer : function (obj) {
                    var buffer = [], i, j, k, x, y, dx, dy, d, a, c, ok, p;
                    x = obj.width / 2.0;
                    y = obj.height / 2.0;
                    for (i = 0; i < obj.color.length; i++) {
                        while (obj.color[i].length < 4) obj.color[i].push(255);
                    }
                    if (obj.innerRadius === undefined) obj.innerRadius = 0;
                    for (i = 0; i < obj.angles.length; i++) {
                        if (obj.angles[i] < 0) obj.angles[i] += 360;
                    }

                    for (i = 0; i < obj.height; i++) {
                        for (j = 0; j < obj.width; j++) {
                            dy = y - i;
                            dx = j - x;
                            d = Math.sqrt(dx * dx + dy * dy);
                            if ((d >= obj.innerRadius) && (d <= obj.outerRadius)) {
                                if (d > 0) {
                                    ok = -1;
                                    a = 180 * Math.atan2(dy, dx) / 3.1415926535897932384626433832795;
                                    if (a < 0) a += 360;
                                    for (k = 0; k + 1 < obj.angles.length; k++) {
                                        if (obj.angles[k] <= obj.angles[k+1]) {
                                            if ((a >= obj.angles[k]) && (a <= obj.angles[k + 1])) {
                                                ok = k;
                                                p = (a - obj.angles[k]) / (obj.angles[k + 1] - obj.angles[k]);
                                                break;
                                            }
                                        }
                                        else {
                                            if (a >= obj.angles[k]) {
                                                ok = k;
                                                p = (a - obj.angles[k]) / (360 + obj.angles[k + 1] - obj.angles[k]);
                                                break;
                                            }
                                            else if (a <= obj.angles[k + 1]) {
                                                ok = k;
                                                p = (a + 360 - obj.angles[k]) / (360 + obj.angles[k + 1] - obj.angles[k]);
                                                break;
                                            }
                                        }
                                    }
                                }
                                else {
                                    ok = -2;
                                }
                            }
                            else {
                                ok = -1;
                            }
                            if (ok >= 0) {
                                c = [0, 0, 0, 0];
                                for (k = 0; k < 4; k++) {
                                    c[k] = obj.color[ok][k] * (1-p) + obj.color[ok + 1][k] * p;
                                    c[k] = parseInt(c[k].toFixed(0) + "", 10);
                                }
                                if ((d + 1 > obj.outerRadius) && (obj.outerRadius-obj.innerRadius >= 5)) {
                                    buffer.push(c[0], c[1], c[2], parseInt((c[3] / 2).toFixed(0) + "", 10));
                                }
                                else if ((d - 1 < obj.innerRadius) && (obj.outerRadius-obj.innerRadius >= 5)) {
                                    buffer.push(c[0], c[1], c[2], parseInt((c[3] / 2).toFixed(0) + "", 10));
                                }
                                else {
                                    buffer.push(c[0], c[1], c[2], c[3]);
                                }
                            }
                            else if (ok == -1) {
                                buffer.push(0, 0, 0, 0);
                            }
                            else if (ok == -2) {
                                c = [0, 0, 0, 0];
                                for (k = 0; k < obj.color.length; k++) {
                                    for (p = 0; p < 4; p++) {
                                        c[p] += obj.color[k][p];
                                    }
                                }
                                for (p = 0; p < 4; p++) {
                                    c[p] = parseInt ((c[p] / obj.color.length).toFixed(0) + "", 10);
                                }
                                buffer.push(c[0], c[1], c[2], c[3]);
                            }
                        }
                    }
                    return buffer;
                }
            };
            var st = "var ProcessorCore = " + EncodingClass.string.exportVariable(x) + ";\n";
            DOMElement.worker = {
                blobURL : Thread.generateBlob({
                    extcode: st,
                    func: function (params) {
                        if (params.taskid === undefined) return null;
                        switch (params.taskid) {
                            case "drawArcBuffer":
                                return ProcessorCore.drawArcBuffer(params.obj);
                            default:
                                return null;
                        }
                    }
                }),
                threadInstanceList : [],
                getThreadInstance : function () {
                    var i, x;
                    for (i = 0; i < DOMElement.worker.threadInstanceList.length; i++) {
                        if (!DOMElement.worker.threadInstanceList[i].inuse) {
                            DOMElement.worker.threadInstanceList[i].inuse = true;
                            return DOMElement.worker.threadInstanceList[i];
                        }
                    }
                    x = Thread.createFromBlob({
                        blobURL: DOMElement.worker.blobURL,
                        n: 1,
                        callbackfunc: function (index) {
                            return function (retval) {
                                var x;
                                if (DOMElement.worker.threadInstanceList[index].func) {
                                    x = DOMElement.worker.threadInstanceList[index].func(retval);
                                }
                                else {
                                    x = undefined;
                                }
                                DOMElement.worker.threadInstanceList[index].func = null;
                                DOMElement.worker.threadInstanceList[index].inuse = false;
                                return x;
                            }
                        } (DOMElement.worker.threadInstanceList.length)
                    });
                    DOMElement.worker.threadInstanceList.push({
                        inuse: true,
                        func: null,
                        instance: x[0]
                    });
                    return DOMElement.worker.threadInstanceList[DOMElement.worker.threadInstanceList.length - 1];
                },
                drawArcBuffer : function (obj, callbackfunc) {
                    var x = DOMElement.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "drawArcBuffer",
                        obj: obj
                    });
                }
            };
            DOMElement.arc = function (params) {
                var r = DOMElement.img({
                    attrs: {
                        width: params.width,
                        height: params.height,
                        style: {
                            width: params.width + "px",
                            height: params.height + "px",
                        }
                    }
                });
                DOMElement.worker.drawArcBuffer(params, function (params, element) {
                    return function (buffer) {
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');

                        canvas.width = params.width;
                        canvas.height = params.height;

                        // create imageData object
                        var idata = ctx.createImageData(params.width, params.height);

                        // set our buffer as source
                        idata.data.set(buffer);

                        // update canvas with new data
                        ctx.putImageData(idata, 0, 0);
                        element.src = canvas.toDataURL();
                    }
                } (params, r));
                return r;
            }
            return 0;
        } () == 0);
        </script>
        <?php
     }
 }
 ?>
