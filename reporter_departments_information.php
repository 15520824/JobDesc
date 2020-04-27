<?php
    function write_reporter_departments_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.reporter_departments_information.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission
jobdesc.reporter_departments_information.tableCreate = function(host) {
    var content=[]
    for (var i = 0; i < data_module.departmentsList.items.length; i++){
        if (data_module.departmentsList.items[i].parentid == 0) content.push(data_module.departmentsList.items[i].id);
    }
    var x = DOMElement.treetable({
        attrs: {
            style: {
                width: "100%"
            },
            className:"nth",
        },
        backgroundcolor: "white",
        backgroundcolor2: "#efefef",
        header: [
            LanguageModule.text("title_department"),
            LanguageModule.text("title_code"),
            {}
        ],
        data: blackTheme.reporter_departments.generateTableDataDepartment(host,content,content[0])
    });
    host.tableCenter = x;
    if(jobdesc.reporter_departments_information.hosts===undefined)
    jobdesc.reporter_departments_information.hosts=[];
    jobdesc.reporter_departments_information.hosts.push(host);
    return DOMElement.div({
        attrs: {
            className: "KPIsimpletableclass row2colors KPItablehover",
            style: {
                width: "100%"
            }
        },
        children: [x],
    })
}

jobdesc.reporter_departments_information.redrawTable = function() {
    var x;
    for(var j=0;j<jobdesc.reporter_departments_information.hosts.length;j++){
    var content=[]
    for (var i = 0; i < data_module.departmentsList.items.length; i++){
        if (data_module.departmentsList.items[i].parentid == 0) content.push(data_module.departmentsList.items[i].id);
    }
    var x = DOMElement.treetable({
        attrs: {
            style: {
                width: "100%"
            },
            className:"nth",
        },
        backgroundcolor: "white",
        backgroundcolor2: "#efefef",
        backgroundcolor3: "#bfbfbf",
        header: [
            LanguageModule.text("title_department"),
            LanguageModule.text("title_code"),
            {}
        ],
        data: blackTheme.reporter_departments.generateTableDataDepartment(jobdesc.reporter_departments_information.hosts[j],content,content[0])
    });
    var parentNode = jobdesc.reporter_departments_information.hosts[j].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_departments_information.hosts[j].tableCenter = x;
    //to do update size
    }
}

jobdesc.reporter_departments_information.defineSize = window.innerWidth/4;

jobdesc.reporter_departments_information.Container = function() {
    return DOMElement.div({
        attrs: {
            className: "all-build-list",
            style: {
                left: this.defineSize + 25 + "px",
                width: "calc(100% - " + (this.defineSize + 30) + "px)",
                position: "absolute",
                background: "white",
                height: "100%",
                overflowY: "auto",
                marginLeft: 0,
            }
        },
        children: []
    })
}
jobdesc.reporter_departments_information.loadPage = function(container, host) {
    var containerTab = DOMElement.div({
        attrs: {
            style: {
                position: "absolute",
                width: this.defineSize - 10 + "px",
                height: "calc(100% - 13px)",
                marginLeft: "20px",
                marginTop: "10px",
                overflowY: "auto",
            }
        },
        children: [
            jobdesc.reporter_departments_information.tableCreate(host)
        ]
    });

    var containerList = jobdesc.reporter_departments_information.Container();


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
            resizer
        ]

    });



    absol.event.defineDraggable(resizer);

    var currentLeftWidth = this.defineSize;
    var needUpdateSizeList = [];

    resizer.on('begindrag', function(event) {
        resizer.addStyle('width', '305px');
        currentLeftWidth += event.moveDX;
        needUpdateSizeList = [];
        // absol.$('selectbox', containerTab, function(e){
        //     if (e.getComputedStyleValue('display') == 'block'){
        //         needUpdateSizeList.push(e);
        //     }
        // } );
    });

    resizer.on('enddrag', function(event) {
        resizer.removeStyle('width', '305px');
        currentLeftWidth += event.moveDX;
        this.addStyle('left', currentLeftWidth + 20 + 'px');
        resizerView.style.left = currentLeftWidth + 20 + 'px';
    });

    resizer.on('drag', function(event) {
        this.addStyle('left', currentLeftWidth + event.moveDX + 20 + 'px');
        resizerView.style.left = currentLeftWidth + event.moveDX + 20 + 'px';
        containerTab.style.width = currentLeftWidth + event.moveDX - 10 + 'px';
        containerList.style.left = currentLeftWidth + event.moveDX + 25 + 'px';
        containerList.style.width = "calc(100% - " + (currentLeftWidth + event.moveDX + 30) + "px)";
        // needUpdateSizeList.forEach(function(e){
        //     e.addStyle('width',  currentLeftWidth + event.moveDX-35+ 'px');
        //     //e.requestUpdateSize();
        // })
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
}

jobdesc.reporter_departments_information.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>