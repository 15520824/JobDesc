<?php
include_once "common.php";
include_once "jsdropdown.php";
/*
php:
    function write_calendar_script();
    function new_calendar($id, $callbackFunction);
    function new_calendar_input($id, $callbackFunction);
javascript:
    function datetostring(d);
    function stringtodate(s); // return [date, y, m, d]
    function new_calendar(id, callbackFunction(date), curdate);
    function new_calendar_input(id, callbackFunction(date), curdate);
    function setCalendarTime(element, d_date);
    function setCalendarTime(element, y, m, d);
    function setCalendarInputTime(id, y, m, d);
    function isleap(y);
    function nDayOfMonth(y, m);
*/

$calendar_script_written = 0;


    function write_calendar_script() {
        global $calendar_script_written;
        if ($calendar_script_written == 1) return 0;
        $calendar_script_written = 1;
        write_common_script();
        dropdown_write_script();
        ?>
        <style>
            .calendar {
            }

            .calendar a {
                text-decoration: none;
                color: blue;
            }

            .calendar a:hover {color: red;}

            .calendar	table {
                  border-top: 1px solid #ddd;
                  border-left: 1px solid #ddd;
                  border-spacing: 0;
                  border-collapse: collapse;
                  background-color : rgba(255, 255, 255, 1);
              }

              .calendar th {
                  background-color : transparent;
                  background-image : none;
                  border-right: 1px solid #ddd;
                  border-bottom: 1px solid #ddd;
                  border-collapse: collapse;
                }

            .calendar td {
                  border-right: 1px solid #ddd;
                  border-bottom: 1px solid #ddd;
                  padding-top: 3px;
                  padding-bottom: 3px;
                  padding-left: 3px;
                  padding-right: 3px;
              }

            .calendar td:hover {
            	background-color: #BFBFBF;
        	}


          </style>
        <script type="text/javascript">

            var     calendarList = [];          //  [element, func, d_date, 0, id]
            var     calendarTempFunctionsList = [];

            function isleap(y) {
                if (y % 400 == 0) return 1;
                if (y % 4 != 0) return 0;
                if (y % 100 == 0) return 0;
                return 1;
            }

            function nDayOfMonth(y, m) {
                switch (m) {
                    case 4:
                    case 6:
                    case 9:
                    case 11:
                        return 30;
                    case 2:
                        return 28 + isleap(y);
                    default:    // 1, 3, 5, 7, 8, 10, 12
                        return 31;
                }
            }

            function setCalendarInputTime(id, y, m, d) {
                var i, d_date;
                if (id == "") return;
                if (m === undefined) {
                    d = y.getDate();
                    m = y.getMonth();
                    y = y.getFullYear();
                }
                for (i = 0; i < calendarList.length; i++) {
                    if (calendarList[i][4] == id) {
                        setCalendarTime(calendarList[i][0], y, m, d);
                        if (calendarList[i][1] != null) {
                            calendarList[i][1](new Date(y, m, d));
                        }
                        return;
                    }
                }
            }


            function calendarPickup(s, y, m, d) {
                if (m === undefined) {
                    d = y.getDate();
                    m = y.getMonth();
                    y = y.getFullYear();
                }
                calendarList[s][3] = 1;
                calendarList[s][2] = new Date(y, m, d);
                setCalendarTime(calendarList[s][0], y, m, d);
                if (calendarList[s][1] != null) calendarList[s][1](new Date(y, m, d));
            }

            function setCalendarTime(element, d_date, xm, xd) {
                var i, j, k, l, x, s, st, y, m, d, fdow;
                if (xm !== undefined) { //function setCalendarTime(element, y, m, d)
                    if (xd === undefined) xd = new Date().getDate();
                    x = nDayOfMonth(d_date, xm+1);
                    if (xd > x) xd = x;
                    d_date = new Date(d_date, xm, xd);
                }
                m = d_date.getMonth()+1;
                d = d_date.getDate();
                y = d_date.getFullYear();
                fdow = (new Date(y, m-1, 1).getDay() + 6) % 7;
                x = nDayOfMonth(y, m);
                for (s = 0; s < calendarList.length; s++) {
                    if (calendarList[s][0] == element) {
                        calendarList[s][2] = d_date;
                        st = "<div class=\"dropdown\" style=\"z-index: 201000;\">";
                        st += "<div id=\"calendar_dropdown_" + s + "\" class=\"dropdown-content\" style=\"text-align: left;\">";
                            st += "<table width=\"380\">";
                            st += "<tr>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 0, " + d + ");\">Tháng 1</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 1, " + d + ");\">Tháng 2</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 2, " + d + ");\">Tháng 3</a></td>";
                                st += "<td rowspan=\"4\">";
                                st += "<select onchange=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], parseInt(this.value, 10), " + (m-1) + ", " + d + ");\">";
                                for (i = y - 10; i <= y + 10; i++) {
                                    if (i == y) {
                                        st += "<option value=\"" + i + "\" selected>" + i + "</option>";
                                    }
                                    else {
                                        st += "<option value=\"" + i + "\">" + i + "</option>";
                                    }
                                }
                                st += "</select>";
                                st += "</td>";
                            st += "</tr>";
                            st += "<tr>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 3, " + d + ");\">Tháng 4</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 4, " + d + ");\">Tháng 5</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 5, " + d + ");\">Tháng 6</a></td>";
                            st += "</tr>";
                            st += "<tr>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 6, " + d + ");\">Tháng 7</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 7, " + d + ");\">Tháng 8</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 8, " + d + ");\">Tháng 9</a></td>";
                            st += "</tr>";
                            st += "<tr>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 9, " + d + ");\">Tháng 10</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 10, " + d + ");\">Tháng 11</a></td>";
                                st += "<td><a href=\"#\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); setCalendarTime(calendarList[" + s + "][0], " + y + ", 11, " + d + ");\">Tháng 12</a></td>";
                            st += "</tr>";
                            st += "</table>";
                        st += "</div></div>";
                        st += "<table border=\"0\">";
                            st += "<tr><th colspan=\"7\">";
                                st += "<table style=\"border: none;\" width=\"100%\"><tr>";
                                    st += "<th style=\"border: none;\" width=\"30\">";
                                    st += "<a href=\"#\" onclick=\"setCalendarTime(calendarList[" + s + "][0], new Date(";
                                    if (m == 1) {
                                        st += (y-1) + ", 11, " + d;
                                    }
                                    else {
                                        k = nDayOfMonth(y, m-1);
                                        if (d < k) k = d;
                                        st += y + ", " + (m-2) + ", " + k;
                                    }
                                    st += ")); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\" style=\"text-decoration: none; color: blue;\">" + inputvalue("<") + "</a>";
                                    st += "</th>";
                                    st += "<th style=\"border: none; min-width: 200px;\" align=\"center\">";
                                    st += "<a class=\"dropbtn\" href=\"#\" style=\"text-decoration: none; color: black; font-weight: bold;\" onclick=\"dropdownButtonFunction('calendar_dropdown_" + s + "'); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\">";
                                    st += " Tháng ";
                                    switch (m) {
                                        case 1:
                                            st += "Một";
                                            break;
                                        case 2:
                                            st += "Hai";
                                            break;
                                        case 3:
                                            st += "Ba";
                                            break;
                                        case 4:
                                            st += "Bốn";
                                            break;
                                        case 5:
                                            st += "Năm";
                                            break;
                                        case 6:
                                            st += "Sáu";
                                            break;
                                        case 7:
                                            st += "Bảy";
                                            break;
                                        case 8:
                                            st += "Tám";
                                            break;
                                        case 9:
                                            st += "Chín";
                                            break;
                                        case 10:
                                            st += "Mười";
                                            break;
                                        case 11:
                                            st += "Mười một";
                                            break;
                                        case 12:
                                            st += "Mười hai";
                                            break;
                                    }
                                    st += " " + y;
                                    st += "</a>";
                                    st += "</th>";
                                    st += "<th style=\"border: none;\" width=\"30\">";
                                    st += "<a href=\"#\" onclick=\"setCalendarTime(calendarList[" + s + "][0], new Date(";
                                    if (m == 12) {
                                        st += (y+1) + ", 0, " + d;
                                    }
                                    else {
                                        k = nDayOfMonth(y, m+1);
                                        if (d < k) k = d;
                                        st += y + ", " + m + ", " + k;
                                    }
                                    st += ")); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\" style=\"text-decoration: none; color: blue;\">" + inputvalue(">") + "</a>";
                                    st += "</th>";
                                st += "</tr></table>"
                            st += "</td></tr>";
                            st += "<tr>";
                                st += "<th align=\"center\">T2</th>";
                                st += "<th align=\"center\">T3</th>";
                                st += "<th align=\"center\">T4</th>";
                                st += "<th align=\"center\">T5</th>";
                                st += "<th align=\"center\">T6</th>";
                                st += "<th align=\"center\">T7</th>";
                                st += "<th align=\"center\">CN</th>";
                            st += "</tr>";
                            for (i = k = 0; k < x; ) {
                                st += "<tr>";
                                for (j = 0; j < 7; j++) {
                                    if (((k > 0) || (j == fdow)) && (k < x)) {
                                        k++;
                                        st += "<td align=\"center\"><a href=\"#\" onclick=\"calendarPickup(" + s + ", " + y + ", " + (m-1) + ", " + k + "); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\" style=\"text-decoration: none; color: ";
                                        if (k != d) {
                                            st += "blue;\">";
                                        }
                                        else {
                                            st += "red; font-weight: bold;\">";
                                        }
                                        st += k + "</a></td>";
                                    }
                                    else {
                                        st += "<td>&nbsp;</td>";
                                    }
                                }
                                st += "</td></tr>";
                            }
                        st += "<tr><th colspan=\"7\" align=\"center\"><a href=\"#\" onclick=\"calendarPickup(" + s + ", new Date()); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\" style=\"text-decoration: none; color: blue;\">Hôm nay</a></th></tr>";
                        st += "</table></div>";
                        element.innerHTML = st;
                        return;
                    }
                }
            }

            function initCalendar(element, func, d_date, id) {
                var i;
                if (d_date === undefined) d_date = new Date();
                if (id === undefined) id = "";
                for (i = 0; i < calendarList.length; i++) {
                    if (calendarList[i][0] == element) {
                        calendarList[i] = [element, func, d_date, 0, id];
                        setCalendarTime(element, d_date);
                        return;
                    }
                }
                calendarList.push([element, func, d_date, 0, id]);
                setCalendarTime(element, d_date);
            }

            var     calendar_lastid = 0;

            function calendarAutoID() {
                return "calendarAutoID_" + (++calendar_lastid);
            }

            function initCalendarInput(element, id, func, c_date) {
                var  a, k, cid = calendarAutoID();
                a = function (cid) {
                    return function(d_date) {
                               var inp = document.getElementsByTagName('input');
                               var i;
                               for (i = 0; i < inp.length; i++) {
                                   if (inp[i].parentElement == element) {
                                       inp[i].value = datetostring(d_date);
                                       if (func != null) func(d_date);
                                       dropdownButtonFunction(cid);
                                       return;
                                   }
                               }
                           };
                } (cid);
                k = calendarTempFunctionsList.length;
                calendarTempFunctionsList.push(a);
                if (c_date === undefined) c_date = new Date();
                st = "<div class=\"dropdown\" style=\"z-index: 200999;\">";
                st += "<div id=\"" + cid + "\" class=\"dropdown-form\" style=\"text-align: left;\">";
                st += "<div class=\"calendar\"><img src=\"./images/blank.png\" onload=\"initCalendar(this.parentElement, calendarTempFunctionsList[" + k + "], new Date(" + c_date.getTime() + "), Base64.decode('" + Base64.encode(id) + "'));\"/></div>";
                st += "</div></div>";
                st += "<input";
                if (id != "") st += " id=\"" + id + "\"";
                st += "type=\"text\" style=\"text-align: center;\" class=\"dropbtn\" size=\"12\" value=\"" + inputvalue(datetostring(c_date)) + "\" onclick=\"dropdownButtonFunction('" + cid + "');\" readonly/>";
                element.innerHTML = st;
            }

            function new_calendar(id, callbackFunction, curdate) {
                var k, st;
                st = "<div";
                if (id != "") st += " id=\"" + id + "\"";
                if (callbackFunction === undefined) {
                    callbackFunction = null;
                    curdate = new Date();
                }
                else {
                    if (curdate === undefined) curdate = new Date();
                }
                if (callbackFunction != null) {
                    k = calendarTempFunctionsList.length;
                    calendarTempFunctionsList.push(callbackFunction);
                    st += " class=\"calendar\"><img src=\"./images/blank.png\" onload=\"initCalendar(this.parentElement, calendarTempFunctionsList[" + k + "], new Date(" + curdate.getTime() + "));\"/></div>";
                }
                else {
                    st += " class=\"calendar\"><img src=\"./images/blank.png\" onload=\"initCalendar(this.parentElement, null, new Date(" + curdate.getTime() + "));\"/></div>";
                }
                return st;
            }

            function new_calendar_input(id, callbackFunction, curdate) {
                if (!window.new_calendar_input_warnig){
                    window.new_calendar_input_warnig = true;
                    console.warn("[deprecated] function new_calendar_input");
                    
                }
                if (callbackFunction === undefined) {
                    callbackFunction = null;
                    curdate = new Date();
                }
                else {
                    if (curdate === undefined) curdate = new Date();
                }
               
               var t = {
                   tag:'calendar-input',
                   attr:{id:id},
                   data:{
                       value:curdate
                   },
                   on:{
                       
                   }
               };
               if (callbackFunction){
                   t.on.changed = callbackFunction
               } 
               
                st = absol._HTML(t);
                return st;
            }

            function stringtodate(s) {
                var y, m, d, k;
                k = s.indexOf("/");
                if (k == -1) return null;
                d = parseInt(s.substr(0, k), 10);
                s = s.substr(k+1);
                k = s.indexOf("/");
                if (k == -1) return null;
                m = parseInt(s.substr(0, k), 10);
                s = s.substr(k+1);
                k = s.indexOf("/");
                if (k == -1) return null;
                y = parseInt(s.substr(0, k), 10);
                if ((m > 12) || (m < 1)) return null;
                if ((d < 1) || (d > nDayOfMonth(y, m))) return null;
                return [new Date(y, m-1, d), y, m, d];
            }

            function datetostring(d) {
                var s;
                s = "" + (d.getMonth()+1);
                if (s.length < 2) s = "0" + s;
                s = d.getDate() + "/" + s;
                if (s.length < 5) s = "0" + s;
                return s + "/" + d.getFullYear();
            }

        </script>
        <?php

        function new_calendar($id, $callbackFunction) {
            if ($callbackFunction == "") {
                echo "<div id=\"".$id."\" class=\"calendar\"><img src=\"./images/blank.png\" onload=\"initCalendar(this.parentElement, null);\"/></div>";
            }
            else {
                echo "<div id=\"".$id."\" class=\"calendar\"><img src=\"./images/blank.png\" onload=\"initCalendar(this.parentElement, ".$callbackFunction.");\"/></div>";
            }
        }

        function new_calendar_input($id, $callbackFunction) {
            if (($callbackFunction != "") && ($callbackFunction != null)) {
                echo "<div><img src=\"./images/blank.png\" onload=\"initCalendarInput(this.parentElement, '".$id."', ".$callbackFunction.");\"/></div>";
            }
            else {
                echo "<div><img src=\"./images/blank.png\" onload=\"initCalendarInput(this.parentElement, '".$id."', null);\"/></div>";
            }
        }

  }
