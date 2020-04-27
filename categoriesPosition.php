<?php
    function write_categoriesPosition_script() {
        global $prefix;
?>
<script type="text/javascript">
///////////////////////////////////------------------------------/////////////////////////////////////////
// jobdesc.generalInformation.index = 0;
//

jobdesc.categoriesPosition.listInfo = function(host_child, host, data, listPositions, listTask) {

    var listItm = jobdescui.listItem(host, data, "more_vert", 2);

    var list = [];

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
                    value:u.id
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
                                className: "container-index hasBolder",
                                style:{
                                    height: "calc(100% - 77px)"
                                },
                            },
                            children: listItm
                        });
    host_child.holder.appendChild(
        DOMElement.div({
            attrs: {
                className: "container_categoriesPosition",
                style: {
                    height:"100%"
                }
            },
            children: [
                DOMElement.div({
                    attrs: {
                        className: "information NoBolder",
                        style: {
                            height: "100%",
                            border: "",
                            padding: "",
                        }
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
                                    if (this._updateTimeOut !== undefined) {
                                            clearTimeout(this._updateTimeOut);
                                            this._updateTimeOut = undefined;
                                        }
                                        this._updateTimeOut = setTimeout(function () {
                                            jobdescui.Search(host, evt)
                                        }.bind(this), 500);
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

jobdesc.categoriesPosition.listInfoInit = function(host_child, host) {
    var promiseList = [];
    promiseList.push(data_module.taskContentsList.load());
    promiseList.push(data_module.positionsLibaryList.load());
    promiseList.push(data_module.tasksList.load());
    promiseList.push(data_module.link_position_taskcontent.load());
    Promise.all(promiseList).then(function() {
        jobdesc.categoriesPosition.listInfo(host_child, host, data_module.taskContentsList.items,
            data_module.positionsLibaryList.items, data_module.tasksList.items)
    })
}
</script>
<?php
}
?>