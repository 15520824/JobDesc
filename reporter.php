<?php
    function write_reporter_script(){
?>
<script type="text/javascript">
"use strict";

jobdesc.reporter.generateData = function(host) {
    var data, header;
    DOMElement.removeAllChildren(host.category_container);
};

jobdesc.reporter.init = function(host, mode) {
    host.database = {};
    host.root_category = 0;
    host.holder.host = host;
    // var ID = (""+  Math.random() + Math.random()).replace(/\./g, ''); holder has id
    var ID = host.holder.id;
    host.frameList = absol.buildDom({
        tag: 'frameview',
        style: {
            width: '100%',
            height: '100%'
        }
    });
    var mainFrame = absol.buildDom({
        tag: 'singlepage',
        child: [{
                class: 'absol-single-page-header',
                child: [{
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
                        class: "info",
                        on: {
                            click: function(host) {
                                return function() {
                                    jobdesc.menu.loadPage(1);
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
            {
                class: 'absol-single-page-footer'
            }
        ]
    });
    host.frameList.addChild(mainFrame);
    host.frameList.activeFrame(mainFrame);
    switch (mode) {
        case 1:
            jobdesc.reporter_information.init(mainFrame.$viewport, host)
            break;
        case 2:
            // jobdesc.responsibility.init(container)
            break;
        case 3:
            //  jobdesc.category.init(container)
            break;
    }
    host.holder.addChild(host.frameList);

    host.contextCaptor = absol._('contextcaptor').addTo(mainFrame);

    host.contextCaptor.attachTo(mainFrame);
    jobdesc.menu.footer(absol.$('.absol-single-page-footer', mainFrame));
}
</script>

<?php } ?>