<?php
    function write_reporter_positions_libary_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission

jobdesc.reporter_positions_libary_information.tableCreate = function(host) {
    var x = DOMElement.table({
        attrs: {
            style: {
                width:"100%"
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
                    }
                },
                text: LanguageModule.text("title_name")
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
        data: blackTheme.reporter_positions_libary.generateTableDataPositions(host)
    });
    host.tableCenter = x;
    if(jobdesc.reporter_positions_libary_information.hosts===undefined)
    jobdesc.reporter_positions_libary_information.hosts=[];
    jobdesc.reporter_positions_libary_information.hosts.push(host);
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

jobdesc.reporter_positions_libary_information.redrawTable = function() {
    var x;
    for(var i=0;i<jobdesc.reporter_positions_libary_information.hosts.length;i++){
    x = DOMElement.table({
        attrs: {
            style: {
                width:"100%"
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
                    }
                },
                text: LanguageModule.text("title_name")
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
        data: blackTheme.reporter_positions_libary.generateTableDataPositions(jobdesc.reporter_positions_libary_information.hosts[i])
    });
    var parentNode = jobdesc.reporter_positions_libary_information.hosts[i].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_positions_libary_information.hosts[i].tableCenter = x;
    //to do update size
    }

}

jobdesc.reporter_positions_libary_information.Container = function(host) {
    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                background: "white"
            }
        },
        children: [
            jobdesc.reporter_positions_libary_information.tableCreate(host)
        ]
    })
}

jobdesc.reporter_positions_libary_information.loadPage = function(container, host) {

    var containerList = jobdesc.reporter_positions_libary_information.Container(host);

    host.containerList = containerList;

    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                position: "relative",
                overflowY: "auto"
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

jobdesc.reporter_positions_libary_information.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>