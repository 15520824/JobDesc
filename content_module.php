<?php
    function write_content_script()
    {
        global $prefix;
?>

<script type="text/javascript">
    "use strict";
    var contentModule = {};

    contentModule.makeCategoriesList = function(host){
        var i, index, templist;
        host.database.categories.getIndex = function(id){
            var i;
            for(i = 0; i < host.database.categories.items.length; i++){
                if (host.database.categories.items[i].id == id) return i;
            }
            return -1;
        }
        for(i = 0; i < host.database.categories.items.length; i++){
            host.database.categories.items[i].childrenList = [];
        }
        templist = [];
        for(i = 0; i < host.database.categories.items.length; i++){
            if (host.database.categories.items[i].parentid == 0) {
                templist.push(host.database.categories.items[i]);
            }
            else {
                index = host.database.categories.getIndex(host.database.categories.items[i].parentid);
                if(index != -1){
                    host.database.categories.items[index].childrenList.push(host.database.categories.items[i].id);
                    templist.push(host.database.categories.items[i]);
                }
            }
        }
        host.database.categories.items = templist;
    }
</script>

<?php } ?>
