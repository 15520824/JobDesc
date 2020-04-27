<?php
    function write_reporter_tasks_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission

jobdesc.reporter_tasks_information.tableCreate = function(host) {
    var x = DOMElement.table({
        attrs: {
            style: {
                width: "100%"
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
                        width: "calc((100% - 200px)/2)"
                    }
                },
                text: LanguageModule.text("title_name")
            },
            {
                text: LanguageModule.text("title_group_job")
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
        data: blackTheme.reporter_tasks.generateTableDataTasks(host)
    });
    host.tableCenter = x;
    if(jobdesc.reporter_tasks_information.hosts===undefined)
    jobdesc.reporter_tasks_information.hosts=[];
    jobdesc.reporter_tasks_information.hosts.push(host);
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

jobdesc.reporter_tasks_information.redrawTable = function(host) {
    var x;
    if(jobdesc.reporter_tasks_information.hosts===undefined)
    return;
    for(var i=0;i<jobdesc.reporter_tasks_information.hosts.length;i++){
    try{
        x = DOMElement.table({
        attrs: {
            style: {
                width: "100%"
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
                        width: "calc((100% - 200px)/2)"
                    }
                },
                text: LanguageModule.text("title_name")
            },
            {
                text: LanguageModule.text("title_group_job")
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
        data: blackTheme.reporter_tasks.generateTableDataTasks(jobdesc.reporter_tasks_information.hosts[i])
    });
    var parentNode = jobdesc.reporter_tasks_information.hosts[i].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_tasks_information.hosts[i].tableCenter = x;
    //to do update size
    }catch(err){
        console.log(err);
    }
    }
}

jobdesc.reporter_tasks_information.Container = function(host) {
    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                width: "calc(100% - 30px)/2",
                background: "white"
            }
        },
        children: [
            jobdesc.reporter_tasks_information.tableCreate(host)
        ]
    })
}

jobdesc.reporter_tasks_information.loadPage = function(container, host) {
    var containerList = jobdesc.reporter_tasks_information.Container(host);

    host.containerList = containerList;

    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                task: "relative",
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
    );
}

jobdesc.reporter_tasks_information.init = function(container, host) {
    this.loadPage(container, host);
}
</script>

<?php
}
?>