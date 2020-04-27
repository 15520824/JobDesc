<?php
    function write_reporter_positions_script(){
?>
<script type="text/javascript">
"use strict";

jobdesc.reporter_positions.generateData = function(host) {
    var data, header;
    DOMElement.removeAllChildren(host.category_container);
};

jobdesc.reporter_positions.init = function(host, mode) {
    host.database = {};
    host.root_category = 0;
    DOMElement.removeAllChildren(host.pagetitle);
    host.pagetitle.appendChild(DOMElement.textNode(LanguageModule.text("title_catergories_position")));
    host.holder.titleText = LanguageModule.text("title_catergories_position");
    host.frameList = DOMElement.frameList({});
    var promiseAll = [];
    promiseAll.push(data_module.departmentsList.load());
    promiseAll.push(data_module.positionsList.load());
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
                                on: {
                                    click: function(host) {
                                        return function() {
                                            // ModalElement.showWindow({
                                            //     index: 1,
                                            //     title: "Thêm chỉ mục",
                                            //     bodycontent:blackTheme.reporter_positions.addPosition()
                                            // });
                                            host.frameList.add(
                                                blackTheme
                                                .reporter_positions
                                                .addPosition(
                                                    host));
                                            host.frameList
                                                .selectedIndex =
                                                host.frameList
                                                .count - 1;
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
                jobdesc.reporter_positions_information.init(container, host)
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