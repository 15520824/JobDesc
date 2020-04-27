<?php
/*
php:
    EncodingExtClass::write_script();

?>
*/
include_once "jsencoding.php";
include_once "jsthread.php";
$Encodingext_script_written = 0;

class EncodingExtClass {
    public static function write_script() {
        global $Encodingext_script_written;
        if ($Encodingext_script_written == 1) return;
        EncodingClass::write_script();
        ThreadClass::write_script();
        $Encodingext_script_written = 1;
        ?><script type="text/javascript">

        'use strict';

        if (function () {
            var st = "var EncodingClass = " + EncodingClass.string.exportVariable(EncodingClass) + ";\n";
            EncodingClass.worker = {
                blobURL : Thread.generateBlob({
                    extcode: st,
                    func: function (params) {
                        if (params.taskid === undefined) return null;
                        switch (params.taskid) {
                            case "fromVariable":
                                return EncodingClass.string.fromVariable(params.obj);
                            case "toVariable":
                                return EncodingClass.string.toVariable(params.obj);
                            case "duplicate":
                                return EncodingClass.string.duplicate(params.obj);
                            case "exportVariable":
                                return EncodingClass.string.exportVariable(params.obj);
                            case "merge":
                                return EncodingClass.string.merge(params.obj);
                            default:
                                return null;
                        }
                    }
                }),
                threadInstanceList : [],
                getThreadInstance : function () {
                    var i, x;
                    for (i = 0; i < EncodingClass.worker.threadInstanceList.length; i++) {
                        if (!EncodingClass.worker.threadInstanceList[i].inuse) {
                            EncodingClass.worker.threadInstanceList[i].inuse = true;
                            return EncodingClass.worker.threadInstanceList[i];
                        }
                    }
                    x = Thread.createFromBlob({
                        blobURL: EncodingClass.worker.blobURL,
                        n: 1,
                        callbackfunc: function (index) {
                            return function (retval) {
                                var x;
                                if (EncodingClass.worker.threadInstanceList[index].func) {
                                    x = EncodingClass.worker.threadInstanceList[index].func(retval);
                                }
                                else {
                                    x = undefined;
                                }
                                EncodingClass.worker.threadInstanceList[index].func = null;
                                EncodingClass.worker.threadInstanceList[index].inuse = false;
                                return x;
                            }
                        } (EncodingClass.worker.threadInstanceList.length)
                    });
                    EncodingClass.worker.threadInstanceList.push({
                        inuse: true,
                        func: null,
                        instance: x[0]
                    });
                    return EncodingClass.worker.threadInstanceList[EncodingClass.worker.threadInstanceList.length - 1];
                },
                fromVariable : function (obj, callbackfunc) {
                    var x = EncodingClass.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "fromVariable",
                        obj: obj
                    });
                },
                toVariable : function (str, callbackfunc) {
                    var x = EncodingClass.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "toVariable",
                        obj: str
                    });
                },
                duplicate : function (obj, callbackfunc) {
                    var x = EncodingClass.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "duplicate",
                        obj: str
                    });
                },
                exportVariable : function (obj, callbackfunc) {
                    var x = EncodingClass.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "exportVariable",
                        obj: str
                    });
                },
                merge : function (strArray, callbackfunc) {
                    var x = EncodingClass.worker.getThreadInstance();
                    x.func = callbackfunc;
                    x.instance.call({
                        taskid: "merge",
                        obj: str
                    });
                }
            };
            return 0;
        } () == 0);
        </script>
        <?php
     }
 }
 ?>
