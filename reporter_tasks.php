<?php
    function write_reporter_tasks_script(){
?>
<script type="text/javascript">
"use strict";

jobdesc.reporter_tasks.generateData = function(host) {
    var data, header;
    DOMElement.removeAllChildren(host.category_container);
};

jobdesc.reporter_tasks.init = function(host, mode) {
    host.database = {};
    host.root_category = 0;
    DOMElement.removeAllChildren(host.pagetitle);
    host.pagetitle.appendChild(DOMElement.textNode(LanguageModule.text("title_nametask")));
    host.holder.titleText = LanguageModule.text("title_nametask");
    host.frameList = DOMElement.frameList({});
    var promiseAll = [];
    promiseAll.push(data_module.categoriesList.load());
    promiseAll.push(data_module.tasksList.load());
    Promise.all(promiseAll).then(function() {
        var container;
        host.category_container = DOMElement.div({});
        container = DOMElement.div({
            attrs: {
                className: "all_container",
                style: {
                    height: "calc(100vh - 125px)"
                }
            },
            children: [
                DOMElement.div({
                    attrs: {
                        style: {
                            padding: "10px",
                            paddingLeft: "20px"
                        }
                    },
                    children: [
                        DOMElement.div({
                            attrs: {
                                style: {
                                    display: "inline-block",
                                    paddingRight: "10px"
                                },
                            },
                            children: [absol.buildDom({
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
                            })]
                        }),
                        DOMElement.div({
                            attrs: {
                                style: {
                                    display: "inline-block",
                                    paddingRight: "10px"
                                },
                            },
                            children: [absol.buildDom({
                                tag: "iconbutton",
                                class:"info",
                                on: {
                                    click: function(host) {
                                        return function() {
                                            // ModalElement.showWindow({
                                            //     index: 1,
                                            //     title: "Thêm chỉ mục",
                                            //     bodycontent:blackTheme.reporter_tasks.addPosition()
                                            // });
                                            host.frameList.add(blackTheme.reporter_tasks.addTask(host));
                                            host.frameList.selectedIndex = host.frameList.count - 1;
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
                                        "ctrl_add") + '</span>'
                                ]
                            })]
                        }),
                    ]
                }),
                host.category_container
            ]
        });
        host.frameList.add(container);
        switch (mode) {
            case 1:
                jobdesc.reporter_tasks_information.init(container, host)
                break;
            case 2:
                // jobdesc.responsibility.init(container)
                break;
            case 3:
                //  jobdesc.category.init(container)
                break;
        }

        absol.$(host.holder);
        // host.holder.defineEvent('contextmenu');

        host.contextCaptor = absol._('contextcaptor').addTo(host.holder);


        host.holder.on('mousedown', function(event) {
            host.contextCaptor.handle(event);
        });

        host.holder.appendChild(host.contextCaptor);
        host.holder.appendChild(host.frameList);
        jobdesc.menu.footer(host.holder);
    })
    // host.holder.appendChild(DOMElement.textNode("dsafsdfasdfasdfasd"));
}
</script>

<?php } ?>