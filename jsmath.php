<?php
    include_once "common.php";
/*
php:
    function write_math_script();
javascript:
    function mathFunctionsListText();
    function mathDisplayFunctionList();
    function parseExpression(st);
    function checkExpression(expression, function (varname) );
    function calculateExpression(expression, function (varname) );
    function math_Expression_export(expression);
    function math_Expression_import(st);
*/

    $math_script_written = 0;

    function write_math_script() {
        global $math_script_written;

        if ($math_script_written > 0) return;
        $math_script_written = 1;
        write_common_script();
        ?>
        <script type="text/javascript">

            var MathClass = {
                Expression : {
                    lastparsed : "",
                    isopr: function (x) {
                        switch (x) {
                            case "+":
                            case "-":
                            case "*":
                            case "/":
                            case "=":
                            case "!":
                            case "&":
                            case "|":
                            case "%":
                            case ",":
                            case "<":
                            case ">":
                                return true;
                            default:
                                return false;
                        }
                    },
                    opr_priority : function (x) {
                        switch (x) {
                            case "(":
                                return 0;
                            case ",":
                                return 1;
                            case "&":
                            case "&&":
                            case "|":
                            case "||":
                                return 2;
                            case "=":
                            case "<":
                            case ">":
                            case "<=":
                            case ">=":
                            case "==":
                            case "!=":
                            case "<>":
                                return 3;
                            case "+":
                            case "-":
                                return 4;
                            case "*":
                            case "/":
                            case "%":
                                return 5;
                            case "!":
                                return 99998;
                            case "fconnector":
                                return 99999;
                        }
                    },
                    parse : function (st) {
                        var is = [], sx, sa, f1, pos, olds, startpos;
                        var buffer, stack, slen;
                        MathClass.Expression.lastparsed = "";
                        if (st === undefined) null;
                        if (st == null) return null;
                        olds = st;
                        pos = 0;
                        while (st != "") {
                            sx = st.substr(0, 1);
                            st = st.substr(1);
                            startpos = pos++;
                            if (st != "") sa = st.substr(0, 1); else sa = "";
                            if (sx == " ") continue;
                            if (sx == "\r") continue;
                            if (sx == "\n") continue;
                            if (sx == "\t") continue;
                            if (("0" <= sx) && (sx <= "9")) {   // number
                                f1 = 0;
                                while ((("0" <= sa) && (sa <= "9")) || (sa == ".")) {
                                    if (sa == ".") {
                                        if (f1 == 1) {
                                            MathClass.Expression.lastparsed = olds.substr(0, pos);
                                            return null;
                                        }
                                        f1 = 1;
                                    }
                                    sx += sa;
                                    if (st != "") {
                                        st = st.substr(1);
                                        sa = st.substr(0, 1);
                                        pos++;
                                    }
                                    else sa = "";
                                }
                                is.push({
                                    type: "number",
                                    startpos: startpos,
                                    endpos: pos,
                                    value: parseFloat(sx)
                                });
                            }
                            else if ((("a" <= sx) && (sx <= "z")) || (("A" <= sx) && (sx <= "Z")) || (sx == "_")) {     // variable / function
                                while ((("a" <= sa) && (sa <= "z")) || (("A" <= sa) && (sa <= "Z")) || (sa == "_") || (("0" <= sa) && (sa <= "9"))) {
                                    sx += sa;
                                    if (st != "") {
                                        st = st.substr(1);
                                        sa = st.substr(0, 1);
                                        pos++;
                                    }
                                    else sa = "";
                                }
                                is.push({
                                    type: "variable",
                                    startpos: startpos,
                                    endpos: pos,
                                    value: sx
                                });
                            }
                            else if (MathClass.Expression.isopr(sx)) {
                                while (MathClass.Expression.isopr(sa)) {
                                    sx += sa;
                                    if (st != "") {
                                        st = st.substr(1);
                                        sa = st.substr(0, 1);
                                        pos++;
                                    }
                                    else sa = "";
                                }
                                if (sx == "!") is.push({
                                    type: "number",
                                    startpos: startpos,
                                    endpos: startpos,
                                    value: 0
                                });
                                is.push({
                                    type: "opr",
                                    startpos: startpos,
                                    endpos: pos,
                                    value: sx
                                });
                            }
                            else if (sx == "(") {
                                if (is.length > 0) {
                                    if (is[is.length-1].type == "variable") {
                                        is[is.length-1].type = "function";
                                        is.push({
                                            type: "opr",
                                            startpos: pos,
                                            endpos: pos,
                                            value: "fconnector"
                                        });
                                    }
                                }
                                is.push({
                                    type: "opr",
                                    startpos: startpos,
                                    endpos: pos,
                                    value: sx
                                });
                            }
                            else if (sx == ")") {
                                is.push({
                                    type: "opr",
                                    startpos: startpos,
                                    endpos: pos,
                                    value: sx
                                });
                            }
                        }
                        buffer = [];
                        stack = [];
                        slen = 0;
                        for (i = 0; i < is.length; i++) {
                            if ((is[i].type != "variable") && (is[i].type != "number") && (is[i].type != "function")) {
                                if (slen > 0) {
                                    if (is[i].value == ")") {
                                        while (slen > 0) {
                                            if (stack[slen-1].value != "(") {
                                                buffer.push(stack[--slen]);
                                            }
                                            else {
                                                break;
                                            }
                                        }
                                        if (slen == 0) {
                                            MathClass.Expression.lastparsed = olds.substr(0, is[i].startpos+1);
                                            return null;
                                        }
                                        slen--;
                                    }
                                    else if (is[i].value == "(") {
                                        if (slen < stack.length) {
                                            stack[slen++] = is[i];
                                        }
                                        else {
                                            stack.push(is[i]);
                                            slen++;
                                        }
                                    }
                                    else {
                                        while (slen > 0) {
                                            if (MathClass.Expression.opr_priority(is[i].value) <= MathClass.Expression.opr_priority(stack[slen-1].value)) {
                                                buffer.push(stack[--slen]);
                                            }
                                            else {
                                                break;
                                            }
                                        }
                                        if (slen < stack.length) {
                                            stack[slen++] = is[i];
                                        }
                                        else {
                                            stack.push(is[i]);
                                            slen++;
                                        }
                                    }
                                }
                                else {
                                    stack = [is[i]];
                                    slen = 1;
                                }
                            }
                            else {
                                buffer.push(is[i]);
                            }
                        }
                        while (slen > 0) buffer.push(stack[--slen]);
                        for (i = 0; i < buffer.length; i++) {
                            if ((buffer[i].type == "variable") || (buffer[i].type == "number") || (buffer[i].type == "function")) {
                                if (slen < stack.length) {
                                    stack[slen++] = buffer[i];
                                }
                                else {
                                    stack.push(buffer[i]);
                                    slen++;
                                }
                            }
                            else {
                                sx = stack[slen-2];
                                sa = stack[slen-1];
                                slen -= 2;
                                switch (buffer[i].value) {
                                    case "!":
                                        stack[slen++] = {
                                            type: "!",
                                            params: [sa]
                                        };
                                        break;
                                    case ",":
                                        if (sx.type == "paramlist") {
                                            sx.params.push(sa);
                                            slen++;
                                        }
                                        else {
                                            stack[slen++] = {
                                                type: "paramlist",
                                                params: [sx, sa]
                                            };
                                        }
                                        break;
                                    case "fconnector":
                                        if (sa.type == "paramlist") {
                                            stack[slen++] = {
                                                type: "function",
                                                name: sx.value,
                                                params: sa.params
                                            };
                                        }
                                        else {
                                            stack[slen++] = {
                                                type: "function",
                                                name: sx.value,
                                                params: [sa]
                                            };
                                        }
                                        break;
                                    default:
                                        stack[slen++] = {
                                            type: buffer[i].value,
                                            params: [sx, sa]
                                        };
                                }
                            }
                        }
                        if (slen == 1) {
                            sx = {content: stack[0]};
                            sx.check = function (sx) {
                                return function (varfunc) {
                                    return MathClass.Expression.check(sx.content, varfunc);
                                };
                            } (sx);
                            sx.calc = function (sx) {
                                return function (varfunc) {
                                    return MathClass.Expression.calc(sx.content, varfunc);
                                };
                            } (sx);
                            stack = [];
                            return sx;
                        }
                        return null;
                    },
                    check : function (exp, varfunc) {
                        var i;
                        switch (exp.type) {
                            case "number":
                                return true;
                            case "variable":
                                return varfunc(exp.value);
                            case "function":
                                if (exp.params === undefined) return false;
                                for (i = 0; i < exp.params.length; i++) {
                                    if (MathClass.Expression.check(exp.params[i], varfunc) == false) return false;
                                }
                                switch (exp.name) {
                                    case "if":
                                        if (exp.params.length != 3) return false;
                                        break;
                                    case "pow":
                                    case "log":
                                        if (exp.params.length != 2) return false;
                                        break;
                                    case "sqr":
                                    case "exp":
                                    case "sqrt":
                                    case "ln":
                                        if (exp.params.length != 1) return false;
                                        break;
                                    default:
                                        return false;
                                }
                                return true;
                            case "!":
                            case "=":
                            case "==":
                            case "!=":
                            case "<>":
                            case ">":
                            case ">=":
                            case "<":
                            case "<=":
                            case "+":
                            case "-":
                            case "*":
                            case "/":
                            case "%":
                            case "&":
                            case "&&":
                            case "|":
                            case "||":
                                if (exp.params === undefined) return false;
                                for (i = 0; i < exp.params.length; i++) {
                                    if (MathClass.Expression.check(exp.params[i], varfunc) == false) return false;
                                }
                                return true;
                            default:
                                return false;
                        }
                    },
                    isvalid : function (expressionstring, varfunc) {
                        var x = MathClass.Expression.parse(expressionstring);
                        if (x == null) return false;
                        return MathClass.Expression.check(x.content, varfunc);
                    },
                    calc : function (exp, varfunc) {
                        var v;
                        switch (exp.type) {
                            case "number":
                                return exp.value;
                            case "variable":
                                return varfunc(exp.value);
                            case "function":
                                switch (exp.name) {
                                    case "if":
                                        if (MathClass.Expression.calc(exp.params[0], varfunc)) {
                                            return MathClass.Expression.calc(exp.params[1], varfunc);
                                        }
                                        else {
                                            return MathClass.Expression.calc(exp.params[2], varfunc);
                                        }
                                    case "sqr":
                                        v = MathClass.Expression.calc(exp.params[0], varfunc);
                                        return v*v;
                                    case "sqrt":
                                        return Math.sqrt(MathClass.Expression.calc(exp.params[0], varfunc));
                                    case "exp":
                                        return Math.exp(MathClass.Expression.calc(exp.params[0], varfunc));
                                    case "pow":
                                        return Math.pow(MathClass.Expression.calc(exp.params[0], varfunc), MathClass.Expression.calc(exp.params[1], varfunc));
                                    case "ln":
                                        return Math.log(MathClass.Expression.calc(exp.params[0], varfunc));
                                    case "log":
                                        return Math.log(MathClass.Expression.calc(exp.params[1], varfunc)) / Math.log(MathClass.Expression.calc(exp.params[0], varfunc));
                                    default:
                                        return NaN;
                                 }
                            case "!":
                                return !MathClass.Expression.calc(exp.params[0], varfunc);
                            case "=":
                            case "==":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) == MathClass.Expression.calc(exp.params[1], varfunc));
                            case "!=":
                            case "<>":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) != MathClass.Expression.calc(exp.params[1], varfunc));
                            case ">":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) > MathClass.Expression.calc(exp.params[1], varfunc));
                            case ">=":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) >= MathClass.Expression.calc(exp.params[1], varfunc));
                            case "<":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) < MathClass.Expression.calc(exp.params[1], varfunc));
                            case "<=":
                                return (MathClass.Expression.calc(exp.params[0], varfunc) <= MathClass.Expression.calc(exp.params[1], varfunc));
                            case "+":
                                return MathClass.Expression.calc(exp.params[0], varfunc) + MathClass.Expression.calc(exp.params[1], varfunc);
                            case "-":
                                return MathClass.Expression.calc(exp.params[0], varfunc) - MathClass.Expression.calc(exp.params[1], varfunc);
                            case "*":
                                return MathClass.Expression.calc(exp.params[0], varfunc) * MathClass.Expression.calc(exp.params[1], varfunc);
                            case "/":
                                return MathClass.Expression.calc(exp.params[0], varfunc) / MathClass.Expression.calc(exp.params[1], varfunc);
                            case "%":
                                return MathClass.Expression.calc(exp.params[0], varfunc) % MathClass.Expression.calc(exp.params[1], varfunc);
                            case "&":
                                return MathClass.Expression.calc(exp.params[0], varfunc) & MathClass.Expression.calc(exp.params[1], varfunc);
                            case "&&":
                                return MathClass.Expression.calc(exp.params[0], varfunc) && MathClass.Expression.calc(exp.params[1], varfunc);
                            case "|":
                                return MathClass.Expression.calc(exp.params[0], varfunc) | MathClass.Expression.calc(exp.params[1], varfunc);
                            case "||":
                                return MathClass.Expression.calc(exp.params[0], varfunc) || MathClass.Expression.calc(exp.params[1], varfunc);
                            default:
                                return NaN;
                        }
                    }
                }
            };

            function mathFunctionsListText() {
                var st = "<table border=\"0\"><tr><td valign=\"top\">";
                st += "<div class=\"tableclass\">"
                st += "<table>";
                st += "<tr><th> Công thức </th><th> Ý nghĩa </th></tr>";
                st += "<tr><td> sqr(a) </td><td> a bình phương </td></tr>";
                st += "<tr><td> sqrt(a) </td><td> căn bậc 2 của a </td></tr>";
                st += "<tr><td> exp(a) </td><td> e lũy thừa a </td></tr>";
                st += "<tr><td> pow(a,b) </td><td> a lũy thừa b </td></tr>";
                st += "<tr><td> ln(a) </td><td> logarithm tự nhiên của a </td></tr>";
                st += "<tr><td> log(a,b) </td><td> logarithm cơ số a của b </td></tr>";
                st += "</table></div>";
                st += "</td></tr></table>";
                return st;
            }

            var     mathDisplayTime;

            function mathCheckDisplayTimeThread() {
                mathDisplayTime--;
                if (mathDisplayTime > 0)
                    setTimeout("mathCheckDisplayTimeThread();", 100);
                else {
                    closeModal();
                }
            }

            function mathDisplayFunctionList() {
                var st = mathFunctionsListText();
                st += "<p></p><p align=\"center\"><a href=\"#\" style=\"text-decoration: none; color: blue;\" onclick=\"mathDisplayTime = 1; event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\">Ok</a></p>"
                mathDisplayTime = 50;
                showModal(st);
                setTimeout("mathCheckDisplayTimeThread();", 100);
            }

            var math_functionParamList = [
                ["pow", 2],
                ["exp", 1],
                ["log", 2],
                ["ln", 1],
                ["sqrt", 1],
                ["sqr", 1],
                ["if", 3]
            ];

            sort(math_functionParamList, function(a, b) {
                if (a[0].length < b[0].length) return -1;
                if (a[0].length > b[0].length) return -1;
                if (a[1] > b[1]) return -1;
                if (a[1] < b[1]) return 1;
                return 0;
            });

        </script>
        <?php
    }
?>
