<?php
    function write_reporter_users_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission

jobdesc.reporter_users_information.tableCreate = function(host,id) {
    var x = DOMElement.table({
        attrs: {
            style: {
                width:"100%",
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
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_account")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_full_name")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_email")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_last_update")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_system_rights")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_decentralization")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_work")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_language")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_note")
            },
            {
                attrs: {
                    style: {
                        width: "40px"
                    }
                }
            }
        ],
        data: blackTheme.reporter_users.generateTableDataUsers(host)
    });
    host.tableCenter = x;
    if(jobdesc.reporter_users_information.hosts===undefined)
    jobdesc.reporter_users_information.hosts=[];
    jobdesc.reporter_users_information.hosts.push(host);
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

jobdesc.reporter_users_information.redrawTable = function(host,id) {
    var x;
    for(var i=0;i<jobdesc.reporter_users_information.hosts.length;i++){
        x = DOMElement.table({
        attrs: {
            style: {
                width:"100%",
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
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_account")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_full_name")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_email")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_last_update")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_system_rights")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_decentralization")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_work")
            },
            {
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_language")
            },
            {
                attrs: {
                    style: {
                        width: "200px"
                    }
                },
                text: LanguageModule.text("title_note")
            },
            {
                attrs: {
                    style: {
                        width: "40px"
                    }
                }
            }
        ],
        data: blackTheme.reporter_users.generateTableDataUsers(jobdesc.reporter_users_information.hosts[i])
    });
    var parentNode = jobdesc.reporter_users_information.hosts[i].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x)
    jobdesc.reporter_users_information.hosts[i].tableCenter = x;
    //to do update size
    }

}

jobdesc.reporter_users_information.Container = function(host) {
    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                width: "calc(100% - 30px)/2",
                background: "white"
            }
        },
        children: [
            jobdesc.reporter_users_information.tableCreate(host)
        ]
    })
}

jobdesc.reporter_users_information.loadPage = function(container, host) {

    var containerList = jobdesc.reporter_users_information.Container(host);

    host.containerList = containerList;

    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                position: "relative",
                width:"100%",
                overflowY: "auto",
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

jobdesc.reporter_users_information.init = function(container, host) {
    this.loadPage(container, host)
}
</script>

<?php
}
?>