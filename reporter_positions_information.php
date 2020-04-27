<?php
    function write_reporter_positions_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission

jobdesc.reporter_positions_information.tableCreate = function(host,id) {
    var x = DOMElement.table({
        attrs: {
            style: {
                margin:"10px",
                width:"calc(100% - 20px)"
            },
            className:"nth",
        },
        header: [{
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_STT")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_name")
            },
            {
                attrs: {},
                text: LanguageModule.text("title_department")
            },
            {
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_code")
            },
            // {
            //     attrs: {style: {width: "300px"}},
            //     text: LanguageModule.text("title_note")
            // },
            {
                attrs: {
                    style: {
                        width: "40px"
                    }
                }
            }
        ],
        data: blackTheme.reporter_positions.generateTableDataPositions(host,id)
    });
    host.tableCenterChild = x;
    if(jobdesc.reporter_positions_information.hosts===undefined)
    jobdesc.reporter_positions_information.hosts=[];
    jobdesc.reporter_positions_information.hosts.push(host);
    return DOMElement.div({
        attrs: {
            className: "KPIsimpletableclass row2colors KPItablehover",
            style: {
                width: "100%"
            }
        },
        children: [x]
    })
}

jobdesc.reporter_positions_information.redrawTable = function(host,id) {
    var x;
    if(jobdesc.reporter_positions_information.hosts===undefined)
    return;
    for(var i=0;i<jobdesc.reporter_positions_information.hosts.length;i++){
    x = DOMElement.table({
        attrs: {
            style: {
                margin:"10px",
                width:"calc(100% - 20px)"
            },
            className:"nth",
        },
        header: [{
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_STT")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_name")
            },
            {
                attrs: {},
                text: LanguageModule.text("title_department")
            },
            {
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_code")
            },
            // {
            //     attrs: {style: {width: "300px"}},
            //     text: LanguageModule.text("title_note")
            // },
            {
                attrs: {
                    style: {
                        width: "40px"
                    }
                }
            }
        ],
        data: blackTheme.reporter_positions.generateTableDataPositions(jobdesc.reporter_positions_information.hosts[i],id)
    });
    var parentNode = jobdesc.reporter_positions_information.hosts[i].tableCenterChild.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_positions_information.hosts[i].tableCenterChild = x;
    //to do update size
    }

}

jobdesc.reporter_positions_information.Container = function(host) {
    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                width: "100%",
                background: "white"
            }
        },
        children: [
            jobdesc.reporter_positions_information.tableCreate(host)
        ]
    })
}

jobdesc.reporter_positions_information.loadPage = function(container, host) {

    var containerList = jobdesc.reporter_positions_information.Container(host);

    host.containerList = containerList;

    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                position: "relative",
                background: "rgb(247, 246, 246)",
                border: "1px solid rgb(214, 214, 214)",
                overflowY: "auto",
                height:"100%",
            }
        },
        children: [
            containerList,
        ]

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

jobdesc.reporter_positions_information.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>