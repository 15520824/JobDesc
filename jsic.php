<?php
/*
php:
    function ICClass::write_script();
javascript:
    function ICClass.type({
        type: "class",
        content: [{name: name, type: ICClass.type}]
    });
    function ICClass.type({
        type: "array",
        content: ICClass.type
    });
    function ICClass.type("int / float / time / text");
    function ICClass.pin({
        name: "testpin",
        type: ICClass.type

        .subscribe function(pin, func);
        .setValue function(value);
        .getValue function();
    }
    function ICClass.create({
        name: "test"
    });
*/

$ic_script_written = 0;
class ICClass {
    public static function write_script() {
        global $ic_script_written;
        if ($ic_script_written == 1) return 0;
        ?>
        <script type="text/javascript">
            var ICClass = {
                definedType : [
                    {type: "int", matched: function(xtype) {                // matched == 4 -> completedly matched
                        if (xtype.type == "int") return 4;                  // matched == 3 -> compatible
                        if (xtype.type == "float") return 2;                // matched == 2 -> not compatible, may lose information
                        if (xtype.type == "text") return 1;                 // matched == 1 -> not compatible, may not be recorgized
                        return 0;                                           // matched == 0 -> can not convert.
                    }},
                    {type: "float", matched: function(xtype) {
                        if (xtype.type == "float") return 4;
                        if (xtype.type == "int") return 3;
                        if (xtype.type == "text") return 1;
                        return 0;
                    }},
                    {type: "time", matched: function(xtype) {
                        if (xtype.type == "time") return 4;
                        return 0;
                    }},
                    {type: "text", matched: function(xtype) {
                        if (xtype.type == "text") return 4;
                        if (xtype.type == "int") return 3;
                        if (xtype.type == "float") return 3;
                        if (xtype.type == "time") return 3;
                        return 0;
                    }},
                ],
                type : function (params) {
                    var retval, x, i, t, xl;
                    if (params === undefined) return null;
                    if (typeof params === 'string' || params instanceof String) {
                        if (params == "int") return ICClass.definedType[0];
                        if (params == "float") return ICClass.definedType[1];
                        if (params == "time") return ICClass.definedType[2];
                        if (params == "text") return ICClass.definedType[3];
                        return null;
                    }
                    if (params.type === undefined) return null;
                    switch (params.type) {
                        case "array":
                            x = params.content;
                            if (typeof x === 'string' || x instanceof String) x = ICClass.type(x);
                            if (x == null) return null;
                            t = x;
                            break;
                        case "class":
                            t = [];
                            for (i = 0; i < params.length; i++) {
                                x = params[i];
                                if (x == null) return null;
                                if (typeof x === 'string' || x instanceof String) return null;
                                t.push(x);
                            }
                            break;
                        default:
                            return null;
                    }
                    retval = {type: params.type, content: t, matched: function(type, content) {
                        return function (xtype) {
                            var i, k, x;
                            switch (type) {
                                case "class":
                                    if (xtype.type != "class") return 0;
                                    if (xtype.content.length != content.length) return
                                    k = 4;
                                    for (i = 0; i < content.length; i++) {
                                        x = content[i].matched(xtype.content[i]);
                                        if (x == 0) return 0;
                                        if (x < k) k = x;
                                    }
                                    return k;
                                case "array":
                                    if (xtype.type != "array") return 0;
                                    return content.matched(xtype.content);
                                default:
                                    return 0;
                            }
                        };
                    }(params.type, t)};
                    ICClass.definedType.push(retval);
                    return retval;
                },
                queuedFuncs: [],
                queuedFuncsLoop : function () {
                    var i, x, t;
                    while (ICClass.queuedFuncs.length > 0) {
                        x = ICClass.queuedFuncs[0];
                        t = [];
                        for (i = 1; i < ICClass.queuedFuncs.length; i++) t.push(ICClass.queuedFuncs[i]);
                        ICClass.queuedFuncs = t;
                        x();
                    }
                    setTimeout("ICClass.queuedFuncsLoop();", 10);
                },
                pin: function (params) {
                    var retval = {
                        name: params.name,
                        type: params.type,
                        value: null,
                        subscribed: [],
                    };
                    retval.subscribe = function (me) {
                        return function (pin, func) {
                            me.subscribed.push({
                                pin: pin,
                                func: func
                            });
                        };
                    } (retval);
                    retval.setValue = function (me) {
                        return function (value) {
                            var i, j, k;
                            me.value = ICClass.setPinValueByType(value, me.type);
                            if (me.subscribed.length > 0) {
                                for (i = 0; i < me.subscribed.length; i++) {
                                    k = 0;
                                    me.subscribed[i].pin.value = me.value;
                                    for (j = 0; j < ICClass.queuedFuncs.length; j++) {
                                        if (me.subscribed[i].func == ICClass.queuedFuncs[j]) {
                                            k = 1;
                                            break;
                                        }
                                    }
                                    if (k == 0) ICClass.queuedFuncs.push(me.subscribed[i].func);
                                }
                            }
                        };
                    } (retval);
                    retval.getValue = function (me) {
                        return function () {
                            return ICClass.getPinValueByType(me.value, me.type);
                        };
                    } (retval);
                    return retval;
                },
                setPinValueByType : function (value, type) {
                    var i, r;
                    switch (type.type) {
                        case "int":
                            return parseInt(value + "", 10);
                        case "float":
                            return parseFloat(value + "");
                        case "time":
                            return value;
                        case "text":
                            return value + "";
                        case "array":
                            r = [];
                            for (i = 0; i < value.length; i++) {
                                r.push(ICClass.setPinValueByType(value[i], type.content));
                            }
                            return r;
                        case "class":
                            r = [];
                            for (i = 0; i < type.content.length; i++) {
                                r.push(ICClass.setPinValueByType(value[type.content[i].name], type.content[i].type));
                            }
                            return r;
                        default:
                            return null;
                    }
                },
                getPinValueByType : function (value, type) {
                    var i, r;
                    switch (type.type) {
                        case "int":
                            return parseInt(value + "", 10);
                        case "float":
                            return parseFloat(value + "");
                        case "time":
                            return value;
                        case "text":
                            return value + "";
                        case "array":
                            r = [];
                            for (i = 0; i < value.length; i++) {
                                r.push(ICClass.getPinValueByType(value[i], type.content));
                            }
                            return r;
                        case "class":
                            r = {};
                            for (i = 0; i < type.content.length; i++) {
                                r[type.content[i].name] = ICClass.getPinValueByType(value[i], type.content[i].type);
                            }
                            return r;
                        default:
                            return null;
                    }
                }
            };
            setTimeout("ICClass.queuedFuncsLoop();", 10);
        </script>
        <?php
        $ic_script_written = 1;
        return 1;
    }
}
?>
