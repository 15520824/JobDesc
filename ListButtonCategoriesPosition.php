<?php
    function write_ListButtonCategoriesPosition_script(){
?>
<script type="text/javascript">
"use strict";


jobdesc.ListButtonCategoriesPosition.buttonList = function(host, container) {
    var result = absol.buildDom({
        tag: "div",
        style: {
            display: "none"
        },
        child: [{
                tag: "iconbutton",
                on: {
                    click: function(host) {
                        return function() {
                            jobdesc.ListButtonCategoriesPosition
                                .removeNewSuper(result);
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
            },
            {
                tag: "iconbutton",
                class: "info",
                on: {
                    click: function(host) {
                        return function() {
                            jobdesc.ListButtonCategoriesPosition
                                .removeNewSuper(result);
                            console.log(host.me)
                            if (host.me === undefined || !host.me.classList
                                .contains("choice")) {
                                console.log(host.me === undefined || !host
                                    .me.classList.contains("choice"),
                                    "Thêm task")
                                //thêm task content mới
                                console.log("Thêm content mới")
                                var temp = jobdescui.decodeHTML(host
                                    .listEditor[0].getData());
                                console.log(temp)
                                var taskid;
                                var promise = new Promise(function(resolve,
                                    reject) {
                                    if (data_module.tasksList
                                        .getName(host.Task
                                            .value) !== undefined) {
                                        taskid = data_module
                                            .tasksList.getName(host
                                                .Task.value).id;
                                        resolve();
                                    } else {
                                        data_module.tasksList
                                            .addOne([{
                                                name: "name",
                                                value: host
                                                    .Task
                                                    .value
                                            }]).then(function(
                                                result) {
                                                taskid = result
                                                    .id;
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                                resolve();
                                            })
                                    }
                                })

                                promise.then(function() {
                                    data_module.taskContentsList
                                        .addOne(host, [{
                                                name: "content",
                                                value: temp
                                            },
                                            {
                                                name: "taskid",
                                                value: taskid
                                            },
                                            {
                                                name: "position",
                                                value: JSON
                                                    .stringify(
                                                        host
                                                        .Position
                                                        .values)
                                            },
                                        ]);
                                })

                            } else {
                                //sửa task content hiện tại

                                var temp = jobdescui.decodeHTML(host
                                    .listEditor[0].getData());
                                console.log(temp)
                                var taskid;
                                var promise = new Promise(function(resolve,
                                    reject) {
                                    if (data_module.tasksList
                                        .getName(host.Task
                                            .value) !== undefined) {
                                        taskid = data_module
                                            .tasksList.getName(host
                                                .Task.value).id;
                                        resolve();
                                    } else
                                    if ((data_module.tasksList
                                            .getTaskContent(
                                                data_module
                                                .taskContentsList
                                                .getID(host.me.id)
                                                .taskid).length ===
                                            1 && data_module
                                            .tasksList
                                            .getTaskContent(
                                                data_module
                                                .taskContentsList
                                                .getID(host.me.id)
                                                .taskid)[0] == host
                                            .me.id)) {
                                        data_module.tasksList
                                            .updateOne([{
                                                        name: "id",
                                                        value: data_module
                                                            .taskContentsList
                                                            .getID(
                                                                host
                                                                .me
                                                                .id)
                                                            .taskid
                                                    },
                                                    {
                                                        name: "name",
                                                        value: host
                                                            .Task
                                                            .value
                                                    }
                                                ], data_module
                                                .tasksList.checkID[
                                                    data_module
                                                    .taskContentsList
                                                    .getID(host.me
                                                        .id).taskid]
                                            ).then(function() {
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                            })
                                        taskid = data_module
                                            .taskContentsList.getID(
                                                host.me.id).taskid
                                        resolve();
                                    } else {
                                        data_module.tasksList
                                            .addOne([{
                                                name: "name",
                                                value: host
                                                    .Task
                                                    .value
                                            }]).then(function(
                                                result) {
                                                taskid = result
                                                    .id;
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                                resolve();
                                            })
                                    }
                                })
                                promise.then(function() {
                                    console.log(host.me)
                                    data_module.taskContentsList
                                        .updateContent(host, [{
                                                name: "id",
                                                value: host.me
                                                    .id
                                            },
                                            {
                                                name: "taskid",
                                                value: taskid
                                            },
                                            {
                                                name: "content",
                                                value: temp
                                            },
                                            {
                                                name: "position",
                                                value: JSON
                                                    .stringify(
                                                        host
                                                        .Position
                                                        .values)
                                            },
                                        ]);
                                });
                            };
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
            },
            {
                tag: "iconbutton",
                on: {
                    click: function(host) {
                        return function() {
                            jobdesc.ListButtonCategoriesPosition
                                .removeNewSuper(result);
                            console.log(host.me)
                            if (host.me === undefined || !host.me.classList
                                .contains("choice")) {
                                console.log(host.me === undefined || !host
                                    .me.classList.contains("choice"),
                                    "Thêm task")
                                //thêm task content mới
                                console.log("Thêm content mới")
                                var temp = jobdescui.decodeHTML(host
                                    .listEditor[0].getData());
                                console.log(temp)
                                var taskid;
                                var promise = new Promise(function(resolve,
                                    reject) {
                                    if (data_module.tasksList
                                        .getName(host.Task
                                            .value) !== undefined) {
                                        taskid = data_module
                                            .tasksList.getName(host
                                                .Task.value).id;
                                        resolve();
                                    } else {
                                        data_module.tasksList
                                            .addOne([{
                                                name: "name",
                                                value: host
                                                    .Task
                                                    .value
                                            }]).then(function(
                                                result) {
                                                taskid = result
                                                    .id;
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                                resolve();
                                            })
                                    }
                                })

                                promise.then(function() {
                                    data_module.taskContentsList
                                        .addOne(host, [{
                                                name: "content",
                                                value: temp
                                            },
                                            {
                                                name: "taskid",
                                                value: taskid
                                            },
                                            {
                                                name: "position",
                                                value: JSON
                                                    .stringify(
                                                        host
                                                        .Position
                                                        .values)
                                            },
                                        ]);
                                })

                            } else {
                                //sửa task content hiện tại

                                var temp = jobdescui.decodeHTML(host
                                    .listEditor[0].getData());
                                console.log(temp)
                                var taskid;
                                var promise = new Promise(function(resolve,
                                    reject) {
                                    if (data_module.tasksList
                                        .getName(host.Task
                                            .value) !== undefined) {
                                        taskid = data_module
                                            .tasksList.getName(host
                                                .Task.value).id;
                                        resolve();
                                    } else
                                    if ((data_module.tasksList
                                            .getTaskContent(
                                                data_module
                                                .taskContentsList
                                                .getID(host.me.id)
                                                .taskid).length ===
                                            1 && data_module
                                            .tasksList
                                            .getTaskContent(
                                                data_module
                                                .taskContentsList
                                                .getID(host.me.id)
                                                .taskid)[0] == host
                                            .me.id)) {
                                        data_module.tasksList
                                            .updateOne([{
                                                        name: "id",
                                                        value: data_module
                                                            .taskContentsList
                                                            .getID(
                                                                host
                                                                .me
                                                                .id)
                                                            .taskid
                                                    },
                                                    {
                                                        name: "name",
                                                        value: host
                                                            .Task
                                                            .value
                                                    }
                                                ], data_module
                                                .tasksList.checkID[
                                                    data_module
                                                    .taskContentsList
                                                    .getID(host.me
                                                        .id).taskid]
                                            ).then(function() {
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                            })
                                        taskid = data_module
                                            .taskContentsList.getID(
                                                host.me.id).taskid
                                        resolve();
                                    } else {
                                        data_module.tasksList
                                            .addOne([{
                                                name: "name",
                                                value: host
                                                    .Task
                                                    .value
                                            }]).then(function(
                                                result) {
                                                taskid = result
                                                    .id;
                                                jobdesc
                                                    .reporter_tasks_information
                                                    .redrawTable(
                                                        host);
                                                resolve();
                                            })
                                    }
                                })
                                promise.then(function() {
                                    console.log(host.me)
                                    data_module.taskContentsList
                                        .updateContent(host, [{
                                                name: "id",
                                                value: host.me
                                                    .id
                                            },
                                            {
                                                name: "taskid",
                                                value: taskid
                                            },
                                            {
                                                name: "content",
                                                value: temp
                                            },
                                            {
                                                name: "position",
                                                value: JSON
                                                    .stringify(
                                                        host
                                                        .Position
                                                        .values)
                                            },
                                        ]);
                                });
                            };
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
            }
        ]
    })
    return result;
}

jobdesc.ListButtonCategoriesPosition.removeNewSuper = function(el) {
    var host = el;
    while (!host.classList.contains('absol-single-page-header'))
        host = host.parentNode;
    host.childNodes[1].style.display = "none"
    host.childNodes[0].style.display = "block"
}

jobdesc.ListButtonCategoriesPosition.addNewSuper = function(host) {
    console.log(host)
    host.childNodes[0].style.display = "none"
    host.childNodes[1].style.display = "block"
}

jobdesc.ListButtonCategoriesPosition.init = function(host, mode) {
    host.database = {};
    host.root_category = 0;
    host.holder.host = host;
    host.frameList = absol.buildDom({
        tag: 'frameview',
        style: {
            width: '100%',
            height: '100%'
        }
    });
    var mainFrame;

    host.save = absol.buildDom({
        tag: "iconbutton",
        class: "info",
        style:{
            display:"none"
        },
        on: {
            click: function(host) {
                return function() {
                    jobdesc.ListButtonCategoriesPosition.addNewSuper(mainFrame.$header);
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
            '<span>' + LanguageModule.text(
                "ctrl_save") + '</span>'
        ]
    })
    window.mainFrame = mainFrame;
    mainFrame = absol.buildDom({
        tag: 'singlepage',
        child: [{
                class: 'absol-single-page-header',
                child: [{
                        tag: "div",
                        child: [{
                                tag: "iconbutton",
                                on: {
                                    click: function(host) {
                                        return function() {
                                            jobdesc.menu.tabPanel.removeTab(host.holder
                                                .id);
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
                            host.save,
                            {
                                tag: "iconbutton",
                                on: {
                                    click: function(host) {
                                        return function() {
                                            jobdescui.createIndexEdit(host);
                                            if (host.me !== undefined)
                                                host.me.classList.remove(
                                                    "choice");
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
                                    '<span>' + LanguageModule.text("ctrl_add") +
                                    '</span>'
                                ]
                            }
                        ]
                    },
                    jobdesc.ListButtonCategoriesPosition.buttonList(host)
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
            jobdesc.MenuCategoriesPosition.init(mainFrame.$viewport, host)
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