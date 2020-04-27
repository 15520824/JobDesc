<?php
/*
php:
    function RandomClass::write_script();
javascript:
    function RandomClass.seed(seedString, [optional] saltString);   // return generated seed
    function RandomClass.generate(seed);
*/

include_once "jsencoding.php";

$random_script_written = 0;

class   RandomClass {

    public static function write_script() {
        global $random_script_written;
        if ($random_script_written == 1) return 0;
        $random_script_written = 1;
        EncodingClass::write_script();
        ?><script type="text/javascript">
            var RandomClass = {
                seed : function (str, salt) {
                    if (salt === undefined) salt = "-RandomClass";
                    str = EncodingClass.md5.encode(str + salt);
                    return {
                        s1: EncodingClass.string.fromHex(str.substr(0, 8)),
                        s2: EncodingClass.string.fromHex(str.substr(8, 8)),
                        s3: EncodingClass.string.fromHex(str.substr(16, 8)),
                        s4: EncodingClass.string.fromHex(str.substr(24, 8))
                    }
                },
                generate : function (seed) {
                    var i, v, v1, v2, v3, v4;
                    v1 = (seed.s1 * 8121 + 28411) % 134456;
                    v2 = (seed.s2 * 2147483629 + 2147483587) % 2147483647;
                    v3 = (seed.s3 * 1103515245 + 12345) & 2147483647;
                    v4 = (seed.s4 * 1664525 + 1013904223) & 4294967295;
                    seed.s1 = v1;
                    seed.s2 = v2;
                    seed.s3 = v3;
                    seed.s4 = v4;
                    v = 0;
                    for (i = 0; i < 16; i++) {
                        if (v1 & 1) v += 1.0;
                        v /= 2;
                        if (v2 & 1) v += 1.0;
                        v /= 2;
                        if (v3 & 1) v += 1.0;
                        v /= 2;
                        if (v4 & 1) v += 1.0;
                        v /= 2;
                        v1 >>= 1;
                        v2 >>= 1;
                        v3 >>= 1;
                        v4 >>= 1;
                    }
                    return v;
                }
            };
        </script>
        <?php
    }
}
?>
