<?php
    function write_MenuCategoriesPosition_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.MenuCategoriesPosition.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission       

jobdesc.MenuCategoriesPosition.loadMenu = function(tabAll, choice, host_all) {
    var holder, hostchild, oc;
    var titlepage = document.getElementById("title_page_init");
    holder = DOMElement.div({
        attrs: {
            style: {
                width: "100%",
                height:"100%",
                backgroundColor: "white",
            }
        }
    });
    switch (choice) {
        case 1:
            hostchild = {
                holder: holder,
                pagetitle: titlepage
            };
            tabAll.appendChild(holder)
            jobdesc.categoriesPosition.listInfoInit(hostchild, host_all)
            break;
        case 2:
            //to do nothing
            break;
        default:
            holder.innerHTML = "under construction (" + choice + ")";
            break;
    }
}

jobdesc.MenuCategoriesPosition.defineSize = window.innerWidth/4;

jobdesc.MenuCategoriesPosition.Container = function() {
    return DOMElement.div({
        attrs: {
            className: "all-build-list",
            style: {
                left: this.defineSize + 25 + "px",
                width: "calc(100% - " + (this.defineSize + 40) + "px)",
                position: "absolute",
                background: "white",
                marginLeft:"10px"
            }
        },
        children: []
    })
}

jobdesc.MenuCategoriesPosition.loadPage = function(container, host) {

    var containerTab = DOMElement.div({
        attrs: {
            style: {
                position: "absolute",
                width: this.defineSize - 10 + "px",
                height: "calc(100% - 10px)",
                marginLeft: "20px",
                marginTop: "10px",
            }
        },
        children: []
    });

    var containerList = jobdesc.MenuCategoriesPosition.Container();

    host.listEditor = [];
    host.checkSearch = [];
    host.tempPositions = [];

    host.containerTab = containerTab;
    host.containerList = containerList;


    host.editor = CKEDITOR;

    var resizer = DOMElement.div({
        attrs: {
            className: "common-resizer",
            style: {
                left: this.defineSize + 20 + "px"
            }
        }

    });
    var resizerView = DOMElement.div({
        attrs: {
            className: "view-resizer",
            style: {
                left: this.defineSize + 20 + "px"
            }
        }

    });
    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                height:"100%",
                position: "relative",
                border: "1px solid rgb(214, 214, 214)"
            }
        },
        children: [
            containerTab,
            containerList,
            resizerView,
            resizer,
        ]

    });



    absol.event.defineDraggable(resizer);

    var currentLeftWidth = this.defineSize;
    var needUpdateSizeList = [];

    resizer.on('begindrag', function(event) {
        resizer.addStyle('width', '305px');
        currentLeftWidth += event.moveDX;
        needUpdateSizeList = [];
    });

    resizer.on('enddrag', function(event) {
        currentLeftWidth += event.moveDX;
        resizer.removeStyle('width', '305px');
        this.addStyle('left', currentLeftWidth + 20 + 'px');
        resizerView.style.left = currentLeftWidth + 20 + 'px';
    });
    var lastDrag = new Date().getTime();
    resizer.on('drag', function(event) {
        this.addStyle('left', currentLeftWidth + event.moveDX + 20 - 150 + 'px');
        resizerView.style.left = currentLeftWidth + event.moveDX + 20 + 'px';
        containerTab.style.width = currentLeftWidth + event.moveDX - 10 + 'px';
        containerList.style.left = currentLeftWidth + event.moveDX + 25 + 'px';
        containerList.style.width = "calc(100% - " + (currentLeftWidth + event.moveDX + 40) + "px)";
        if(containerList.childNodes[0]!==undefined&&containerList.childNodes[0].childNodes[2]!==undefined)
        containerList.childNodes[0].childNodes[2].updateSize();
    });


    container.appendChild(
        DOMElement.div({
            attrs: {
                className: "common",
            },
            children: [
                containerRelative

            ]
        })
    )
    jobdesc.MenuCategoriesPosition.loadMenu(containerTab, 1, host);
}

jobdesc.MenuCategoriesPosition.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>