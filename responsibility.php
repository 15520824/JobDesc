<?php
    function write_responsibility_script() {
        global $prefix;
?>
<script type="text/javascript">
jobdesc.responsibility.removeandSaveData = function(host, next) {
    console.log(host.state, next)
    if (host.state !== next) {
        jobdesc.responsibility.saveDataTask(host);
        if (host.state !== 0) {
            console.log(host.listEditor)
            for (var i = 0; i < host.listEditor.length; i++) {
                host.listEditor[i][1].destroy();
            }
            delete host.listEditor;
        }
        
        if(host.bot!==undefined){
            host.bot.parentNode.removeChild(host.bot);
            host.bot=undefined;
        }else
        DOMElement.removeAllChildren(host.containerList);

        host.state = next;
    }
}

jobdesc.responsibility.saveDataTask = function(host) {
    console.log(host)
    if (host.state !== 0) {
        var tempTitle = host.data[host.state].title;
        host.data[host.state] = {};
        host.data[host.state].title = tempTitle;
        host.data[host.state].data = [];
        if (host.listEditor !== undefined)
            for (var i = 0; i < host.listEditor.length; i++) {
                host.data[host.state].data.push([host.listEditor[i][0].innerHTML, host.listEditor[i][1].getData()]);
                console.log(host.listEditor[i][1].getData())
            }
    } else {
        //console.log(host.containerList.childNodes[0].childNodes[1])
        var data = host.containerList.childNodes[0].childNodes[1];
        // host.data[0].nameCompany = data.childNodes[0].childNodes[1].value;
        // host.data[0].address = data.childNodes[1].childNodes[1].value;
        host.data[0].country = absol.$('selectmenu', data.childNodes[4]).value;
        // host.data[0].webSite = data.childNodes[3].childNodes[1].value;
        host.data[0].direct = data.childNodes[10].childNodes[1].value;
        host.data[0].indirect = data.childNodes[12].childNodes[1].value;
        host.data[0].ransack = data.childNodes[14].childNodes[1].value;
        host.data[0].working_time = data.childNodes[16].childNodes[1].value;
        if(data_module.positionsList.getName(data.childNodes[18].childNodes[1].value)!==undefined)
        host.data[0].position = data_module.positionsList.getName(data.childNodes[18].childNodes[1].value).id;
        else
        host.data[0].position = data.childNodes[18].childNodes[1].value;
        host.data[0].jobCode = data.childNodes[20].childNodes[1].value;
        host.data[0].jobReplace = data.childNodes[22].childNodes[1].value;
        host.data[0].note = data.childNodes[24].childNodes[1].value;

        // host.infoBar.childNodes[0].innerHTML=LanguageModule.text("title_department")+": "+host.data[0].department;
        // host.infoBar.childNodes[1].innerHTML=LanguageModule.text("title_position")+": "+host.data[0].position;
    }
}
/////////////////////////////---------------------//////////////////////////////////

jobdesc.responsibility.processTabbar = function(host_child, host) {
    host.checkIdProcess = function(name) {
        for (var i = 1; i < host.data.length; i++) {
            if (host.data[i].title === name)
                return i;
        }
        return -1;
    }
    if (host.data !== undefined) {
        data_module.categoriesList.load().then(function() {
            var list = [];
            var result;
            console.log(host)
            if (host.data.length > 1)
                for (var i = 1; i < host.data.length; i++) {
                    result = {
                        id: i,
                        name: host.data[i].title
                    };
                    console.log(result)
                    list.push([result, "Info2"])
                }
            else {
                // var data = JSON.parse(JSON.stringify(data_module.categoriesList.items));
                // for (var i = 0; i < data.length; i++) {
                //     console.log(data[i])
                //     console.log(data[i]);
                //     list.push([data[i], "Info2"])
                //     host.data[i + 1] = {};
                //     host.data[i + 1].title = data[i].name;
                // }
            }
            console.log(host.data)
            host.information = DOMElement.div({
                attrs: {
                    className: "nth",
                },
                children: jobdescui.listProcess(host, list)
            })
            host.General = DOMElement.span({
                attrs: {
                    className: "Info2",
                    innerHTML: LanguageModule.text("title_general"),
                    style: {
                        background: "#ebebeb",
                        paddingTop: "7px",
                        paddingBottom: "7px",
                        paddingLeft:"5px",
                    },
                    onclick: function() {
                        if (host.state !== 0) {
                            if (host.me !== undefined)
                                host.me.classList.remove("choice");
                            host.General.classList.add("choice");
                            host.me = host.General;
                            jobdesc.responsibility.removeandSaveData(host, 0);
                            jobdesc.responsibility.BuildInfoInit(host)
                        }

                    },
                },
            });
            host.General.classList.add("choice");
            host.me = host.General;
            var result = DOMElement.div({
                attrs: {
                    className: "information",
                    style: {}
                },
                children: [
                    host.General,
                    host.information,
                ]
            });
            absol.$(host.information);
            host.information.defineEvent('contextmenu');

            host.information.on('contextmenu', function(event) {
                event.showContextMenu({
                    items: [{
                            text: LanguageModule.text("ctrl_add"),
                            cmd: 'ADD'
                        },
                        {
                            text: LanguageModule.text("ctrl_edit"),
                            cmd: 'EDIT'
                        },
                        {
                            text: LanguageModule.text("ctrl_delete"),
                            cmd: 'DEL'
                        },
                        {
                            text: LanguageModule.text("title_undo"),
                            cmd: 'UNO'
                        },
                        {
                            text: LanguageModule.text("title_redo"),
                            cmd: 'REDO'
                        },
                        {
                            text: "Settings",
                            cmd: 'settings'
                        }
                    ]
                }, function(e) {
                    var item = e.menuItem;
                    if (item.cmd === "DEL") {
                        //jobdescui.deleteItemProcessList(event,host);
                        var paramtext = ""
                        console.log(event)
                        if (event.target.classList.contains("indextext"))
                            paramtext = event.target.innerHTML;
                        else if (event.target.classList.contains("Info2"))
                            paramtext = event.target.childNodes[0].innerHTML;
                        console.log(paramtext)
                        paramtext = paramtext.slice(paramtext.indexOf(" ") + 2);
                        // ModalElement.showWindow({
                        //     index: 2,
                        //     title: LanguageModule.text("title_save_confirm"),
                        //     bodycontent:jobdescui.formDelete(event,host,paramtext)
                        // })
                        ModalElement.question({
                            title: LanguageModule.text("txt_delete_category"),
                            message: LanguageModule.text("title_confirm_delete") +
                                "" + paramtext,
                            onclick: function(event, host) {
                                return function(selectedindex) {
                                    switch (selectedindex) {
                                        case 0:
                                            console.log(host)
                                            jobdescui.deleteItemProcessList(
                                                event, host)
                                            break;
                                        case 1:
                                            // do nothing
                                            break;
                                    }
                                }
                            }(event, host)
                        })
                    } else if (item.cmd === "UNO") {
                        var ex = host.stack.pop();
                        if (ex !== undefined && ex[0] === "remove") {
                            host.stackRedo.push(ex);
                            jobdescui.insetCategories(host, host.information, ex[1].stt, ex[
                                1])
                            host.data[ex[1].id] = ex[2];
                            jobdescui.updateprocessTabbar(host.information, host);
                        }
                    } else if (item.cmd === "REDO") {
                        var ex = host.stackRedo.pop();
                        if (ex !== undefined && ex[0] === "remove") {
                            host.stack.push(ex);
                            host.information.removeChild(
                                host.information.childNodes[ex[1].stt]
                            );
                            if (host.state === ex[1].id) {
                                jobdesc.responsibility.removeandSaveData(host, 0);
                                jobdesc.responsibility.BuildInfoInit(host)
                                host.General.style.color = "#4286f4"
                            }
                            delete host.data[ex[1].id];
                            jobdescui.updateprocessTabbar(host.information, host);
                        }
                    } else if (item.cmd === "ADD") {
                        var el = event.target; //absol.HTMLElement.prototype.containsClass
                        while (!el.classList.contains('Info2'))
                            el = el.parentNode;
                        // ModalElement.showWindow({
                        //     index: 1,
                        //     title: LanguageModule.text("titile_add_item"),
                        //     align: "center",
                        //     bodycontent:jobdescui.formAdd(host)
                        // })
                        host.frameList.add(jobdescui.formAdd(host, -1, jobdescui.getSTT(el
                            .parentNode, el) + 1, true));
                        jobdesc.menu.hiddenCkeditor(host);
                        host.frameList.selectedIndex = host.frameList.count - 1;
                    } else if (item.cmd === "EDIT") {
                        var el = event.target; //absol.HTMLElement.prototype.containsClass
                        while (!el.classList.contains('Info2'))
                            el = el.parentNode;
                        host.frameList.add(jobdescui.formAdd(host, el));
                        jobdesc.menu.hiddenCkeditor(host);
                        host.frameList.selectedIndex = host.frameList.count - 1;
                    }
                }.bind(this));
            });
            host_child.holder.appendChild(result);
        })

    }
    // else{
    //     data_module.categoriesList.load().then(function()
    //     {

    //                         var data = JSON.parse(JSON.stringify(data_module.categoriesList.items));
    //                         var list=[];
    //                         host.checkIdProcess=[];

    //                         //console.log(host.data.length)

    //                         if(host.data.length>1){
    //                             // for(var i=0;i<data.length;i++)
    //                             // {
    //                             // console.log(data[i]);
    //                             // //list.push([data[i],"Info2"])
    //                             // //edit code here

    //                             // }

    //                             for(var i=1;i<host.data.length;i++)
    //                             {
    //                                 host.checkIdProcess[host.data[i].title]=i;
    //                                 list.push([{id: host.checkIdProcess[host.data[i].title],name:host.data[i].title},"Info2"])
    //                             }
    //                         }
    //                         // else
    //                         // for(var i=0;i<data.length;i++)
    //                         //     {
    //                         //     console.log(data[i])
    //                         //     console.log(data[i]);
    //                         //     list.push([data[i],"Info2"])
    //                         //     host.checkIdProcess[data[i].name]=i+1;
    //                         //     }

    //                         var temp=[];
    //                         temp[0]=host.data[0];
    //                         for(var i=1;i<host.data.length;i++)
    //                         {
    //                             temp[host.checkIdProcess[host.data[i].title]]=host.data[i];
    //                         }
    //                         host.data=temp;
    //                         console.log(host.data)

    //                         host.information =   DOMElement.div({
    //                                                 attrs:{
    //                                                     className:"nth", 
    //                                                 },
    //                                                 children:jobdescui.listProcess(host,list)
    //                                             })
    //                         host.General= DOMElement.span({
    //                                         attrs:{
    //                                             className:"Info2",
    //                                             innerHTML:LanguageModule.text("title_general"),
    //                                             style:{
    //                                                 background: "#ebebeb",
    //                                                 fontSize: "14px",
    //                                                 paddingTop: "7px",
    //                                                 paddingBottom: "7px"
    //                                             },
    //                                             onclick: function(){
    //                                                     if(host.state!==0){
    //                                                         if(host.me!==undefined)
    //                                                         host.me.classList.remove("choice");
    //                                                         host.General.classList.add("choice");
    //                                                         host.me=host.General;
    //                                                     jobdesc.responsibility.removeandSaveData(host,0);
    //                                                     jobdesc.responsibility.BuildInfoInit(host)
    //                                                     }

    //                                             },
    //                                         },
    //                                     });
    //                         host.General.classList.add("choice");
    //                         host.me=host.General;
    //                         var result= DOMElement.div({
    //                             attrs: {
    //                                     className:"information",
    //                                     style:{
    //                                     }
    //                                 },
    //                             children:[
    //                                     host.General,
    //                                     host.information,
    //                                 ]
    //                         });
    //                         absol.$( host.information);
    //                         host.information.defineEvent('contextmenu');

    //                         host.information.on('contextmenu', function(event){
    //                             event.showContextMenu({
    //                                 items: [
    //                                     { text: LanguageModule.text("ctrl_add"), cmd: 'ADD' },
    //                                     { text: LanguageModule.text("ctrl_delete"), cmd: 'DEL' },
    //                                     { text: LanguageModule.text("title_undo"), cmd: 'UNO' },
    //                                     { text: LanguageModule.text("title_redo"), cmd: 'REDO' },
    //                                     { text: "Settings", cmd: 'settings' }
    //                                 ]
    //                             }, function (e) {
    //                                 var item = e.menuItem;
    //                                 if(item.cmd==="DEL"){
    //                                     //jobdescui.deleteItemProcessList(event,host);
    //                                     var paramtext=""
    //                                     if(event.target.classList.contains("lv-item-content"))
    //                                     paramtext=event.target.innerHTML;
    //                                     else if(event.target.classList.contains("Info2"))
    //                                     paramtext=event.target.childNodes[0].innerHTML;
    //                                     paramtext=paramtext.slice(paramtext.indexOf(" ")+2);
    //                                     // ModalElement.showWindow({
    //                                     //     index: 2,
    //                                     //     title: LanguageModule.text("title_save_confirm"),
    //                                     //     bodycontent:jobdescui.formDelete(event,host,paramtext)
    //                                     // })
    //                                     host.frameList.add(jobdescui.formDelete(event,host,paramtext));
    //                                     host.frameList.selectedIndex = host.frameList.count - 1;
    //                                 }
    //                                 else if(item.cmd==="UNO")
    //                                 {
    //                                     var ex= host.stack.pop();
    //                                     if(ex!==undefined&&ex[0]==="remove")
    //                                     {
    //                                         host.stackRedo.push(ex);
    //                                         jobdescui.insetCategories(host, host.information,ex[1].stt,ex[1])
    //                                         host.data[ex[1].id]=ex[2];
    //                                         jobdescui.updateprocessTabbar(host.information,host);
    //                                     }
    //                                 }
    //                                 else if(item.cmd==="REDO")
    //                                 {
    //                                     var ex= host.stackRedo.pop();
    //                                     if(ex!==undefined&&ex[0]==="remove")
    //                                     {
    //                                         host.stack.push(ex);
    //                                         host.information.removeChild(
    //                                             host.information.childNodes[ex[1].stt]
    //                                         );
    //                                         if(host.state===ex[1].id){
    //                                             jobdesc.responsibility.removeandSaveData(host,0);
    //                                             jobdesc.responsibility.BuildInfoInit(host)
    //                                             host.General.style.color="#4286f4"
    //                                         }
    //                                         delete host.data[ex[1].id];
    //                                         jobdescui.updateprocessTabbar(host.information,host);
    //                                     }
    //                                 }
    //                                 else if(item.cmd==="ADD")
    //                                 {
    //                                     var el=event.target;//absol.HTMLElement.prototype.containsClass
    //                                     while(!el.classList.contains('Info2'))
    //                                     el=el.parentNode;
    //                                     // ModalElement.showWindow({
    //                                     //     index: 1,
    //                                     //     title: LanguageModule.text("titile_add_item"),
    //                                     //     align: "center",
    //                                     //     bodycontent:jobdescui.formAdd(host)
    //                                     // })
    //                                     host.frameList.add(jobdescui.formAdd(host));
    //                                     host.frameList.selectedIndex = host.frameList.count - 1;
    //                                 }
    //                             }.bind(this));
    //                         });
    //                         host_child.holder.appendChild(result);

    //     })
    // }

}
///////////////////////////////////------------------------------/////////////////////////////////////////
// jobdesc.generalInformation.index = 0;
//

jobdesc.responsibility.listInfo = function(host_child, host, data, listPositions) {

    var list = [];

    for (var i = 0; i < listPositions.length; i++) {
        list[listPositions[i].id] = listPositions[i].name;
    }
    container = DOMElement.div({
        attrs: {
            className: "information",
            style: {
                border: "none",
                background: "none",
            }
        },
        children: []
    })

    var listItm = jobdescui.listItem(host, data);
    host.selectBox = absol._({
        tag: 'selectbox',
        style: {
            display: 'block',
        },
        props: {
            enableSearch: true,
            items: listPositions.map(function(u, i) {
                return {
                    text: u.name,
                    value:u.id,
                }
            }),
            values: [],

        },
        on: {
            add: function(evt) {
                console.log(evt)
                blackTheme.reporter.selectPositions(host, evt.itemData.value)
            },
            remove: function(evt) {
                console.log(evt)
                blackTheme.reporter.removePositions(host, evt.itemData.value)
            }
        }
    });
    host.views=DOMElement.div({
                            attrs: {
                                className: "container-index",
                            },
                            children: listItm
                        });
    host_child.holder.appendChild(
        DOMElement.div({
            attrs: {
                className: "container_responsibility",
            },
            children: [
                DOMElement.div({
                    attrs: {
                        className: "information",
                    },
                    children: [
                        host.selectBox,
                        DOMElement.input({
                            attrs: {
                                id: "search",
                                placeholder: LanguageModule.text("title_search") + "...",
                                style: {
                                    display: "block",
                                    width: "100%",
                                    marginTop: "0.5em",
                                    height: "30px",
                                },
                                oninput: function(evt) {
                                    jobdescui.Search(host, evt)
                                    if (evt.target.value != "")
                                        Searching = true;
                                    else
                                        Searching = false;
                                }
                            }
                        }),
                        host.views
                    ]
                }),
                //    this.container
            ]
        })

    )

}

jobdesc.responsibility.listInfoInit = function(host_child, host) {
    var promiseList = [];
    promiseList.push(data_module.taskContentsList.load());
    promiseList.push(data_module.positionsLibaryList.load());
    promiseList.push(data_module.departmentsList.load());
    promiseList.push(data_module.tasksList.load());
    promiseList.push(data_module.link_position_taskcontent.load());
    Promise.all(promiseList).then(function() {
        jobdesc.responsibility.listInfo(host_child, host, data_module.taskContentsList.items, data_module
            .positionsLibaryList.items)
    })

}

/////////////////////--------------------------------////////////////////////////

jobdesc.responsibility.BuildInfo = function(host, list_country) {
    var list = [];
    host.buttonAddWork.style.display="none";
    for (var i = 0; i < list_country.length; i++) {
        list.push({
            value: list_country[i].id,
            text: list_country[i].country_name
        })
    }
    var name, address, web;
    name = jobdescui.spanInput(LanguageModule.text("title_name_company"), data_module.company.item.nameCompany);
    address = jobdescui.spanInput(LanguageModule.text("title_address"), data_module.company.item.address, false);
    web = jobdescui.spanInput(LanguageModule.text("title_web"), data_module.company.item.webSite);

    name.childNodes[1].setAttribute("disabled", "");
    address.childNodes[1].setAttribute("disabled", "");
    web.childNodes[1].setAttribute("disabled", "");
    if(host.data[0].position!==undefined&&host.data[0].position!="")
    var valueDepartment=data_module.positionsList.getID(host.data[0].position).departmentid;
    else
    var valueDepartment=0;

    if(host.data[0].position!==undefined&&host.data[0].position!="")
    var valuePosition=data_module.positionsList.getID(host.data[0].position).name;
    else
    var valuePosition="";

    host.department =jobdescui.spanSelect(LanguageModule.text("title_department"),data_module.departmentsList.items.map(function(u,i){
        return {text:u.name,value:u.id}
    }), valueDepartment);
    host.department.childNodes[1].style.pointerEvents="none";
    host.department.childNodes[1].style.backgroundColor="#ebebe4";
    
    host.containerList.appendChild(DOMElement.div({
        attrs: {
            className: "general",
            // style: {
            //     overflowY: "auto",
            //     height:"-webkit-fill-available",
            // }
            //because we scroll in container 
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "title",
                    innerHTML: LanguageModule.text("title_general"),
                },
            }),
            DOMElement.div({
                attrs: {
                    className: "form-container"
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    address,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanSelect(LanguageModule.text("title_country"), list, host.data[0].country),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    web,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.department,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanAutocompleteBox(LanguageModule.text("titile_direct_management"),data_module.departmentsList.items, host.data[0].direct),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanAutocompleteBox(LanguageModule.text("title_indirect_management"),data_module.departmentsList.items, host.data[0].indirect),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanInput(LanguageModule.text("title_ransack"), host.data[0].ransack),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanInput(LanguageModule.text("title_working_time"), host.data[0].working_time),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanAutocompleteBoxUpdate(LanguageModule.text("title_position"),data_module.positionsList.items, valuePosition,host.department),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanInput(LanguageModule.text("title_job_code"), host.data[0].jobCode),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanAutocompleteBox(LanguageModule.text("title_job_replace"),data_module.positionsList.items, host.data[0].jobReplace),
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    jobdescui.spanInput(LanguageModule.text("title_note"), host.data[0].note, false)
                ]
            })


        ]
    }))

}

jobdesc.responsibility.BuildInfoInit = function(container) {

    var promiseList = [];
    promiseList.push(data_module.countriesList.load());
    promiseList.push(data_module.positionsList.load());
    promiseList.push(data_module.departmentsList.load());
    promiseList.push(data_module.company.load());
    Promise.all(promiseList).then(function() {
        console.log(promiseList)
        jobdesc.responsibility.BuildInfo(container, data_module.countriesList.items);
    })
}
</script>
<?php
}
?>