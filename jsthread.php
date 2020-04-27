<?php
/*
php:
    ThreadClass::write_script();
javascript:
    Thread.generateBlob({               // return blobURL
        extcode: "",
        func: function (params) {
        }
    });
    Thread.createFromBlob({             // return array of Thread Instance
        blobURL: "",
        callbackfunc: function (retval) {
        },
        n: 1
    });
    Thread.create({                     // return single Thread Instance
        extcode: "",
        func: function (params) {
        },
        callbackfunc: function (retval) {
        }
    });
    Thread.close(ThreadInstance);
*/
$Thread_script_written = 0;

class ThreadClass {
    public static function write_script() {
        global $Thread_script_written;
        if ($Thread_script_written == 1) return;
        $Thread_script_written = 1;
        ?>
        <script type="text/javascript">

        'use strict';

        var Thread = {
            generateBlob : function (params) {
                var xurl = window.URL || window.webkitURL;
                var st;
                if (typeof(Worker) === "undefined") return null;
                if (!window.Worker) return null;
                if (params.func === undefined) return null;
                if (params.extcode !== undefined) {
                    st = params.extcode + "\n";
                }
                else {
                    st = "";
                }
                st += "var ThreadFunction = " + params.func.toString() + ";";
                st += "var main = {};";
                st += "onmessage = function(e) {var r = ThreadFunction(e.data); postMessage(r)};";
                return xurl.createObjectURL(new Blob([ st ], { type: "text/javascript" }));
            },

            createFromBlob : function (params) {
                var rv = [], n;
                var r, i;
                if (params.n !== undefined) {
                    n = params.n;
                }
                else {
                    n = 1;
                }
                if (n < 1) n = 1;
                for (i = 0; i < n; i++) {
                    r = {};
                    r.w = new Worker (params.blobURL);
                    if (r.w == null) return null;
                    r.call = function (r) {
                        return function (params) {
                            r.w.postMessage(params);
                        };
                    }(r);
                    r.terminate = function (r) {
                        return function () {
                            Thread.close(r);
                        };
                    }(r);
                    if (params.callbackfunc !== undefined) {
                        r.w.onmessage = function(r) {
                            return function (e) {
                                params.callbackfunc(e.data);
                            }
                        } (r);
                    }
                    rv.push(r);
                }
                return rv;
            },

            create : function (params) {
                var blobURL = Thread.generateBlob(params);
                if (blobURL == null) return null;
                var x = Thread.createFromBlob({
                    blobURL: blobURL,
                    callbackfunc: params.callbackfunc
                });
                if (EncodingClass.type.isArray(x)) return x[0];
                return null;
            },
            close : function (r) {
                r.w.terminate;
                r.w = undefined;
                r.call = undefined;
                r.terminate = undefined;
            }
        };
        </script>
        <?php
    }
}
?>
