<?php
    function write_categories_script(){
?>
<script type="text/javascript">
"use strict";

jobdesc.categories.buttonList = function(host, container) {
    var result = DOMElement.div({
        attrs: {
            style: {
                padding: "10px 10px 10px 20px"
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "inline-block"
                    },
                },
                children: [absol.buildDom({
                    tag: "iconbutton",
                    on: {
                        click: function(host) {
                            return function() {
                                jobdesc.categories.removeNewSuper(result);
                            }
                        }(host)
                    },
                    child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'clear'
                            }
                        },
                        '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                    ]
                })]
            }),
            DOMElement.div({
                attrs: {
                    style: {
                        display: "inline-block",
                        paddingLeft: "10px"
                    },
                },
                children: [absol.buildDom({
                    tag: "iconbutton",
                    class: "info",
                    on: {
                        click: function(host) {
                            return function() {
                                //jobdesc.responsibility.saveDataTask(host);
                                jobdesc.categories.saveAllData(host);
                                host.infoBar.childNodes[0].innerHTML =
                                    LanguageModule.text("title_department") +
                                    ": " + host.data[0].department;
                                host.infoBar.childNodes[1].innerHTML =
                                    LanguageModule.text("title_position") +
                                    ": " + host.data[0].position;
                                jobdesc.reporter_information.redrawTable(host.hostParent);
                                jobdesc.categories.removeNewSuper(result);
                            }
                        }(host)
                    },
                    child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            }
                        },
                        '<span>' + LanguageModule.text("ctrl_save") + '</span>'
                    ]
                })]
            }),
            DOMElement.div({
                attrs: {
                    style: {
                        display: "inline-block",
                        paddingLeft: "10px"
                    },
                },
                children: [absol.buildDom({
                    tag: "iconbutton",
                    class: "info",
                    on: {
                        click: function(host) {
                            return function() {
                                //jobdesc.responsibility.saveDataTask(host);
                                jobdesc.categories.saveAllData(host)
                                jobdesc.reporter_information.redrawTable(host.hostParent);
                                jobdesc.menu.tabPanel.removeTab(host.holder.id);
                            }
                        }(host)
                    },
                    child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            }
                        },
                        '<span>' + LanguageModule.text("ctrl_save_close") +
                        '</span>'
                    ]
                })]
            }),
        ]
    })
    return result;
}

jobdesc.categories.saveAllData = function(host) {
    //console.log(host)
    jobdesc.responsibility.saveDataTask(host);
    if (host.data[0].Pos === undefined) {
        host.data[0].Pos = data_module.usersDataList.items.length;
        data_module.usersDataList.items[host.data[0].Pos] = {};
    }
    data_module.usersDataList.items[host.data[0].Pos].data = []
    for (var i = 0; i < host.information.children.length; i++) {
        data_module.usersDataList.items[host.data[0].Pos].data[i + 1] = host.data[i + 1];
        if (data_module.usersDataList.items[host.data[0].Pos].data[i + 1] === undefined) {
            data_module.usersDataList.items[host.data[0].Pos].data[i + 1] = {}
        }
        data_module.usersDataList.items[host.data[0].Pos].data[i + 1].title = host.data[i + 1].title;
        console.log(host.data[i + 1])
    }
    data_module.usersDataList.items[host.data[0].Pos].data[0] = host.data[0];
    // if (host.data[0].nameCompany !== undefined)
    //     data_module.usersDataList.items[host.data[0].Pos].nameCompany = host.data[0].nameCompany;
    if (host.data[0].position !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].position = host.data[0].position;
    if (host.data[0].department !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].department = host.data[0].department;
    // if (host.data[0].address !== undefined)
    //     data_module.usersDataList.items[host.data[0].Pos].address = host.data[0].address;
    if (host.data[0].country !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].country = host.data[0].country;
    // if (host.data[0].webSite !== undefined)
    //     data_module.usersDataList.items[host.data[0].Pos].webSite = host.data[0].webSite;
    if (host.data[0].direct !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].direct = host.data[0].direct;
    if (host.data[0].indirect !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].indirect = host.data[0].indirect;
    if (host.data[0].ransack !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].ransack = host.data[0].ransack;
    if (host.data[0].working_time !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].working_time = host.data[0].working_time;
    if (host.data[0].jobCode !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].jobCode = host.data[0].jobCode;
    if (host.data[0].jobReplace !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].jobReplace = host.data[0].jobReplace;
    if (host.data[0].note !== undefined)
        data_module.usersDataList.items[host.data[0].Pos].note = host.data[0].note;

    // console.log(JSON.stringify(data_module.usersDataList.items[host.data[0].Pos]))
    // window.data=data_module.usersDataList.items[host.data[0].Pos];
    //console.log(data_module.usersDataList.items)
    jobdesc.categories.saveInDatabase(host,host.data[0].Pos);
}

