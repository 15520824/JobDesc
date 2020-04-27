<?php
    function write_reporter_information_script() {
        global $prefix;
?>
<script type="text/javascript">
// jobdesc.generalInformation.index = 0;
//
//    state 
//    0:state information 
//    1:state Mission
jobdesc.reporter_information.defineSize=window.innerWidth/2;

jobdesc.reporter_information.tableCreate = function(host) {
    var x = DOMElement.table({
        attrs: {
            style: {
                width: "100%",
                
            },
            className: "nth"
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
                        width: "300px"
                    }
                },
                text: LanguageModule.text("title_name_company")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_department")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_position")
            },
            {
                attrs: {
                    style: {
                        width: "300px"
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
        data: blackTheme.reporter.generateTableData(host)
    });
    host.tableCenter = x;
    if(jobdesc.reporter_information.hosts===undefined)
    jobdesc.reporter_information.hosts=[];
    jobdesc.reporter_information.hosts.push(host);
    return DOMElement.div({
        attrs: {
            className: "KPIsimpletableclass row2colors KPItablehover",
            style: {
                width: "calc("+this.defineSize/window.innerWidth*100 +'% - 5px)',
                overflowY: "auto",
                height: "100%",
                marginTop:"10px",
                marginBottom:"10px",
            }
        },
        children: [x]
    })
}

jobdesc.reporter_information.redrawTable = function() {
    var x;
    for(var i=0;i<jobdesc.reporter_information.hosts.length;i++){
    try{
    x = DOMElement.table({
        attrs: {
            style: {
                width: "100%",
                
            },
            className: "nth"
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
                        width: "300px"
                    }
                },
                text: LanguageModule.text("title_name_company")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_department")
            },
            {
                attrs: {
                    style: {
                        width: "400px"
                    }
                },
                text: LanguageModule.text("title_position")
            },
            {
                attrs: {
                    style: {
                        width: "300px"
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
        data: blackTheme.reporter.generateTableData(jobdesc.reporter_information.hosts[i])
    });
    if(jobdesc.reporter_information.hosts[i].me!==undefined){
        jobdescui.removeCkeditor(jobdesc.reporter_information.hosts[i]);
    }   
    
    var parentNode = jobdesc.reporter_information.hosts[i].tableCenter.parentNode
    DOMElement.removeAllChildren(parentNode);
    parentNode.appendChild(x);
    jobdesc.reporter_information.hosts[i].tableCenter = x;
    //to do update size
    }catch(err)
    {
        console.log(err)
    }
    }
}

jobdesc.reporter_information.Container = function(host) {
    host.containerTab = jobdesc.reporter_information.tableCreate(host);
    host.containerList = DOMElement.div({
        attrs: {
            className: "all-CKEDITOR",
            style: {
                background: "white",
                position:"absolute",
                width: "calc("+this.defineSize/window.innerWidth*100 +'% - 40px)',
                left : "calc("+this.defineSize/window.innerWidth*100+'% + 25px)',
                height:"calc(100% - 12px)",
                top:"10px",
            }
        },
        children: [
        ]
    })

    var resizer = DOMElement.div({
                        attrs:{
                            className:"common-resizer",
                            style:{
                                left:"calc("+this.defineSize/window.innerWidth*100+'% + 10px)'
                            }
                        }

                    });
    var resizerView = DOMElement.div({
                        attrs:{
                            className:"view-resizer",
                            style:{
                                left:"calc("+this.defineSize/window.innerWidth*100+'% + 10px)'
                            }
                        }

                    });
        absol.event.defineDraggable(resizer); 
        var currentLeftWidth = this.defineSize;
        var oldWindowWidth = window.innerWidth;
        var needUpdateSizeList = [];      
        window.onresize = function(){
            currentLeftWidth = currentLeftWidth/oldWindowWidth*window.innerWidth;
            oldWindowWidth=window.innerWidth;
        }   
        resizer.on('begindrag', function(event) {
            resizer.addStyle('width', '305px');
            this.addStyle('left', currentLeftWidth + event.moveDX + (10-305)/2 +'px');
            currentLeftWidth += event.moveDX;
            needUpdateSizeList = [];    
        });

        resizer.on('enddrag', function(event) {
            resizer.removeStyle('width', '305px');
            currentLeftWidth += event.moveDX;
            this.addStyle('left', "calc("+currentLeftWidth/window.innerWidth*100+'% + 10px)');
            resizerView.style.left = "calc("+currentLeftWidth/window.innerWidth*100+'% + 10px)';
        });

        resizer.on('drag', function(event) {
            this.addStyle('left', currentLeftWidth + event.moveDX + (10-305)/21 +'px');
            resizerView.style.left = currentLeftWidth + event.moveDX + 10 +'px';
            host.containerTab.style.width = "calc("+(currentLeftWidth + event.moveDX)/window.innerWidth*100 +'% - 5px)';
            host.containerList.style.left = "calc("+(currentLeftWidth + event.moveDX)/window.innerWidth*100 +'% + 25px)';
            host.containerList.style.width =  "calc("+(window.innerWidth-(currentLeftWidth + event.moveDX ))/window.innerWidth*100+"% - 40px)";
        });

    return DOMElement.div({
        attrs: {
            className: "all-build",
            style: {
                width: "100%",
                minHeight:"100%",
            }
        },
        children: [
            host.containerTab,
            host.containerList,
            resizerView,
            resizer
        ]
    })
}

jobdesc.reporter_information.loadPage = function(container, host) {

    var containerAll = jobdesc.reporter_information.Container(host);


    var containerRelative = DOMElement.div({
        attrs: {
            style: {
                height:"100%",
                border: "1px solid rgb(214, 214, 214)",
                position: "relative"
            }
        },
        children: [
            containerAll,
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

jobdesc.reporter_information.init = function(container, host) {
    // if (jobdesc.menu.Account !== undefined) {
        data_module.usersDataList.id=parseInt("<?php if (isset($_SESSION[$prefix.'jobdesc_user_id'])) echo $_SESSION[$prefix.'jobdesc_user_id']; else echo 0; ?>", 10);
        data_module.usersDataList.homeid=parseInt("<?php if (isset($_SESSION[$prefix.'userid'])) echo $_SESSION[$prefix.'jobdesc_user_id']; else echo 0; ?>", 10);
        var promiseAll = [];
        promiseAll.push(data_module.usersDataList.load(data_module.usersDataList.id, true));
        promiseAll.push(data_module.company.load());
        promiseAll.push(data_module.positionsList.load());
        promiseAll.push(data_module.departmentsList.load());
        Promise.all(promiseAll).then(function() {
            jobdesc.reporter_information.loadPage(container, host);
        })
}
</script>

<?php
}
?>