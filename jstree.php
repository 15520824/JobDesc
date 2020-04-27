<?php
/*
php:
  function tree_getIndex($writeout);
  function tree_write_script();
  function tree_exportData($tableName, $parentIdColumnName, $nameColumnName, optional $condition);
javascript:
  function tree_registerIndex(index, div_id, root, onclickFunction(id))
  function tree_parseData(data);
  function tree_setComboBoxData(combobox_id, root)

input node format: [id, name, children node...]
working node format: [id, name, path, idpath, expand, children node...]
*/
include_once "common.php";
include_once "connection.php";

$tree_script_written = 0;
$tree_maxIndex = 0;

function tree_getIndex($writeout) {
  global $tree_maxIndex;
  if ($writeout) echo $tree_maxIndex;
  return $tree_maxIndex++;
}

function tree_write_script() {
  global $tree_script_written;
  if ($tree_script_written == 1) return 0;
  $tree_script_written = 1;
  write_common_script();
  /*
    tree_list[index] format: [working_root_node, div_id, onclickFunction(id), hoving_node_id, selecting_node_id]
  */
  ?>
  <script type="text/javascript">
    var tree_list = [];

    function tree_registerIndex(index, div_id, root, onclickFunction) {
      if (onclickFunction === undefined) onclickFunction = null;
      while (tree_list.length <= index) tree_list.push(0);
      tree_list[index] = [generateTreeNode(root, "", ""), div_id, onclickFunction, -1, -1];
      tree_list[index][0][4] = 1;
      var st = generateTreeText(index, tree_list[index][0]);
      var x = document.getElementById(div_id);
      if (x != null) x.innerHTML = st;
    }

    function generateTreeNode(root, path, idpath) {
      var retval = [root[0], root[1], path, idpath, 0];
      var i;
      if (root.length > 2) {
        for (i = 2; i < root.length; i++) {
          retval.push(generateTreeNode(root[i], path + "/" + root[i][1], idpath + "/" + root[i][0]));
        }
      }
      return retval;
    }

    function makeNodeText(index, node) {
      var st = "<a href=\"#\" style=\"text-decoration: none;\"";
      st = st + " onmousedown=\"treeMouseClick(" + index + ", " + node[0] + "); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\"";
      st = st + " onMouseOver=\"treeMouseMove(" + index + ", " + node[0] + "); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\">";
      if (node[0] == tree_list[index][4]) {
        st = st + "<font color=\"red\" style=\"font-weight: bold;\">" + node[1] + "</font>";
      }
      else {
        if (node[0] == tree_list[index][3]) st = st + "<font color=\"blue\" style=\"font-weight: normal;\">" + node[1] + "</font>";
        else st = st + "<font color=\"black\" style=\"font-weight: normal;\">" + node[1] + "</font>";
      }
      st = st + "</a>";
      return st;
    }

    function treeTextRedraw(index, node) {
      var i;
      var x = document.getElementById("tree_divt_" + index + "_" + node[0]);
      if (x != null) x.innerHTML = makeNodeText(index, node);
      if (node.length > 5) {
        for (i = 5; i < node.length; i++) {
          treeTextRedraw(index, node[i]);
        }
      }
    }

    function treeMouseMove(index, id) {
      tree_list[index][3] = id;
      treeTextRedraw(index, tree_list[index][0]);
    }

    function treeMouseClick(index, id) {
     if (tree_list[index][2] != null) {
        if (tree_list[index][2](id) == 0) tree_list[index][4] = id;
      }
      else {
        tree_list[index][4] = id;
      }
      treeTextRedraw(index, tree_list[index][0]);
    }

    function treeFindNodeById(node, id) {
      var x;
      var i;
      if (node[0] == id) return node;
      if (node.length <= 5) return null;
      for (i = 5; i < node.length; i++) {
        x = treeFindNodeById(node[i], id);
        if (x) return x;
      }
      return null;
    }

    function treeNodeToggle(index, id) {
      var x = treeFindNodeById(tree_list[index][0], id);
      if (x[4] == 0) x[4] = 1; else x[4] = 0;
      var q = document.getElementById("treediv_" + index + "_" + id);
      if (q != null) q.innerHTML = generateTreeText(index, x);
    }

    function generateTreeText(index, node) {
      var i;
      var st = "<div id=\"treediv_" + index + "_" + node[0] + "\">";
      st = st + "<table border=\"0\">";
      st = st + "<tr><td width=\"20\">";
      if (node.length > 5) {
        st = st + "<a href=\"#\" style=\"text-decoration:none;\" onmousedown=\"treeNodeToggle(" + index + ", " + node[0] + "); event.preventDefault ? event.preventDefault() : event.returnValue = false; return false;\"><font color=\"black\">";
        if (node[4] == 1) {
          st = st + "[-]";
        }
        else {
          st = st + "[+]";
        }
        st = st + "</font></a></td><td>";
      }
      else {
        st = st + "</td><td>";
      }
      st = st + "<div id=\"tree_divt_" + index + "_" + node[0] + "\">" + makeNodeText(index, node) + "</div></td></tr>";
      if ((node.length > 5) && (node[4] == 1)) {
        st = st + "<tr><td></td><td>";
        for (i = 5; i < node.length; i++) {
          st = st + generateTreeText(index, node[i]);
        }
        st = st + "</td></tr>";
      }
      st = st + "</table></div>";
      return st;
    }

    function tree_parseData(data) {
      var k;
      var fid = parseInt(data.substr(0, k = data.indexOf(":")));
      data = data.substr(k+1);
      var fname = data.substr(0, k = data.indexOf(":"));
      data = data.substr(k+1);
      var fchild = parseInt(data.substr(0, k = data.indexOf(":")));
      data = data.substr(k+1);
      var root = [fid, Base64.decode(fname)];
      if (fchild == 0) return root;
      var nodestack = [root];
      var lenstack = [fchild];
      var pstack = [0];
      var ns = 1;
      var x;
      var xnode;
      while (ns > 0) {
        if (pstack[ns-1] < lenstack[ns-1]) {
          fid = parseInt(data.substr(0, k = data.indexOf(":")));
          data = data.substr(k+1);
          fname = data.substr(0, k = data.indexOf(":"));
          data = data.substr(k+1);
          fchild = parseInt(data.substr(0, k = data.indexOf(":")));
          data = data.substr(k+1);
          xnode = [fid, Base64.decode(fname)];
          nodestack[ns-1].push(xnode);
          pstack[ns-1]++;
          if (fchild > 0) {
            if (nodestack.length == ns) nodestack.push(xnode); else nodestack[ns] = xnode;
            if (lenstack.length == ns) lenstack.push(fchild); else lenstack[ns] = fchild;
            if (pstack.length == ns) pstack.push(xnode); else pstack[ns] = 0;
            ns++;
          }
        }
        else ns--;
      }
      return root;
    }

    function tree_setComboBoxData(combobox_id, root) {
        var x = document.getElementById(combobox_id);
        if (x == null) return;
        while (x.length > 0) x.remove(x.length-1);
        var nodestack = [root];
        var deepstack = [0];
        var ns = 1;
        var cnode;
        var cdepth;
        var st;
        var i;
        while (ns > 0) {
          var option = document.createElement("option");
          cnode = nodestack[--ns];
          cdepth = deepstack[ns];
          option.value = cnode[0];
          st = "";
          for (i = 0; i < cdepth; i++) st = st + "&nbsp;";
          option.innerHTML = st + inputvalue(cnode[1]);
          x.add(option);
          if (cnode.length > 2) {
            for (i = cnode.length-1; i >= 2; i--) {
              if (nodestack.length == ns) nodestack.push(cnode[i]); else nodestack[ns] = cnode[i];
              if (deepstack.length == ns) deepstack.push(cdepth + 4); else deepstack[ns] = cdepth + 4;
              ns++;
            }
          }
        }

    }
  </script>
  <?php
}
  function tree_exportData($tableName, $parentIdColumnName, $nameColumnName, $condition) {
    $st = "SELECT ID, ".$parentIdColumnName.", ".$nameColumnName." FROM ".$tableName;
    if (!isset($condition)) $condition = "";
    if ($condition != "") $st .= " WHERE (".$condition.") ORDER BY ".$nameColumnName;

    $result = mysql_query($st);
		$k = 1;
		$tid[0] = 0;
		$pid[0] = -1;
    $tname[0] = "";
		$childcount[0] = 0;
		while ($row = mysql_fetch_row($result)) {
			$tid[$k] = intval($row[0]);
			$pid[$k] = intval($row[1]);
			$tname[$k] = safeSQL_dec($row[2]);
			$childcount[$k] = 0;
			$k++;
		}
		$h = $k;
    $ns = 1;
    $s[0] = 0;
    while ($ns > 0) {
        $ns--;
        $x = $s[$ns];
        echo $tid[$x].":".base64_encode($tname[$x]).":";
        $k = 0;
        for ($i = $h-1; $i > 0; $i--) {
          if ($pid[$i] == $tid[$x]) {
            $s[$ns++] = $i;
            $k++;
          }
        }
        echo $k.":";
    }
  }
?>