jobdesc.categories.saveInDatabase = function(host,Pos,mode=1) {
    var userID,arr;
    data_module.usersDataList.getDataID(-1,true);
    if(mode==1){
        if(data_module.usersDataList.items[Pos].id===undefined)
            data_module.usersDataList.items[Pos].id=data_module.usersDataList.id;
            userID=data_module.usersDataList.items[Pos].id;
        arr = data_module.usersDataList.getDataID(data_module.usersDataList.items[Pos].id);
    }
    else
    {
        userID=Pos;
        arr = data_module.usersDataList.getDataID(userID);
    }
    var temp=[];
    for(var i=0;i<arr.length;i++)
    {
        temp.push(JSON.parse(JSON.stringify(data_module.usersDataList.items[arr[i]])));
            for (var j = 0; j < data_module.usersDataList.items[arr[i]].data.length; j++) {
                if (data_module.usersDataList.items[arr[i]].data[j].data !== undefined) {
                    temp[i].data[j] = {
                        title: data_module.usersDataList.items[arr[i]].data[j].title,
                        data: Base64.encode(JSON.stringify(data_module.usersDataList.items[arr[i]].data[j].data))
                    }
                }

            }
    }
    
    
    if (host === undefined || host.dataSave !== JSON.stringify(temp))
        FormClass.api_call({
            url: "insert_new_account_task_by_id.php",
            params: [{
                    name: "id",
                    value: userID
                },
                {
                    name: "data",
                    value: JSON.stringify(temp)
                }
            ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log('ok', message)
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    return;
                }
            }
        })
    if (host !== undefined)
        host.dataSave = JSON.stringify(temp);
}

jobdesc.categories.removeNewSuper = function(el) {
    var host = el;
    while (!host.classList.contains('all_container'))
        host = host.parentNode;
    host.childNodes[1].style.display = "none"
    host.childNodes[0].style.display = "block"
}

jobdesc.categories.addNewSuper = function(host) {
    host.childNodes[0].style.display = "none"
    host.childNodes[1].style.display = "block"
}


jobdesc.categories.init = function(host, mode) {
    host.database = {};
    host.root_category = 0;
    host.frameList = absol.buildDom({
        tag:'frameview',
        style:{
            width: '100%',
            height: '100%'
        }
    });
    host.buttonAddWork = absol.buildDom({
                        tag: "iconbutton",
                        on: {
                            click: function(host) {
                                return function() {
                                    if (host.state !== 0)
                                        jobdescui.createIndex(host)
                                }
                            }(host)
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'add'
                                }
                            },
                            '<span>' + LanguageModule.text(
                                "title_add_title") + '</span>'
                        ]
                    })

    var mainFrame = absol.buildDom({
        tag:'singlepage',
        child:[
            {
                class: 'absol-single-page-header',
                child:[
                    {
                        tag: "iconbutton",
                        on: {
                            click: function(host) {
                                return function() {
                                    jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                }
                            }(host)
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'clear'
                                }
                            },
                            '<span>' + LanguageModule.text(
                            "ctrl_close") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        on: {
                            click: function(host) {
                                return function() {
                                    blackTheme.reporter
                                        .exportWordLocal(host)
                                }
                            }(host)
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'pageview'
                                }
                            },
                            '<span>' + LanguageModule.text(
                                "title_preview") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        on: {
                            click: function(host) {
                                return function() {
                                    var temp1 = jobdescui.formAdd(host);
                                    host.frameList.addChild(temp1);
                                    host.frameList.activeFrame(temp1);
                                }
                            }(host)
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'add'
                                }
                            },
                            '<span>' + LanguageModule.text(
                                "titile_add_item") + '</span>'
                        ]
                    },
                    host.buttonAddWork
                ]
            },
            {
                class: 'absol-single-page-footer'
            }
        ]
    }); 

    jobdesc.menu.footer(absol.$('.absol-single-page-footer', mainFrame));
    host.frameList.addChild(mainFrame);
    host.frameList.activeFrame(mainFrame);
    switch (mode) {
        case 1:
            jobdesc.generalInformation.init(mainFrame.$viewport, host)
            break;
        case 2:
            break;
        case 3:
            break;
    }

    host.holder.addChild(host.frameList);
   
    host.contextCaptor = absol._('contextcaptor').addTo(mainFrame);

    host.contextCaptor.attachTo(mainFrame);
    
}
</script>

<?php } ?>