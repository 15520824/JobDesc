<?php
    function write_reporter_categories_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission

jobdesc.reporter_categories_information.tableCreate = function(host) {
    var x = DOMElement.table({
        attrs: {
            style: {
                width: "100%"
            },
            className:"nth"
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
                text: LanguageModule.text("title_description")
            },
            {
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_version")
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
        data: blackTheme.reporter_categories.generateTableDataCategories(host)
    });
    host.tableCenter = x;
    if(jobdesc.reporter_categories_information.hosts===undefined)
    jobdesc.reporter_categories_information.hosts=[];
    jobdesc.reporter_categories_information.hosts.push(host);
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

jobdesc.reporter_categories_information.redrawTable = function() {
    var x;
    for(var i=0;i<jobdesc.reporter_categories_information.hosts.length;i++){
        x = DOMElement.table({
        attrs: {
            style: {
                width: "100%"
            },
            className:"nth"
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
                text: LanguageModule.text("title_description")
            },
            {
                attrs: {
                    style: {
                        width: "80px"
                    }
                },
                text: LanguageModule.text("title_version")
            },
            {
                attrs: {
                    style: {
                        width: "40px"
                    }
                }
            }
        ],
        data: blackTheme.reporter_categories.generateTableDataCategories(jobdesc.reporter_categories_information.hosts[i])
    });
    var parentNode = jobdesc.reporter_categories_information.hosts[i].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_categories_information.hosts[i].tableCenter = x;
    //to do update size
    }
}

jobdesc.reporter_categories_information.Container = function(host) {
    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                background: "white",
            }
        },
        children: [
            jobdesc.reporter_categories_information.tableCreate(host)
        ]
    })
}

jobdesc.reporter_categories_information.loadPage = function(container, host) {

    var containerList = jobdesc.reporter_categories_information.Container(host);

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

jobdesc.reporter_categories_information.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>