<?php
include_once "common.php";
include_once "prefix.php";
include_once "connection.php";
include_once "jsencoding.php";

function getFieldType($name) {
    $typelist = array (
        array("long" => "varchar", "short" => "vc"),
        array("long" => "text", "short" => "t"),
        array("long" => "int", "short" => "i"),
        array("long" => "decimal", "short" => "i"),
        array("long" => "double", "short" => "f"),
        array("long" => "float", "short" => "f"),
        array("long" => "date", "short" => "d"),
        array("long" => "time", "short" => "d"),
        array("long" => "datetime", "short" => "d")
    );
    $n = sizeof($typelist);
    for ($i = 0; $i < $n; $i++) {
        if (strcasecmp($name, $typelist[$i]["long"]) == 0) return $typelist[$i]["short"];
        if (stristr($name, $typelist[$i]["long"]) !== FALSE) return $typelist[$i]["short"];
    }
    return "";
}

function makeCacheFile($fname, &$data, $partno, $signature) {
    global $conn, $tablename, $prefix;
    $f = fopen("cache/".$fname.".js", "w");
    fwrite($f, "EncodingClass.worker.toVariable(\"");
    fwrite($f, EncodingClass::fromVariable($data));
    fwrite($f, "\", function(retval) {data_module.tempList[\"".$fname."\"] = retval;});");
    fclose($f);
    $query = "INSERT INTO ".$prefix."cached_data (tablename, profileid, partno, signature) VALUES (\"".$tablename."\", 0, ".$partno.", \"".$signature."\")";
    mysqli_query($conn, $query);
}

session_start();
// if (!isset($_SESSION[$prefixhome."userid"])) {
//     echo "Not logged in!";
//     exit();
// }

// if (!isset($_POST["uk"])) {
//     echo "No privilege!";
//     exit();
// }

// if ($_POST["uk"] != md5($_SESSION[$prefixhome."username"])) {
//     echo "No privilege!";
//     exit();
// }

// if (!isset($_POST["index"])) {
//     echo "No index!";
//     exit(0);
// }

$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    echo "Can not connect to database!";
    exit(0);
}
$index = intval($_POST["index"]);

switch ($index) {
    case 0:
        $tablename = "categories";
        break;
    case 1:
        $tablename = "departments";
        break;
    case 2:
        $tablename = "global_configs";
        break;
    case 3:
        $tablename = "positions";
        break;
    case 4:
        $tablename = "positions_alternative";
        break;// thanyen
    case 9:
        $tablename = "tasks";
        break;
    case 10:
        $tablename = "tasks_content";
        break;
}

$query = "SELECT UNIX_TIMESTAMP(`UPDATE_TIME`) FROM information_schema.tables WHERE (TABLE_SCHEMA = \"".$dbname."\") AND (TABLE_NAME = \"".$prefix.$tablename."\")";

$result = mysqli_query($conn, $query);
if ($result) {
    if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        $timestamp = intval($row[0]);
    }
    else {
        echo "Database/Table not found!";
        exit(0);
    }
}
else {
    echo "Database error (0)!";
    exit(0);
}

mysqli_select_db($conn, $dbname);
$query = "SELECT `content` FROM ".$prefix."cached WHERE (tablename=\"".$tablename."\") AND (profileid=0) AND (lastupdated=".$timestamp.")";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Database error (1)!";
    echo $query;
    exit(0);
}
if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
    echo "ok";
    EncodingClass::echo_x($row[0]);
    exit(0);
}
$query = "SELECT `partno`, `signature` FROM ".$prefix."cached_data WHERE (tablename=\"".$tablename."\") AND (profileid=0) ORDER BY partno, signature";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Database error (2)!";
    exit(0);
}
$cachedfile = array();
$lastpart = -1;
$n = -1;
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
    $p = intval($row[0]);
    if ($p != $lastpart) {
        $lastpart = $p;
        while ($n < $p) {
            array_push($cachedfile, array());
            $n++;
        }
    }
    $cachedfile[$n][$row[1]] = TRUE;
}

$result = mysqli_query($conn, 'DESCRIBE '.$prefix.$tablename);
if (!$result) {
    echo "Database error (3)!";
    exit(0);
}
$field_name = array();
$field_type = array();
$scode_type = array();
$nfield = 0;

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $field_name[$nfield] = strtolower($row["Field"]);
    $field_type[$nfield] = strtolower($row["Type"]);
    if (strlen($field_name[$nfield]) == 0) continue;
    if (strlen($field_type[$nfield]) == 0) continue;
    $scode_type[$nfield] = getFieldType($field_type[$nfield]);
    $nfield++;
}

if ($nfield > 0) {
    $query = "SELECT ";
    for ($i = 0; $i < $nfield; $i++) {
        if ($i > 0) $query .= ", ";
        if (strcmp($scode_type[$i], "d") == 0) {
            $query .= "UNIX_TIMESTAMP(`".$field_name[$i]."`)";
        }
        else {
            $query .= "`".$field_name[$i]."`";
        }
    }
    $query .= " FROM `".$prefix.$tablename."` ORDER BY id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Database error (4)!";
        echo $query;
        exit(0);
    }
    $content = array();
    $n = 0;
    $p = 0;
    $retval = array();
    $s = "";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        for ($i = 0; $i < $nfield; $i++) {
            if (strcmp($scode_type[$i], "i") == 0) {
                $retval[$n][$field_name[$i]] = intval($row[$i]);
            }
            else if (strcmp($scode_type[$i], "d") == 0) {
                $ts = intval($row[$i]);
                $retval[$n][$field_name[$i]] = new DateTime("@$ts");
            }
            else if (strcmp($scode_type[$i], "f") == 0) {
                $retval[$n][$field_name[$i]] = floatval($row[$i]);
            }
            else {
                $retval[$n][$field_name[$i]] = strval($row[$i]);
            }
            $s .= $row[$i];
        }
        $n++;
        if ($n == 256) {
            $s = md5($s);
            $is = FALSE;
            if (isset($cachedfile[$p])) {
                if (isset($cachedfile[$p][$s])) {
                    $is = TRUE;
                }
            }
            if (!$is) makeCacheFile($tablename."_0_".$p."_".$s, $retval, $p, $s);
            array_push($content, $tablename."_0_".$p."_".$s);
            $p++;
            $n = 0;
            $retval = array();
            $s = "";
        }
    }
    if ($n > 0) {
        $s = md5($s);
        $is = FALSE;
        if (isset($cachedfile[$p])) {
            if (isset($cachedfile[$p][$s])) {
                $is = TRUE;
            }
        }
        if (!$is) makeCacheFile($tablename."_0_".$p."_".$s, $retval, $p, $s);
        array_push($content, $tablename."_0_".$p."_".$s);
    }
    if (($n > 0) || ($p > 0)) {
        $content = EncodingClass::fromVariable($content);
    }
    else {
        $content = EncodingClass::fromVariable(array());
    }
    $query = "INSERT INTO ".$prefix."cached (`tablename`, `profileid`, `lastupdated`, `content`) VALUES (\"".$tablename."\", 0, ".$timestamp.", \"".$content."\")";
    mysqli_query($conn, $query);
}
else {
    $content = EncodingClass::fromVariable(array());
}

echo "ok";
echo_x($content);
exit(0);
?>
