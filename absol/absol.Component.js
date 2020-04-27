var jobdescui = {};
var fuzzysortWorker = new IFrameBridge(new Worker('./fuzzysort.js'));
jobdescui.spanInput = function (param = "", param1 = "", isInput = true, dom) {
    var selectChoice;
    var style = {},
        style1 = {};

    if (typeof param !== "string") {
        style = param.style;
        param = param.text;
    }

    if (typeof param1 !== "string") {
        style1 = param1.style;
        param1 = param1.text;
    }

    if (isInput) {
        selectChoice =
            DOMElement.input({
                attrs: {
                    className: "properties",
                    value: param1,
                    style: style1,
                }
            })
    } else {
        selectChoice =
            DOMElement.textarea({
                attrs: {
                    className: "properties",
                    value: param1,
                    style: style1,
                }
            })
    }


    if (dom != undefined)
        return DOMElement.div({
            attrs: {
                className: "container-form"
            },
            children: [
                DOMElement.span({
                    attrs: {
                        className: "infotext",
                        innerHTML: param,
                        style: style,
                    }
                }),
                selectChoice,
                dom

            ]
        })
    return DOMElement.div({
        attrs: {
            className: "container-form"
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "infotext",
                    innerHTML: param,
                    style: style,
                }
            }),
            selectChoice,
        ]
    })

}

jobdescui.spanAutocompleteBox = function (param = "", list = [], param1 = "") {
    var selectChoice;
    var style = {};
    if (typeof param !== "string") {
        style = param.style;
        param = param.text;
    }

    selectChoice = absol._({
        tag: 'autocompleteinput',
        class: 'auto-properties',
        child: {
            tag: 'attachhook',
            on: {
                error: function () {
                    this.remove();
                    // window.dispatchEvent(new Event('resize'));
                }
            }
        },
        style: {
            backgroundColor: "white",
            marginLeft: "10px",
        },
        on: {
            change: function (event, sender) {
                if (sender._selectedIndex >= 0) {
                    var object = sender.adapter.texts[sender._selectedIndex];
                    console.log(object);
                }
                else {
                    //
                }
            }
        },
        props: {
            onresize: function () {
                var height = this.getBoundingClientRect().height;
                if (height > 0)
                    this.$input.addStyle('height', height + 'px')
            },
            value: param1,
            adapter: {
                texts: list.map(function (u, i) {
                    return { text: u.name, value: u.id }
                }),

                queryItems: function (query, mInput) {
                    var query = query.toLocaleLowerCase();
                    return this.texts.map(function (obj) {
                        var text = obj.text;
                        var start = text.toLocaleLowerCase().indexOf(query);
                        if (start >= 0) {
                            var hightlightedText = text.substr(0, start) + '<strong style="color:red">' + text.substr(start, query.length) + '</strong>' + text.substr(start + query.length);
                            return {
                                text: text,
                                hightlightedText: hightlightedText
                            }
                        }
                        else return null;
                    }).filter(function (it) { return it !== null; })
                },

                getItemText: function (item, mInput) {
                    return item.text;
                },

                getItemView: function (item, index, _, $, query, reuseItem, refParent, mInput) {
                    return _({
                        tag: 'div',
                        style: {
                            height: '30px'
                        },
                        child: {
                            tag: 'span',
                            props: {
                                innerHTML: item.hightlightedText
                            }
                        }
                    })
                }
            }
        }
    })

    return DOMElement.div({
        attrs: {
            className: "autocomplete-div container-form"
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "span-autocomplete infotext",
                    innerHTML: param,
                    style: style,
                }
            }),
            selectChoice,
        ]
    })

}

jobdescui.spanAutocompleteBoxUpdate = function (param = "", list = [], param1 = "", department) {
    var selectChoice;
    var style = {};
    if (typeof param !== "string") {
        style = param.style;
        param = param.text;
    }

    selectChoice = absol._({
        tag: 'autocompleteinput',
        class: 'auto-properties',
        child: {
            tag: 'attachhook',
            on: {
                error: function () {
                    this.remove();
                    // window.dispatchEvent(new Event('resize'));
                }
            }
        },
        style: {
            backgroundColor: "white",
            marginLeft: "10px",
        },
        on: {
            change: function (event, sender) {
                if (sender._selectedIndex >= 0) {
                    var object = sender.adapter.texts[sender._selectedIndex];
                    console.log(object);
                    var position=data_module.positionsList.getName(selectChoice.value);
                    if(position!==undefined)
                    {
                        department.childNodes[1].value=position.departmentid;
                        department.childNodes[1].style.pointerEvents="none";
                        department.childNodes[1].style.backgroundColor="#ebebe4";
                    }
                    else
                    {
                        department.childNodes[1].style.pointerEvents="unset";
                        department.childNodes[1].style.backgroundColor="";
                    }
                }
                else {
                    var position=data_module.positionsList.getName(selectChoice.value);
                    if(position!==undefined)
                    {
                        department.childNodes[1].value=position.departmentid;
                        department.childNodes[1].style.pointerEvents="none";
                        department.childNodes[1].style.backgroundColor="#ebebe4";
                    }
                    else
                    {
                        department.childNodes[1].style.pointerEvents="unset";
                        department.childNodes[1].style.backgroundColor="";
                    }
                }
            }
        },
        props: {
            onresize: function () {
                var height = this.getBoundingClientRect().height;
                if (height > 0)
                    this.$input.addStyle('height', height + 'px')
            },
            value: param1,
            adapter: {
                texts: list.map(function (u, i) {
                    return { text: u.name, value: u.id }
                }),

                queryItems: function (query, mInput) {
                    var query = query.toLocaleLowerCase();
                    return this.texts.map(function (obj) {
                        var text = obj.text;
                        var start = text.toLocaleLowerCase().indexOf(query);
                        if (start >= 0) {
                            var hightlightedText = text.substr(0, start) + '<strong style="color:red">' + text.substr(start, query.length) + '</strong>' + text.substr(start + query.length);
                            return {
                                text: text,
                                hightlightedText: hightlightedText
                            }
                        }
                        else return null;
                    }).filter(function (it) { return it !== null; })
                },

                getItemText: function (item, mInput) {
                    return item.text;
                },

                getItemView: function (item, index, _, $, query, reuseItem, refParent, mInput) {
                    return _({
                        tag: 'div',
                        style: {
                            height: '30px'
                        },
                        child: {
                            tag: 'span',
                            props: {
                                innerHTML: item.hightlightedText
                            }
                        }
                    })
                }
            }
        }
    })

    return DOMElement.div({
        attrs: {
            className: "autocomplete-div container-form"
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "span-autocomplete infotext",
                    innerHTML: param,
                    style: style,
                }
            }),
            selectChoice,
        ]
    })

}

jobdescui.spanAutocompleteBoxInsertDetail = function (host,param = "", list = [], param1 = "") {
    var selectChoice;
    var style = {};
    if (typeof param !== "string") {
        style = param.style;
        param = param.text;
    }

    selectChoice = absol._({
        tag: 'autocompleteinput',
        class: 'auto-properties',
        child: {
            tag: 'attachhook',
            on: {
                error: function () {
                    this.remove();
                    // window.dispatchEvent(new Event('resize'));
                }
            }
        },
        style: {
            backgroundColor: "white",
            marginLeft: "10px",
        },
        on: {
            change: function (event, sender) {
                if (sender._selectedIndex >= 0) {
                    var object = sender.adapter.texts[sender._selectedIndex];
                    host.idAccountHome=data_module.usersListHome.getName(selectChoice.value).id;
                    host.fullname.childNodes[1].value=data_module.usersListHome.getName(selectChoice.value).fullname;
                    host.email.childNodes[1].value=data_module.usersListHome.getName(selectChoice.value).email;
                    host.language.childNodes[1].value=238;
                    host.available.childNodes[1].value=data_module.usersListHome.getName(selectChoice.value).available;
                    host.theme.childNodes[1].value=data_module.usersListHome.getName(selectChoice.value).theme;
                    host.AdminTrans.childNodes[1].value=0;
                    host.AdminAccount.childNodes[1].value=0;
                    if(data_module.usersListHome.getName(selectChoice.value).privilege!==0)
                    {
                        host.AdminTrans.childNodes[1].value=1;
                        if(data_module.usersListHome.getName(selectChoice.value).privilege!==1)
                        host.AdminAccount.childNodes[1].value=1;
                    }
                    host.spanChangePassword.style.display="";
                    host.checkPassword.style.display="none";
                    host.Password.style.display="none";
                }
                else {
                    host.idAccountHome=-1;
                    host.fullname.childNodes[1].value="";
                    host.email.childNodes[1].value="";
                    host.language.childNodes[1].value=238;
                    host.available.childNodes[1].value=1;
                    host.theme.childNodes[1].value=1;
                    host.AdminTrans.childNodes[1].value=0;
                    host.AdminAccount.childNodes[1].value=0;
                    host.spanChangePassword.style.display="none";
                    host.checkPassword.style.display="";
                    host.Password.style.display="";
                }
            }
        },
        props: {
            onresize: function () {
                var height = this.getBoundingClientRect().height;
                if (height > 0)
                    this.$input.addStyle('height', height + 'px')
            },
            value: param1,
            adapter: {
                texts: list.map(function (u, i) {
                    return { text: u.name, value: u.id }
                }),

                queryItems: function (query, mInput) {
                    var query = query.toLocaleLowerCase();
                    return this.texts.map(function (obj) {
                        var text = obj.text;
                        var start = text.toLocaleLowerCase().indexOf(query);
                        if (start >= 0) {
                            var hightlightedText = text.substr(0, start) + '<strong style="color:red">' + text.substr(start, query.length) + '</strong>' + text.substr(start + query.length);
                            return {
                                text: text,
                                hightlightedText: hightlightedText
                            }
                        }
                        else return null;
                    }).filter(function (it) { return it !== null; })
                },

                getItemText: function (item, mInput) {
                    return item.text;
                },

                getItemView: function (item, index, _, $, query, reuseItem, refParent, mInput) {
                    return _({
                        tag: 'div',
                        style: {
                            height: '30px'
                        },
                        child: {
                            tag: 'span',
                            props: {
                                innerHTML: item.hightlightedText
                            }
                        }
                    })
                }
            }
        }
    })
    return DOMElement.div({
        attrs: {
            className: "autocomplete-div container-form"
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "span-autocomplete infotext",
                    innerHTML: param,
                    style: style,
                }
            }),
            selectChoice,
        ]
    })

}

jobdescui.spanSelect = function (param = "", param1 = [], value) {
    return DOMElement.div({
        attrs: {
            className: "container-form"
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "infotext",
                    innerHTML: param,
                }
            }),
            absol.buildDom({
                tag: "selectmenu",
                class:"auto-properties",
                props: {
                    items: param1,
                    value: value,
                }
            }),

        ]
    })
}

jobdescui.spanIcon = function (host, param = "", pram2 = "", className = "lv-item", content = "", title = "") {
    var it = DOMElement.div({
        attrs:{
            className:'lv-item-content',
            
        },
        innerHTML: "<span>" + param.replace(/^\s+|\s+$/g, '') + "</span>",
    });
    var temp = DOMElement.div({
        attrs: {
            className: className
        },
        children: [
            (it),
            DOMElement.div({
                attrs: {
                    className: "lv-item-right-container"
                },
                children: [
                    DOMElement.div({
                        attrs: {
                            className: "hcenter"
                        },
                        children: [
                            DOMElement.div({
                                attrs: {
                                    className: "vcenter"
                                },
                                children: [ 
                                    absol.buildDom({
                                        tag: "i",
                                        class: 'material-icons',
                                        props: {
                                            innerHTML: pram2
                                        },
                                        on: {
                                            click: function (event) {
                                                jobdescui.addInfoText(host, content, title)
                                            }
                                        }
                                    })
                                ]
                            })
                        ]
                    }),
                    
                ]
            })
            

        ]
    })
    return temp;
}

jobdescui.spanIconList = function (host, param = "", param2 = "", className = "lv-item", data) {
    var list = []
    var h, sym, con, temp;
    sym = DOMElement.i({
        attrs: {
            className: "material-icons",
            style: {
                fontSize: "20px",
                color: "#929292"
            }
        },

        text: "mode_edit"
    });
    con = DOMElement.div({
        attrs: {
            style: {
                width: "100px"
            }
        },
        text: LanguageModule.text("ctrl_edit")
    });
    sym.onmouseover = con.onmouseover = function (sym, con) {
        return function (event, me) {
            sym.style.color = "black";
            con.style.color = "black";
        }
    }(sym, con);
    sym.onmouseout = con.onmouseout = function (sym, con) {
        return function (event, me) {
            sym.style.color = "#929292";
            con.style.color = "#929292";
        }
    }(sym, con);
    list.push({
        attrs: {
            style: {
                width: "170px"
            }
        },
        symbol: sym,
        content: con,
        onclick: function () {
            return function (event) {
                //host.searchboxvalue = host.searchbox.value;
                // for (var i = 0; i < result.parentNode.children.length; i++) {
                //     if (result.parentNode.childNodes[i].classList.contains("choice"))
                //         result.parentNode.childNodes[i].classList.remove("choice");
                // }
                console.log(temp)
                if (host.me !== undefined)
                    host.me.classList.remove("choice");
                temp.classList.add("choice");
                host.me = temp;
                jobdescui.createIndexEdit(host, data);
                DOMElement.cancelEvent(event);
                return false;
            }
        }()
    });
    // sym = DOMElement.i({
    //     attrs: {
    //         className: "material-icons",
    //         style: {
    //             fontSize: "20px",
    //             color: "#929292"
    //         }
    //     },
    //     text: "pageview"
    // });
    // con = DOMElement.div({
    //     attrs: {
    //         style: {
    //             width: "100px"
    //         }
    //     },
    //     text: LanguageModule.text("title_preview")
    // });
    // sym.onmouseover = con.onmouseover = function (sym, con) {
    //     return function (event, me) {
    //         sym.style.color = "red";
    //         con.style.color = "black";
    //     }
    // }(sym, con);
    // sym.onmouseout = con.onmouseout = function (sym, con) {
    //     return function (event, me) {
    //         sym.style.color = "#929292";
    //         con.style.color = "#929292";
    //     }
    // }(sym, con);
    // list.push({
    //     attrs: {
    //         style: {
    //             width: "170px"
    //         }
    //     },
    //     symbol: sym,
    //     content: con,
    //     onclick: function (id) {
    //         return function (event, me) {
    //             blackTheme.reporter.exportWord(id);
    //         }
    //     }()
    // });
    sym = DOMElement.i({
        attrs: {
            className: "material-icons",
            style: {
                fontSize: "20px",
                color: "#929292"
            }
        },
        text: "delete"
    }),
        con = DOMElement.div({
            attrs: {
                style: {
                    width: "100px"
                }
            },
            text: LanguageModule.text("ctrl_delete")
        });
    sym.onmouseover = con.onmouseover = function (sym, con) {
        return function (event, me) {
            sym.style.color = "red";
            con.style.color = "black";
        }
    }(sym, con);
    sym.onmouseout = con.onmouseout = function (sym, con) {
        return function (event, me) {
            sym.style.color = "#929292";
            con.style.color = "#929292";
        }
    }(sym, con);
    list.push({
        attrs: {
            style: {
                width: "170px"
            }
        },
        symbol: sym,
        content: con,
        onclick: function (host,id,temp) {
            return function (event, me) {
                //host.searchboxvalue = host.searchbox.value;
                console.log(id)
                    
                blackTheme.reporter.removeTaskContent(id);
                
                DOMElement.cancelEvent(event);
                return false;
            }
        }(host,data.id,temp)
    });
    h = DOMElement.choicelist({
        textcolor: "#929292",
        align: "right",
        symbolattrs: {
            style: {
                width: "40px"
            }
        },
        list: list
    });
    // h.style.position = "absolute";
    h.style.left = "12px";

    var it = DOMElement.div({
        attrs:{
            className:'lv-item-content',
            
        },
        innerHTML: "<span>" + param.replace(/^\s+|\s+$/g, '') + "</span>",
        
    });
    it.addEventListener("click", function(){
        console.log(temp)
        if (host.me !== undefined)
            host.me.classList.remove("choice");
        temp.classList.add("choice");
        host.me = temp;
        jobdescui.createIndexPreViewTaskContent(host,data);
    })
    temp = DOMElement.div({
        attrs: {
            className: className
        },
        children: [
            (it),
            DOMElement.div({
                attrs: {
                    className: "lv-item-right-container"
                },
                children: [
                    DOMElement.div({
                        attrs: {
                            className: "hcenter"
                        },
                        children: [
                            DOMElement.div({
                                attrs: {
                                    className: "vcenter"
                                },
                                children: [ 
                                    h,
                                    DOMElement.i({
                                        attrs: {
                                            className: "material-icons " + DOMElement.dropdownclass.button,
                                            style: {
                                            },
                                            onclick: function (host) {
                                                return function (event, me) {
                                                    host.style.top = "60px";
                                                    host.toggle();
                                                    if(!jobdescui.elementInViewport(host.childNodes[0]))
                                                        {
                                                            host.style.top = -host.childNodes[0].clientHeight +"px";
                                                        }
                                                    else{
                                                        host.style.top = 0 +"px";
                                                    }
                                                    console.log(host.childNodes[0].clientHeight)
                                                    DOMElement.cancelEvent(event);
                                                    return false;
                                                }
                                            }(h)
                                        },
                                        text: param2,
                                    })
                                ]
                            })
                        ]
                    }),
                    
                ]
            })

        ]
    })
    return temp;
};

jobdescui.listItem = function (host, list, typeIcon = "file_copy", mode = 1) {
    if (data_module.taskContentsList.hosts === undefined)
        data_module.taskContentsList.hosts = [];
    switch (mode) {
        case 1:
            var result = [];
            for (var i = 0; i < list.length; i++) {
                view = jobdescui.spanIcon(host, list[i].content, typeIcon, "lv-item", list[i].content, list[i].taskid);
                result.push(
                    view
                )
            }
            host.type="preview";
            data_module.taskContentsList.hosts.push(host);
            break;
        case 2:
            var result = [];
            for (var i = 0; i < list.length; i++) {
                var view = jobdescui.spanIconList(host, list[i].content, typeIcon, "lv-item", list[i]);
                view.id = list[i].id;
                result.push(
                    view
                    //jobdescui.spanIconList(host, list[i].content, typeIcon, "lv-item", list[i].content,list[i].positionid,list[i].taskid,list[i].id)
                )
            }
            host.type="edit";
            data_module.taskContentsList.hosts.push(host);
            break;
        default:
            break;
    }
    return result;
}

jobdescui.Search = function (host, evt) {
    host.evt = evt;
    host.values = host.selectBox.values.length;
    var arr=[];
        if (evt.target.value !== "") {
            for(var i=0;i<data_module.taskContentsList.items.length;i++){
                if (host.checkSearch[data_module.taskContentsList.items[i].id] === undefined)
                    host.checkSearch[data_module.taskContentsList.items[i].id] = {}
                if (host.checkSearch[data_module.taskContentsList.items[i].id].values === undefined)
                    host.checkSearch[data_module.taskContentsList.items[i].id].values = 0;
                else arr.push(data_module.taskContentsList.items[i].content); 
            }
            // console.log(arr);
            const options = {
                limit: 100, // don't return more results than you need!
                allowTypo: true, // if you don't care about allowing typos
                threshold: -100000, // don't return bad results
              }
              var start = Date.now();

            //  = fuzzysort.goAsync(evt.target.value, arr, options)
            jobdescui.Search.promise = fuzzysortWorker.invoke('goAsync',evt.target.value, arr, options)
            jobdescui.Search.promise.then(function (results) {
                console.log(results)
                var millis = Date.now() - start;
                console.log("seconds elapsed = " + Math.floor(millis));
                for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
                    if (jobdescui.indexForResult(results, data_module.taskContentsList.items[i].content))
                        host.checkSearch[data_module.taskContentsList.items[i].id].check = 1;
                    else
                        host.checkSearch[data_module.taskContentsList.items[i].id].check = 0;
                    if (host.checkSearch[data_module.taskContentsList.items[i].id].check == 1 && (host.checkSearch[data_module.taskContentsList.items[i].id].values > 0 || host.selectBox.values.length == 0))
                        host.views.childNodes[i].style.display = ""
                    else {
                        host.views.childNodes[i].style.display = "none"
                    }
                }
            })
        } else {
            for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
                if (host.checkSearch[data_module.taskContentsList.items[i].id] === undefined)
                    host.checkSearch[data_module.taskContentsList.items[i].id] = {}
                if (host.checkSearch[data_module.taskContentsList.items[i].id].values === undefined)
                    host.checkSearch[data_module.taskContentsList.items[i].id].values = 0;
    
                host.checkSearch[data_module.taskContentsList.items[i].id].check = 1;
    
                if (host.checkSearch[data_module.taskContentsList.items[i].id].check === 1 && (host.checkSearch[data_module.taskContentsList.items[i].id].values > 0 || host.selectBox.values.length == 0))
                    host.views.childNodes[i].style.display = ""
                else {
                    host.views.childNodes[i].style.display = "none"
                }
            }
        }
    
}

jobdescui.indexForResult = function (array, index) {
    for (var i = 0; i < array.length; i++) {
        if (index === array[i].target)
            return true;
    }
    return false;
}

jobdescui.addInfoText = function (host, content = "", title = "") {
    if (host.editorFocus !== undefined) {
        host.editorFocus.setData(jobdescui.deleteWordLast(host.editorFocus.getData(), "</ul>") + "<li>" + content + "</li>" + "</ul>");
        host.editorFocus.focus();

        if (host.editorFocus.spanTitle !== undefined) {
            host.editorFocus.spanTitle.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
            if (host.editorFocus.spanTitle.innerHTML === "" && title !== "") {
                var titleText = data_module.tasksList.getID(title);
                host.editorFocus.spanTitle.innerHTML = titleText.name;
            }
        }
    }

}

jobdescui.setTask = function (host, result) {
    host.buttonAddWork.style.display="inline-block";
    if (host.state != result.id) {
        if (host.me !== undefined)
            host.me.classList.remove("choice");
        result.classList.add("choice");
        host.me = result;
        jobdesc.responsibility.removeandSaveData(host, result.id)
        host.state = result.id
        if (host.listEditor === undefined)
            host.listEditor = []
        if (host.data[host.state] !== undefined && host.data[host.state].data !== undefined)
            for (var i = 0; i < host.data[host.state].data.length; i++) {
                jobdescui.createIndex(host, host.data[host.state].data[i][0], host.data[host.state].data[i][1])
            }
    }
    host.editorFocus = undefined;
}

jobdescui.extract = async function (id,edit=true){
        var widthTable,strong,strongend;
        if(edit)
        {
            widthTable="calc(100% - 200px)";
            strong="<strong>";
            strongend="</strong>"
        }else{
            widthTable="100%";
            strong="";
            strongend=""
        }
       
        var margin="margin-left:0px";
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //As January is 0.
        var yyyy = today.getFullYear();
        var bigSize = 18.5;
        var normalSize = 16;
        var tinySize = normalSize;
        var styleCellTable="font-size:"+tinySize+"px; font-family:Times New Roman,Times,serif";
        var string = `<p style="text-align:center"><strong><span style="font-size:`+bigSize+`px; font-family:Times New Roman,Times,serif;">BẢNG M&Ocirc; TẢ C&Ocirc;NG VIỆC, TI&Ecirc;U CHUẨN&nbsp;C&Ocirc;NG VIỆC&nbsp;</span></strong></p>
        <p style="text-align:center">
        `;
        string+=`<p style="text-align:center"><strong><span style="font-size:`+bigSize+`px; font-family:Times New Roman,Times,serif;">`+ data_module.positionsList.getID(data_module.usersDataList.items[id].position).name +`</span></strong><br/>`
        string+=`<strong><span style="font-size:`+normalSize+`px; font-family:Times New Roman,Times,serif;">`+ data_module.departmentsList.getID(data_module.positionsList.getID(data_module.usersDataList.items[id].position).departmentid).name +`</span></strong></p>`;

        string+=`<table align="center" border="1" cellpadding="1" cellspacing="0" style="width:`+ widthTable +`">
        <thead>
            <tr>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Quản lý trực tiếp</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].direct+`</span></strong>
                </td>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Ký hiệu</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].jobCode+`</span></strong>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Quản lý gián tiếp</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].indirect+`</span></strong>
                </td>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Soát xét</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].ransack+`</span></strong>
                </td>
            </tr>
            <tr>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Thời gian làm việc</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].working_time+`</span></strong>
                </td>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">Ngày hiệu lực</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+dd+"/"+mm+"/"+yyyy+`</span></strong>
                </td>
            </tr>
            <tr>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+LanguageModule.text("title_job_replace")+`</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.usersDataList.items[id].jobReplace+`</span></strong>
                </td>
                <td style="width:100px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+LanguageModule.text("title_country")+`</span></strong>
                </td>
                <td style="width:200px; text-align:center;">
                <strong><span style="`+ styleCellTable +`">`+data_module.countriesList.getID(data_module.usersDataList.items[id].country).country_name+`</span></strong>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    `;
        
        for (var i = 0; i < data_module.usersDataList.items[id].data.length; i++) {
            if (data_module.usersDataList.items[id].data[i].title !== undefined) {
                string += `<div style="background:#eeeeee; border:none; padding:0"><h1 style="`+margin+`;">`+strong+`<span style="font-size:`+bigSize+`px"><span style="background-color:#ffffff; font-family:Times New Roman&quot;,Times,serif font-size:`+bigSize+`px">` +i + `. </span><span style="background-color:#eeeeee">` +  data_module.usersDataList.items[id].data[i].title + `</span></span>`+strongend+`</h1></div>`

                if (data_module.usersDataList.items[id].data[i].data !== undefined) {
                    for(var j=0;j<data_module.usersDataList.items[id].data[i].data.length;j++){
                        console.log(data_module.usersDataList.items[id].data[i].data[j][0])
                        if(data_module.usersDataList.items[id].data[i].data[j][0]!==""){
                            string += `<h1 style="`+margin+`">`+strong+`<span style="font-family:Times New Roman,Times,serif; font-size:`+bigSize+`px;">` + data_module.usersDataList.items[id].data[i].data[j][0] + `</span>`+strongend+`</h1>`;
                            if(data_module.usersDataList.items[id].data[i].data[j][1]!=="")
                            string +=`<div style="`+margin+`"><span style="font-family:Times New Roman,Times,serif"><span style="font-size:`+tinySize+`px">`+ data_module.usersDataList.items[id].data[i].data[j][1]+ `</span></span></div>`;
                        }
                        else
                        if(data_module.usersDataList.items[id].data[i].data[j][1]!=="")
                        string +=`<div style="`+margin+`"><span style="font-family:Times New Roman,Times,serif"><span style="font-size:`+tinySize+`px">`+ data_module.usersDataList.items[id].data[i].data[j][1]+ `</span></span></div>`;
                    }
                    
                }
            }
        }
        console.log(string)
        return string

}

jobdescui.removeCkeditor = function(host)
{
    DOMElement.removeAllChildren(host.bot);
    if(host.editorFocus!==undefined)
    host.editorFocus.destroy();
    if(host.EditorCurrent!==undefined)
    host.EditorCurrent.destroy();
    if(host.listEditor!==undefined)
    for(var i=0;i<host.listEditor.length;i++)
    {
        host.listEditor[i].destroy();
    }
    host.me=undefined;
}

jobdescui.createIndexPreView  = function(host,id,mode=1)
{
    var textId = ("text_" + Math.random() + Math.random()).replace(/\./g, '');
    var done=false;
    CKEDITOR.config.readOnly = true;
    console.log(textId)
    if(host.editorFocus!==undefined)
    host.editorFocus.destroy();
    if(host.EditorCurrent!==undefined)
    host.EditorCurrent.destroy();

    DOMElement.removeAllChildren(host.containerList);
    host.containerList.appendChild(
        DOMElement.div({
            attrs: {
                className: "container-bot",
                id: textId,
                style: {
                    border: "1px solid #d6d6d6",
                }
            },
            children: [
            ]
        })
    );
    var promiseAll=[];
    var promiseAll=[];
    promiseAll.push(data_module.countriesList.load());
    promiseAll.push(data_module.company.load());
    promiseAll.push(data_module.usersDataList.load());
    Promise.all(promiseAll).then(function() {
    var promise = new Promise(function (resolve, reject) {
        var ckedit = absol.buildDom({
            tag: 'attachhook',
            on: {
                error: function () {
                    this.selfRemove();
                    editor = CKEDITOR.replace(textId);
                    window.listEditor.push(editor);
                    host.EditorCurrent=editor;
                    jobdescui.extract(id).then(function(resolve){
                        editor.setData(resolve);
                    })

                    var waitLoad = setInterval(function () {
                        if (editor.loaded) {
                            clearInterval(waitLoad);
                            editor.resize("100%", window.innerHeight - 142);
                            var container = document.getElementById("cke_"+textId);
                            container.style.height="calc(100% - 1px)";
                            container.getElementsByClassName("cke_inner")[0].style.height="100%";
                            container.getElementsByClassName("cke_contents")[0].style.height="100%";
                            if(mode===1){
                                var arr=container.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                                arr=container.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                            }
                            else
                            {
                                var arr=host.containerList.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                                arr=host.containerList.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                            }
                        }
                    }, 100);
                    setTimeout(function () {
                        clearInterval(waitLoad);
                    }, 10000)
                    editor.on('focus', function (e) {
                        host.editorFocus = editor;
                        absol.$(document.body).emit('click')
                    });
                    done = true;
                    resolve();
                }
            }
        });
        
    });
    })
    
   
}

jobdescui.createIndexPreViewTaskContent  = function(host,list,mode=1)
{
    host.save.style.display="none";
    var temp;
    var promise;
    var content, position, task;
    CKEDITOR.config.readOnly = true;
    if (list === undefined) {
        position = [];
        content = ""
        task = "";
    }
    else {
        task = list.taskid
        content = list.content;
        content = content;
        position = data_module.taskContentsList.getPosition(list.id);
        if (data_module.tasksList.getID(task) === undefined) {
            console.log(list)
            task = "";
        }
        else
            task = data_module.tasksList.getID(task).name;
    }



    for (var i = 0; i < host.listEditor.length; i++) {
        host.listEditor[i].destroy();
    }
    host.listEditor = [];

    DOMElement.removeAllChildren(host.containerList);

    var editor;
    var spanlabelPosition = DOMElement.div({
        attrs: {
            className: "infotext",
            style: {
                width: "10%",
                border: "solid 1px #c0c0c0",
                borderRight: "none",
            }
        },
        children: [
            DOMElement.span({
                attrs: {
                    innerHTML: LanguageModule.text("title_position") ,
                }
            })
        ]
    })

    var spantitlePosition = absol._({
        tag: 'selectbox',
        style: {
            display: 'table-cell',
            width: "37%",
            backgroundColor: "white",
            borderRadius: "unset"
        },
        props: {
            enableSearch: true,
            items: data_module.positionsLibaryList.items.map(function (u, i) {
                return { text: u.name, value:u.id }
            }),
            values: position,

        },
        on: {
            add: function (evt) {
                console.log(evt);
                window.dispatchEvent(new Event('resize'));
            },
            remove: function (evt) {
                console.log(evt)
                window.dispatchEvent(new Event('resize'));
            },
        }
    })

    spantitlePosition.style.pointerEvents="none";
    spantitlePosition.style.backgroundColor="#ebebe4";


    var spanlabelTask = DOMElement.div({
        attrs: {
            className: "infotext",
            style: {
                width: "10%",
                border: "solid 1px #c0c0c0",
                borderLeft: "none",
                borderRight: "none"
            }
        },
        children: [
            DOMElement.span({
                attrs: {
                    innerHTML: LanguageModule.text("title_nametask") ,

                }
            })
        ]
    })
    var spantitleTask = absol._({
        tag: 'autocompleteinput',
        child: {
            tag: 'attachhook',
            on: {
                error: function () {
                    this.remove();
                    window.dispatchEvent(new Event('resize'));
                }
            }
        },
        style: {
            width: "43%",
            backgroundColor: "white",
            borderLeft: "none",
            border: "1px solid rgb(214, 214, 214)",
            display: "table-cell"
        },
        on: {
            change: function (event, sender) {
                if (sender._selectedIndex >= 0) {
                    var object = sender.adapter.texts[sender._selectedIndex];
                    console.log(object);
                }
                else {
                    //
                }
            }
        },
        props: {
            onresize: function () {
                this.$input.removeStyle('height');
                var height = spantitlePosition.getBoundingClientRect().height;
                //console.log(editor)
                if (height > 0)
                    this.$input.addStyle('height', height + 'px');
                if (editor !== undefined) {
                    editor.resize("100%", window.innerHeight - height - 263)
                }
                //editor.config.height = window.innerHeight - height - 335;
            },
            value: task,
            adapter: {
                texts: data_module.tasksList.items.map(function (u, i) {
                    return { text: u.name, value: u.id }
                }),

                queryItems: function (query, mInput) {
                    var query = query.toLocaleLowerCase();
                    return this.texts.map(function (obj) {
                        var text = obj.text;
                        var start = text.toLocaleLowerCase().indexOf(query);
                        if (start >= 0) {
                            var hightlightedText = text.substr(0, start) + '<strong style="color:red">' + text.substr(start, query.length) + '</strong>' + text.substr(start + query.length);
                            return {
                                text: text,
                                hightlightedText: hightlightedText
                            }
                        }
                        else return null;
                    }).filter(function (it) { return it !== null; })
                },

                getItemText: function (item, mInput) {
                    return item.text;
                },

                getItemView: function (item, index, _, $, query, reuseItem, refParent, mInput) {
                    return _({
                        tag: 'div',
                        style: {
                            height: '30px'
                        },
                        child: {
                            tag: 'span',
                            props: {
                                innerHTML: item.hightlightedText
                            }
                        }
                    })
                }
            }
        }
    })

    spantitleTask.style.pointerEvents="none";
    spantitleTask.style.backgroundColor="#ebebe4";
    spantitleTask.childNodes[0].setAttribute("disabled","");
    
    window.spantitlePosition = spantitlePosition;
    host.Position = spantitlePosition;
    host.Task = spantitleTask;

    absol.Dom.addToResizeSystem(spantitleTask);

    var top = DOMElement.div({
        attrs: {
            className: "container-top",
            style: {
                width: "100%",
                border: "1px solid #d6d6d6",
            }
        },
        children: [
            spanlabelPosition,
            spantitlePosition,
            spanlabelTask,
            spantitleTask
        ]
    });
    top = DOMElement.div({
        attrs: {
            style: {
                display: "table",
                width: "100%",
            }
        },
        children: [top]
    });
    var margin = DOMElement.div({
        attrs: {
            className: "margin",
            style: {
            }
        }
    });

    var textId = ("text_" + Math.random() + Math.random()).replace(/\./g, '');

    if(host.bot===undefined){
        host.bot = DOMElement.div({
            attrs: {
                className: "container-bot-in-body",
            },
            children: [
                DOMElement.div({
                    attrs: {
                        className: "container-bot",
                        id: textId,
                        style: {
                            border: "1px solid #d6d6d6",
                        }
                    },
                    children: [
                    ]
                })
            ]
        });
    }
    else
    {
        DOMElement.removeAllChildren(host.bot);
        host.bot.appendChild(DOMElement.div({
            attrs: {
                className: "container-bot",
                id: textId,
                style: {
                    border: "1px solid #d6d6d6",
                }
            },
            children: [
            ]
        }))
    }
    var promise = new Promise(function (resolve, reject) {
        var ckedit = absol.buildDom({
            tag: 'attachhook',
            on: {
                error: function () {
                    this.selfRemove();
                    editor = CKEDITOR.replace(textId);
                    editor.setData(content);
                    var waitLoad = setInterval(function () {
                        if (editor.loaded) {
                            clearInterval(waitLoad);
                            var container = document.getElementById("cke_"+textId);
                            
                            if(mode===1){
                                var arr=container.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                                arr=container.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                            }
                            else
                            {
                                var arr=container.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                                arr=container.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                            }
                            container.getElementsByClassName("cke_inner")[0].style.height="100%";
                            container.getElementsByClassName("cke_contents")[0].style.height="100%";
                            container.style.height="100%";
                            editor.updateSizeContent = function(height)
                            {
                                host.bot.style.height="calc(100% - "+(height)+"px)"
                            }
                            
                            window.onresize = function()
                            {
                                editor.updateSizeContent(top.clientHeight+margin.clientHeight);
                            }

                            editor.updateSizeContent(top.clientHeight+margin.clientHeight);
                        }
                    }, 100);
                    setTimeout(function () {
                        clearInterval(waitLoad);
                    }, 10000)
                    editor.on('focus', function (e) {
                        host.editorFocus = editor;
                        absol.$(document.body).emit('click')
                    });
                    host.listEditor.push(editor);
                    
                }
            }
        });
        
        resolve();
        host.bot.appendChild(ckedit);
    });

    temp = DOMElement.div({
        attrs: {
            className: "index-top-bot",
            style: {}
        },
        children: [
            top,
            margin,
            host.bot,
        ]
    })
    console.log()
    absol.$(temp);
    promise.then(function(){
        host.containerList.appendChild(
            temp)
    })
}

jobdescui.createIndex = function (host, title = "", dataList = "", pos, mode=1) {
    if(jobdescui.createIndex.mode===undefined)
    jobdescui.createIndex.mode=mode;
    
    var temp;
    var done = false;
    var promise;
    CKEDITOR.config.readOnly = false;

    // if (host.containerList.children.length === 0) {
    //     host.containerList.style.background = "rgb(247, 246, 246)";
    // }
    var editor;
    var spantitle = DOMElement.span({
        attrs: {
            className: "infotext",
            innerHTML: title,
            style: {
                backgroundColor: "white",
                borderRight: "1px solid rgb(214, 214, 214)"
            }
        }
    })
    spantitle.setAttribute("contenteditable", "true")
    spantitle.setAttribute("data-placeholder", LanguageModule.text("title_nametask"))
    var STT;
    var margin = DOMElement.div({
        attrs: {
            className: "margin",
            style: {
            }
        }
    });

    var textId = ("text_" + Math.random() + Math.random()).replace(/\./g, '');
    
    var bot = DOMElement.div({
        attrs: {
            className: "container-bot",
            id: textId,
            style: {
                border: "1px solid #d6d6d6"
            }
        },
        children: [

        ]
    });

    var promise = new Promise(function (resolve, reject) {
        var ckedit = absol.buildDom({
            tag: 'attachhook',
            on: {
                error: function () {
                    this.selfRemove();
                    editor = CKEDITOR.replace(textId);
                    editor.setData(dataList);
                    var waitLoad = setInterval(function () {
                        if (editor.loaded) {
                            clearInterval(waitLoad);
                            var container = document.getElementById("cke_"+textId);
                            container.style.setProperty('position', 'static', 'important');
                            container.style.left='unset';
                            container.style.top='unset';
                            if(jobdescui.createIndex.mode!==1){
                                var arr= container.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                                arr= container.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display="none"
                                }
                            }
                            else
                            {
                                var arr= container.getElementsByClassName("cke_bottom");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                                arr= container.getElementsByClassName("cke_top");
                                for(var i=0;i<arr.length;i++)
                                {
                                    arr[i].style.display=""
                                }
                            }
                            temp.scrollIntoView({behavior: "smooth", block: "start", inline: "start"});                            
                        }
                    }, 100);
                    setTimeout(function () {
                        clearInterval(waitLoad);
                    }, 10000)
                    editor.on('focus', function (e) {
                        host.editorFocus = editor;
                        host.editorFocus.spanTitle = spantitle;
                        absol.$(document.body).emit('click')
                    });
                    done = true;
                   
                    resolve();
                }
            }
        });
        bot.appendChild(ckedit);
    });

    var top = DOMElement.div({
        attrs: {
            className: "container-top",
            style: {
            }
        },
        children: [
            spantitle,
            absol.buildDom({
                tag: 'i',
                class: 'material-icons',
                style: {
                    paddingLeft: "10px",
                },
                props: {
                    innerHTML: 'keyboard'
                },
                on: {
                    click: function (event) {
                        if (done) {
                                if(jobdescui.createIndex.mode===1){
                                    var arr= host.bot.getElementsByClassName("cke_bottom");
                                    for(var i=0;i<arr.length;i++)
                                    {
                                        arr[i].style.display="none"
                                    }
                                    arr= host.bot.getElementsByClassName("cke_top");
                                    for(var i=0;i<arr.length;i++)
                                    {
                                        arr[i].style.display="none"
                                    }
                                }
                                else
                                {
                                    var arr= host.bot.getElementsByClassName("cke_bottom");
                                    for(var i=0;i<arr.length;i++)
                                    {
                                        arr[i].style.display=""
                                    }
                                    arr= host.bot.getElementsByClassName("cke_top");
                                    for(var i=0;i<arr.length;i++)
                                    {
                                        arr[i].style.display=""
                                    }
                                }
                                setTimeout(function(){
                                    host.bot.requestUpdateSize();
                                },10)
                                jobdescui.createIndex.mode=-jobdescui.createIndex.mode;
                                setTimeout(function(){
                                    host.bot.requestUpdateSize();
                                },10)
                        }
                    }
                }
            }),
            absol.buildDom({
                tag: 'i',
                class: 'material-icons',
                props: {
                    innerHTML: 'arrow_downward'
                },
                on: {
                    click: function (event) {
                        if (done) {
                            STT = jobdescui.getSTT(temp.parentNode, temp)
                            if (temp.parentNode.children.length > STT + 1) {
                                host.listEditor.splice(STT,1);
                                jobdescui.createIndex(host, spantitle.innerHTML, editor.getData(), STT + 2)
                                console.log(host.listEditor)
                                editor.destroy();
                                temp.selfRemove();
                            }
                        }
                    }
                }
            }),
            absol.buildDom({
                tag: 'i',
                class: 'material-icons',
                props: {
                    innerHTML: 'arrow_upward'
                },
                on: {
                    click: function (event) {
                        if (done) {
                            STT = jobdescui.getSTT(temp.parentNode, temp)
                            if (STT > 0 && temp.parentNode.children.length > 0) {
                                host.listEditor.splice(STT,1);
                                jobdescui.createIndex(host, spantitle.innerHTML, editor.getData(), STT - 1)
                                editor.destroy();
                                temp.selfRemove();
                            }
                        }
                    }
                }
            }),
            absol.buildDom({
                tag: 'i',
                class: 'material-icons',
                style: {
                    borderRight: "1px solid #d6d6d6",
                    paddingRight: "10px",
                },
                props: {
                    innerHTML: 'cancel'
                },
                on: {
                    click: function (event) {
                        if (done) {
                            STT = jobdescui.getSTT(temp.parentNode, temp)
                            host.listEditor.splice(STT,1);
                            host.listEditor = host.listEditor.filter(word => word !== undefined)
                            editor.destroy();
                            temp.selfRemove();
                        }
                    }
                }
            })
        ]
    });

    temp = DOMElement.div({
        attrs: {
            className: "index-top-bot",
            style: {}
        },
        children: [
            top,
            margin,
            bot,
        ]
    })
    
    
    absol.$(temp);
    if (host.bot !== undefined) {
        if (pos !== undefined) {
            if (host.bot.childNodes[0].children.length <= pos) {

                host.bot.childNodes[0].appendChild(temp);
                promise.then(function () {
                    host.listEditor.push([spantitle, editor]);
                })
            } else {
                host.bot.childNodes[0].insertBefore(
                    temp,
                    host.bot.childNodes[0].childNodes[pos]
                )
                promise.then(function () {
                    jobdescui.addOneArray(host.listEditor, [spantitle, editor], pos)
                })
            }
        } else if (host.editorFocus !== undefined && host.editorFocus.element != undefined) {
            if (host.editorFocus.element.$.nextSibling !== undefined) {
                host.bot.childNodes[0].insertBefore(temp, host.editorFocus.element.$.parentNode.nextSibling);
                promise.then(function () {
                    jobdescui.addOneArray(host.listEditor, [spantitle, editor], jobdescui.getSTT(host.editorFocus.element.$.parentNode.parentNode, host.editorFocus.element.$.parentNode.nextSibling))
                    console.log(jobdescui.getSTT(host.editorFocus.element.$.parentNode.parentNode, host.editorFocus.element.$.parentNode.nextSibling))
                })
            } else {
                host.bot.childNodes[0].appendChild(temp);
                promise.then(function () {
                    host.listEditor.push([spantitle, editor]);
                })
            }
        } else {
            host.bot.childNodes[0].appendChild(temp);
            promise.then(function () {
                host.listEditor.push([spantitle, editor]);
            })
        }

    } else {
        host.bot=absol.buildDom({
            tag: 'vscroller',
            child: [
                temp,
            ]
        })
        host.containerList.appendChild(host.bot)
        promise.then(function () {
            host.listEditor.push([spantitle, editor]);
        })
    }

}

jobdescui.createIndexEdit = function (host, list) {
    host.save.style.display="inline-block";
    var temp;
    var promise;
    var content, position, task;
    CKEDITOR.config.readOnly = false;
    if (list === undefined) {
        if(host.Position!==undefined)
        position = host.Position.values;
        else
        position=""
        content = "";
        if(host.Task!==undefined)
        task = host.Task.value;
        else
        task=""
    }
    else {
        task = list.taskid
        content = list.content;
        content = content;
        position = data_module.taskContentsList.getPosition(list.id);
        if (data_module.tasksList.getID(task) === undefined) {
            console.log(list)
            task = "";
        }
        else
            task = data_module.tasksList.getID(task).name;
    }



    for (var i = 0; i < host.listEditor.length; i++) {
        host.listEditor[i].destroy();
    }
    host.listEditor = [];

    DOMElement.removeAllChildren(host.containerList);

    var editor;
    var spanlabelPosition = DOMElement.div({
        attrs: {
            className: "infotext",
            style: {
                width: "10%",
                border: "solid 1px #c0c0c0",
                borderRight: "none",
            }
        },
        children: [
            DOMElement.span({
                attrs: {
                    innerHTML: LanguageModule.text("title_position") ,
                }
            })
        ]
    })

    var spantitlePosition = absol._({
        tag: 'selectbox',
        style: {
            display: 'table-cell',
            width: "37%",
            backgroundColor: "white",
            borderRadius: "unset"
        },
        props: {
            enableSearch: true,
            items: data_module.positionsLibaryList.items.map(function (u, i) {
                return { text: u.name, value:u.id }
            }),
            values: position,

        },
        on: {
            add: function (evt) {
                console.log(evt);
                window.dispatchEvent(new Event('resize'));
            },
            remove: function (evt) {
                console.log(evt)
                window.dispatchEvent(new Event('resize'));
            },
        }
    })


    var spanlabelTask = DOMElement.div({
        attrs: {
            className: "infotext",
            style: {
                width: "10%",
                border: "solid 1px #c0c0c0",
                borderLeft: "none",
                borderRight: "none"
            }
        },
        children: [
            DOMElement.span({
                attrs: {
                    innerHTML: LanguageModule.text("title_nametask") ,

                }
            })
        ]
    })
    var spantitleTask = absol._({
        tag: 'autocompleteinput',
        child: {
            tag: 'attachhook',
            on: {
                error: function () {
                    this.remove();
                    window.dispatchEvent(new Event('resize'));
                }
            }
        },
        style: {
            width: "43%",
            backgroundColor: "white",
            borderLeft: "none",
            border: "1px solid rgb(214, 214, 214)",
            display: "table-cell"
        },
        on: {
            change: function (event, sender) {
                if (sender._selectedIndex >= 0) {
                    var object = sender.adapter.texts[sender._selectedIndex];
                    console.log(object);
                }
                else {
                    //
                }
            }
        },
        props: {
            onresize: function () {
                this.$input.removeStyle('height');
                var height = spantitlePosition.getBoundingClientRect().height;
                //console.log(editor)
                if (height > 0)
                    this.$input.addStyle('height', height + 'px');
                if (editor !== undefined) {
                    editor.updateSizeContent(height);
                }
            },
            value: task,
            adapter: {
                texts: data_module.tasksList.items.map(function (u, i) {
                    return { text: u.name, value: u.id }
                }),

                queryItems: function (query, mInput) {
                    var query = query.toLocaleLowerCase();
                    return this.texts.map(function (obj) {
                        var text = obj.text;
                        var start = text.toLocaleLowerCase().indexOf(query);
                        if (start >= 0) {
                            var hightlightedText = text.substr(0, start) + '<strong style="color:red">' + text.substr(start, query.length) + '</strong>' + text.substr(start + query.length);
                            return {
                                text: text,
                                hightlightedText: hightlightedText
                            }
                        }
                        else return null;
                    }).filter(function (it) { return it !== null; })
                },

                getItemText: function (item, mInput) {
                    return item.text;
                },

                getItemView: function (item, index, _, $, query, reuseItem, refParent, mInput) {
                    return _({
                        tag: 'div',
                        style: {
                            height: '30px'
                        },
                        child: {
                            tag: 'span',
                            props: {
                                innerHTML: item.hightlightedText
                            }
                        }
                    })
                }
            }
        }
    })

    window.spantitlePosition = spantitlePosition;
    host.Position = spantitlePosition;
    host.Task = spantitleTask;

    absol.Dom.addToResizeSystem(spantitleTask);

    var top = DOMElement.div({
        attrs: {
            className: "container-top",
            style: {
                width: "100%",
                border: "1px solid #d6d6d6",
            }
        },
        children: [
            spanlabelPosition,
            spantitlePosition,
            spanlabelTask,
            spantitleTask
        ]
    });
    top = DOMElement.div({
        attrs: {
            style: {
                display: "table",
                width: "100%",
            }
        },
        children: [top]
    });
    var margin = DOMElement.div({
        attrs: {
            className: "margin",
            style: {
            }
        }
    });

    var textId = ("text_" + Math.random() + Math.random()).replace(/\./g, '');

    if(host.bot===undefined){
        host.bot = DOMElement.div({
            attrs: {
                className: "container-bot-in-body",
                style:{
                    height:"100%"
                }
            },
            children: [
                DOMElement.div({
                    attrs: {
                        className: "container-bot",
                        id: textId,
                        style: {
                            border: "1px solid #d6d6d6",
                        }
                    },
                    children: [
                    ]
                })
            ]
        });
    }
    else
    {
        DOMElement.removeAllChildren(host.bot);
        host.bot.appendChild(DOMElement.div({
            attrs: {
                className: "container-bot",
                id: textId,
                style: {
                    border: "1px solid #d6d6d6",
                }
            },
            children: [
            ]
        }))
    }

    var promise = new Promise(function (resolve, reject) {
        var ckedit = absol.buildDom({
            tag: 'attachhook',
            on: {
                error: function () {
                    this.selfRemove();
                    editor = CKEDITOR.replace(textId);
                    editor.setData(content);
                    var waitLoad = setInterval(function () {
                        if (editor.loaded) {
                            clearInterval(waitLoad);
                            var container = document.getElementById("cke_"+textId);
                            container.getElementsByClassName("cke_inner")[0].style.height="100%";
                            container.getElementsByClassName("cke_contents")[0].style.height="calc(100% - 73px)";
                            editor.updateSizeContent = function(height)
                            {
                                container.style.height="calc(100% - "+(height+10)+"px)";
                            }
                            editor.updateSizeContent(top.clientHeight);
                            window.onresize = function()
                            {
                                editor.updateSizeContent(top.clientHeight);
                            }
                        }
                    }, 100);
                    setTimeout(function () {
                        clearInterval(waitLoad);
                    }, 10000)
                    editor.on('focus', function (e) {
                        host.editorFocus = editor;
                        absol.$(document.body).emit('click')
                    });
                    done = true;
                    host.listEditor.push(editor);
                    resolve();
                }
            }
        });
        
        host.bot.appendChild(ckedit);
    });

    temp = DOMElement.div({
        attrs: {
            className: "index-top-bot",
            style: {}
        },
        children: [
            top,
            margin,
            host.bot,
        ]
    })
    absol.$(temp);
    host.containerList.appendChild(
        temp)

}

jobdescui.updateprocessTabbar = function (el, host) {

    for (var i = 0; i < el.children.length; i++) {
        var temp = el.children[i].children[0].innerHTML;
        var split = temp.slice(temp.indexOf(" "));
        temp = i + 1 + "." + split;
        el.children[i].children[0].innerHTML = temp;
        el.children[i].id = i + 1;
        if (el.children[i].classList.contains("choice")) {
            host.state = i + 1;
        }
    }

}

jobdescui.insetCategories = function (host, container, i, list) {
    container.insertBefore(
        jobdescui.spanClass(host, i, list),
        container.childNodes[i]
    )
}

jobdescui.formAdd = function (host, param, STT, updateSTT = false) {
    if (STT !== undefined && STT.id !== undefined)
        STT = Number(STT.id);
    if (param == -1)
        param = undefined;
    if (param !== undefined)
        var check = jobdescui.spanAutocompleteBox(LanguageModule.text("title_fill"), data_module.categoriesList.items, host.data[param.id].title);
    else
        var check = jobdescui.spanAutocompleteBox(LanguageModule.text("title_fill"), data_module.categoriesList.items, "");
        
    var temp = absol.buildDom({
        tag:'singlepage',
        child:[
            {
                class: 'absol-single-page-header',
                child:[
                    {
                        tag: "iconbutton",
                        on: {
                            click: function (evt) {
                                temp.selfRemove();
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        class:"info",
                        style: {
                        },
                        on: {
                            click: function (evt) {
                                if (param !== undefined) {
                                    host.data[param.id].title = check.childNodes[1].value;
                                    host.information.childNodes[param.id - 1].childNodes[0].innerHTML = param.id + ".  " + check.childNodes[1].value;
                                } else {
                                    if (STT !== undefined) {
                                        console.log(STT)
                                        jobdescui.insetCategories(host, host.information, STT, { name: check.childNodes[1].value })
                                        host.data.splice(STT + 1, 0, { title: check.childNodes[1].value });

                                    } else {
                                        jobdescui.insetCategories(host, host.information, host.information.children.length + 1, { name: check.childNodes[1].value })
                                        host.data.push({ title: check.childNodes[1].value });
                                    }
                                    if (updateSTT === true) {
                                        jobdescui.updateprocessTabbar(host.information, host);
                                    }
                                }
                            }
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_save") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        style: {
                        },
                        on: {
                            click: function (evt) {
                                if (param !== undefined) {
                                    host.data[param.id].title = check.childNodes[1].value;
                                    host.information.childNodes[param.id - 1].childNodes[0].innerHTML = param.id + ".  " + check.childNodes[1].value;
                                } else {
                                    if (STT !== undefined) {
                                        console.log(STT)
                                        jobdescui.insetCategories(host, host.information, STT, { name: check.childNodes[1].value })
                                        host.data.splice(STT + 1, 0, { title: check.childNodes[1].value });

                                    } else {
                                        jobdescui.insetCategories(host, host.information, host.information.children.length + 1, { name: check.childNodes[1].value })
                                        host.data.push({ title: check.childNodes[1].value });
                                    }
                                    if (updateSTT === true) {
                                        jobdescui.updateprocessTabbar(host.information, host);
                                    }
                                }
                                temp.selfRemove();
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_save_close") + '</span>'
                        ]
                    }
                ]
            },
            {
                class: 'absol-single-page-footer'
            }
        ]})
     temp.addChild(DOMElement.div({
                attrs:{
                    style:{
                        display:"table",
                        marginTop: "10px"
                    },
                    className:"autocomplete-div",
                },
                children:[
                    check
                ]
            }))
    jobdesc.menu.footer(absol.$('.absol-single-page-footer', temp));
    return temp;
}

jobdescui.formAddUser = function (host, param) {
    if (param == -1)
        param = undefined;
    var list=[];
    var isDone;
    host.idAccountHome=-1;
    console.log(param)
    
    if (param !== undefined){
        host.fullname  = jobdescui.spanInput(LanguageModule.text("title_full_name"),data_module.usersListHome.getID(param.homeid).fullname);
        host.email = jobdescui.spanInput(LanguageModule.text("title_email"),data_module.usersListHome.getID(param.homeid).email);
        if(data_module.usersList.getID(param.id).privilege!==0){
            var tempValue=1;
            if(data_module.usersList.getID(param.id).privilege!==1)
            var tempValue2=1;
            else
            var tempValue2=0;
        }else
        {
            var tempValue=0;
            var tempValue2=0;
        }
        host.AdminTrans = jobdescui.spanSelect(LanguageModule.text("title_system_rights"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}],tempValue);
        host.AdminAccount = jobdescui.spanSelect(LanguageModule.text("title_decentralization"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}],tempValue2);
        host.available = jobdescui.spanSelect(LanguageModule.text("title_work"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}],data_module.usersList.getID(param.id).available);
        host.language = jobdescui.spanSelect(LanguageModule.text("title_country"), data_module.countriesList.items.map(function (u, i) {
            return { text: u.country_name, value: u.id }
        }), data_module.usersList.getID(param.id).language);
        host.theme = jobdescui.spanInput(LanguageModule.text("title_theme"),data_module.usersList.getID(param.id).theme+"");
        host.comment = jobdescui.spanInput(LanguageModule.text("title_note"),data_module.usersList.getID(param.id).comment,false);
        host.check = jobdescui.spanAutocompleteBoxInsertDetail(host,LanguageModule.text("title_account"), [], data_module.usersListHome.getID(param.homeid).username);
        host.check.childNodes[1].childNodes[0].setAttribute("disabled","");
        host.Password=jobdescui.spanInput(LanguageModule.text("title_new_password"));
        host.checkPassword=jobdescui.spanInput(LanguageModule.text("title_reenter_password"));
        host.Password.style.display="none";
        host.checkPassword.style.display="none";
        host.spanChangePassword= DOMElement.div({
            attrs:{
                className:"container-form",
                style:{
                }
            },
            children:[
                DOMElement.div({
                    attrs:{
                        className:"infotext",
                        style:{
                            height:0
                        }
                    }
                })
            ]
                
        })
        var atemp= DOMElement.a({
            attrs: {
                className: "",
                style:{
                    color: "#23527c",
                    cursor: "pointer",
                },
                onclick:function(host){
                    return function(event,me){
                    host.spanChangePassword.style.display="none";
                    host.Password.style.display="";
                    host.checkPassword.style.display="";
                    }
                }(host)
            },
            text:LanguageModule.text("title_change_password"),
        })
        host.spanChangePassword.appendChild(atemp);
        
    }
    else{   
        for(var i=0;i<data_module.usersListHome.items.length;i++)
        {
            isDone=false;
            for(var j=0;j<data_module.usersList.items.length;j++)
            if(data_module.usersList.items[j].homeid===data_module.usersListHome.items[i].id)
            {
                isDone=true;
                break;
            }
            if(isDone===false)
            list.push({ name: data_module.usersListHome.items[i].username, id: data_module.usersListHome.items[i].id });
        }
        host.fullname  = jobdescui.spanInput(LanguageModule.text("title_full_name"));
        host.email = jobdescui.spanInput(LanguageModule.text("title_email"));
        host.AdminTrans = jobdescui.spanSelect(LanguageModule.text("title_system_rights"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}]);
        host.AdminAccount = jobdescui.spanSelect(LanguageModule.text("title_decentralization"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}]);
        host.available = jobdescui.spanSelect(LanguageModule.text("title_work"),[{text:LanguageModule.text("txt_yes"),value:1},{text:LanguageModule.text("txt_no"),value:0}]);
        host.language = jobdescui.spanSelect(LanguageModule.text("title_country"), data_module.countriesList.items.map(function (u, i) {
            return { text: u.country_name, value: u.id }
        }));
        host.theme = jobdescui.spanInput(LanguageModule.text("title_theme"));
        host.comment = jobdescui.spanInput(LanguageModule.text("title_note"),"",false);
        host.check = jobdescui.spanAutocompleteBoxInsertDetail(host,LanguageModule.text("title_account"), list, "");
        host.Password=jobdescui.spanInput(LanguageModule.text("title_new_password"));
        host.checkPassword=jobdescui.spanInput(LanguageModule.text("title_reenter_password"));
        host.spanChangePassword= DOMElement.div({
            attrs:{
                className:"container-form",
                style:{
                    display:"none"
                }
            },
            children:[
                DOMElement.div({
                    attrs:{
                        className:"infotext",
                        style:{
                            height:0
                        }
                    }
                })
            ]
                
        })
        var atemp= DOMElement.a({
            attrs: {
                className: "",
                style:{
                    color: "#23527c",
                    cursor: "pointer",
                },
                onclick:function(host){
                    return function(event,me){
                    host.spanChangePassword.style.display="none";
                    host.Password.style.display="";
                    host.checkPassword.style.display="";
                    }
                }(host)
            },
            text:LanguageModule.text("title_change_password"),
        })
        host.spanChangePassword.appendChild(atemp);
       
    }
    host.Password.childNodes[1].setAttribute("type","password");
    host.checkPassword.childNodes[1].setAttribute("type","password");
    host.Password.childNodes[1].setAttribute("autocomplete","new-password");
    host.checkPassword.childNodes[1].setAttribute("autocomplete","new-password");
    host.check.childNodes[1].childNodes[0].setAttribute("autocomplete","new-password")

    host.AdminTrans.childNodes[1].defineEvent("change");
    host.AdminTrans.childNodes[1].on('change',function(){
        if(host.AdminTrans.childNodes[1].value===0)
        {
            host.AdminAccount.childNodes[1].value=0;
        }
    })
    host.AdminAccount.childNodes[1].defineEvent("change")
    host.AdminAccount.childNodes[1].on('change',function(){
        if(host.AdminAccount.childNodes[1].value===1)
        {
            host.AdminTrans.childNodes[1].value=1;
        }
    })

    var temp = absol.buildDom({
        tag:'singlepage',
        child:[
            {
                class: 'absol-single-page-header',
                child:[
                    {
                        tag: "iconbutton",
                        class:"info",
                        style: {
                        },
                        on: {
                            click: function (evt) {
                                if(host.frameList.getAllChild()===1)
                                    jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                else
                                {
                                    temp.selfRemove();
                                    var arr=host.frameList.getAllChild();
                                    host.frameList.activeFrame(arr[arr.length-1]);
                                }
                            }
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'clear'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            marginLeft: "10px"
                        },
                        on: {
                            click: function (evt) {
                                blackTheme.reporter_users.UpdataFunction(host,param);
                            }
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_save") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        style: {
                            marginLeft: "10px"
                        },
                        on: {
                            click: function (evt) {
                                    blackTheme.reporter_users.UpdataFunction(host,param);
                                    if(host.frameList.getAllChild()===1)
                                    jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                    else
                                    {
                                        temp.selfRemove();
                                        var arr=host.frameList.getAllChild();
                                        host.frameList.activeFrame(arr[arr.length-1]);
                                    }
                            }
                            
                        },
                        child: [{
                            tag: 'i',
                            class: 'material-icons',
                            props: {
                                innerHTML: 'save'
                            },
                        },
                        '<span>' + LanguageModule.text("ctrl_save_close") + '</span>'
                        ]
                    }
                ]
            },
            {
                class: 'absol-single-page-footer'
            }
        ]})

        temp.addChild(DOMElement.div({
                attrs: {
                    style: {
                        marginLeft:"10px",
                    }
                },
                children:[
                    host.check,
                    host.spanChangePassword,
                    host.Password,
                    host.checkPassword,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.fullname,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.email,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.AdminTrans,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.AdminAccount,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.available,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.language,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.theme,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    host.comment
                ]
            }))
    jobdesc.menu.footer(absol.$('.absol-single-page-footer', temp));
    return temp;
}



jobdescui.spanClass = function (host, param, param1, className = "Info2") {
    var result = DOMElement.div({
        attrs: {
            className: className,
        }
    })
    result.id = param;
    var list1 = [
        {
            
            symbol: DOMElement.i({
                attrs: {
                    className: "material-icons",
                    style: {
                        fontSize: "20px"
                    }
                },
                text: "add"
            }),
            content : DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("ctrl_add")
            }),
            onclick: function () {
                var temp = host.state;
                jobdescui.setTask(host, result);
                console.log(temp, result)
                jobdescui.createIndex(host)
            },
        },
        {
            symbol: DOMElement.i({
                attrs: {
                    className: "material-icons",
                    style: {
                        fontSize: "20px"
                    }
                },
                text: "create"
            }),
            content : DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("ctrl_edit")
            }),
            onclick: function (evt) {
                host.frameList.add(jobdescui.formAdd(host, result));
                host.frameList.selectedIndex = host.frameList.count - 1;
                jobdesc.menu.hiddenCkeditor(host);
            }
        },
        {
            symbol: DOMElement.i({
                attrs: {
                    className: "material-icons",
                    style: {
                        fontSize: "20px"
                    }
                },
                text: "delete"
            }),
            content : DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("ctrl_delete")
            }),
            onclick: function (evt) {
                //jobdescui.deleteItemProcessList(evt,host)
                // ModalElement.showWindow({
                //     index: 2,
                //     title: LanguageModule.text("title_save_confirm"),
                //     bodycontent: jobdescui.formDelete(evt, host, param1.name)
                // })
                ModalElement.question({
                    title: LanguageModule.text("txt_delete_category"),
                    message: LanguageModule.text("title_confirm_delete") + "" + param1.name,
                    onclick: function (evt, host) {
                        return function (selectedindex) {
                            console.log(selectedindex)
                            switch (selectedindex) {
                                case 0:
                                    jobdescui.deleteItemProcessList(evt, host)
                                    break;
                                case 1:
                                    // do nothing
                                    break;
                            }
                        }
                    }(evt, host)
                });
            }
        },
        {
            symbol: DOMElement.i({
                attrs: {
                    className: "material-icons",
                    style: {
                        fontSize: "20px"
                    }
                },
                text: "arrow_upward"
            }),
            content : DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("ctrl_up")
            }),
            onclick: function (evt) {
                var element = evt.target;
                while (!element.classList.contains('Info2'))
                    element = element.parentNode;

                var temp = host.data[element.id];
                host.data[element.id] = host.data[element.previousElementSibling.id];
                host.data[element.previousElementSibling.id] = temp;

                var parent = element.parentNode;
                if (element.previousElementSibling)
                    element.parentNode.insertBefore(element, element.previousElementSibling);
                jobdescui.updateprocessTabbar(parent, host);
            }
        },
        {
            symbol: DOMElement.i({
                attrs: {
                    className: "material-icons",
                    style: {
                        fontSize: "20px"
                    }
                },
                text: "arrow_downward"
            }),
            content : DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("ctrl_down")
            }),
            onclick: function (evt) {
                var element = evt.target;
                while (!element.classList.contains('Info2'))
                    element = element.parentNode;

                var temp = host.data[element.id];
                host.data[element.id] = host.data[element.nextElementSibling.id];
                host.data[element.nextElementSibling.id] = temp;

                var parent = element.parentNode;
                if (element.nextElementSibling)
                    element.parentNode.insertBefore(element.nextElementSibling, element);

                jobdescui.updateprocessTabbar(parent, host);
            }
        },
    ];

    var h1 = DOMElement.choicelist({
        align: "right",
        color2: "#d6d6d6",
        textcolor: "#7a7a7a",
        textcolor2: "black",
        attrs: {
            style: {
                display: "table-cell !important",
                top: "15px",
                right: "12px"
            }
        },
        list: list1
    })

    result.appendChild(
        DOMElement.span({
            attrs: {
                className: "indextext",
                innerHTML: result.id + ".  " + param1.name,
                onclick: function () {
                    var temp = host.state;
                    jobdescui.setTask(host, result);
                    console.log(temp, result)
                    if (result.id !== 0 && (host.data[result.id] === undefined || host.data[result.id].data === undefined || host.data[result.id].data.length === 0) && temp !== result.id)
                        jobdescui.createIndex(host)
                },
            }
        }))
    result.appendChild(
        DOMElement.i({
            attrs: {
                className: "material-icons " + DOMElement.dropdownclass.button,
                style: {
                },
                onclick: function (host) {
                    return function (event, me) {
                        host.style.top = "80px";
                        host.toggle();
                        console.log(jobdescui.elementInViewport(host.childNodes[0]));
                        if(!jobdescui.elementInViewport(host.childNodes[0]))
                        {
                            host.style.top = -host.childNodes[0].clientHeight +"px";
                        }
                        else{
                            host.style.top = 0 +"px";
                        }
                        console.log(host.childNodes[0].clientHeight)
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(h1)
                //     console.log(
                //      ModalElement.showWindow({
                //         index: 1,
                //         title: "Thêm chỉ mục",
                //         bodycontent:jobdescui.formAdd()
                //     })
                //     )
                // }
            },
            text: "more_vert",
        })
    )
    result.appendChild(
        h1);
    return result;
};

jobdescui.listProcess = function (host, list) {
    var result = [];

    for (var i = 0; i < list.length; i++) {
        result.push(
            jobdescui.spanClass(host, i + 1, list[i][0], list[i][1])
        )
    }
    return result;
};


jobdescui.InfoBar = function (host) {
    var param = "",
        param2 = "";
        
    if (host.data[0].position != undefined){
        param = data_module.departmentsList.getID(data_module.positionsList.getID(host.data[0].position).departmentid).name;
        param2 = data_module.positionsList.getID(host.data[0].position).name;
    }   
    return DOMElement.div({
        attrs: {
            style: {
                display: "flex"
            }
        },
        children: [
            DOMElement.span({
                attrs: {
                    className: "InfoBar",
                    innerHTML: param+" - "+param2
                }
            })
        ]
    })
};

jobdescui.deleteAtIndex = function (s, i, n) {
    return s.substr(0, i) + s.substr(i + n);
};

jobdescui.deleteWord = function (s, word) {
    while (s.indexOf(word) !== -1) {
        s = jobdescui.deleteAtIndex(s, s.indexOf(word), word.length);
    }
    return s
};

jobdescui.deleteWordLast = function (s, word) {
    if(s.lastIndexOf(word) !== -1) {
        s = jobdescui.deleteAtIndex(s, s.indexOf(word), word.length);
    }
    return s
};

jobdescui.decodeHTML = function (html) {
    var txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value.replace(/^\s+|\s+$/g, '').replace(/\u00a0/g, " ");
};

jobdescui.encodeHTML = function (html) {
    return document.createElement('div').appendChild(document.createTextNode(html)).parentNode.innerHTML;
};

jobdescui.addOneArray = (array, el, pos) => {
    var temp = el;
    var temp1;
    console.log(pos)
    for (var i = pos; i < array.length + 1; i++) {
        console.log(pos)
        temp1 = temp;
        temp = array[i];
        array[i] = temp1;
        if (temp === undefined) {
            console.log(array)
            return array;
        }
    }
};

jobdescui.deleteItemProcessList = function (event, host) {
    //console.log(new Error());
    var el = event.target; //absol.HTMLElement.prototype.containsClass
    while (!el.classList.contains('Info2'))
        el = el.parentNode;
    var parent = el.parentNode;
    var temp = el.childNodes[0].innerHTML;
    temp = temp.slice(temp.indexOf(" ") + 2);
    var param = {};
    param.stt = jobdescui.getSTT(parent, el)
    param.name = temp;
    console.log(host.state == param.stt + 1)
    if (host.state == param.stt + 1) {
        jobdesc.responsibility.removeandSaveData(host, 0);
        jobdesc.responsibility.BuildInfoInit(host);
        host.General.classList.add("choice");
        host.me = host.General;
    }

    host.stack.push(["remove", param, host.data[param.stt + 1]]);
    host.data.splice(param.stt + 1, 1);


    // delete host.data[host.checkIdProcess(temp)];
    el.parentNode.removeChild(el);
    jobdescui.updateprocessTabbar(parent, host);
};

jobdescui.getIndexByID = function(id,arr)
{
    for(var i=0;i<arr.length;i++)
    {
        if(arr[i].id===id)
        return i;
    }
    return -1;
}

jobdescui.waitForAccessToken = function (timeout) {
    return new Promise(function (rs, rj) {
        var it = setInterval(function () {
            var ac = absol.cookie.get('accesstokenJD');
            if (ac) {
                rs(JSON.parse(ac));
                clearTimeout(sto);
                clearInterval(it);
            }

        }, 1000);

        var sto = setTimeout(function () {
            clearInterval(it);
            rj();
        }, timeout || 15 * 60000);

    });
};

jobdescui.deleteAllCookies = function () {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
};

jobdescui.getSTT = function (parent, el) {

    for (var i = 0; i < parent.children.length; i++) {
        if (el == parent.childNodes[i])
            return i;
    }
    return -1;
};

jobdescui.elementInViewport = function(el) {
    var rect     = el.getBoundingClientRect(),
    vWidth   = window.innerWidth || doc.documentElement.clientWidth,
    vHeight  = window.innerHeight || doc.documentElement.clientHeight,
    efp      = function (x, y) { return document.elementFromPoint(x, y) };     

    // Return false if it's not in the viewport
    if (rect.right < 0 || rect.bottom < 0 
            || rect.left > vWidth || rect.top > vHeight)
        return false;

    // Return true if any of its four corners are visible
    return (
        el.contains(efp(rect.left,  rect.top))
    ||  el.contains(efp(rect.right, rect.top))
    ||  el.contains(efp(rect.right, rect.bottom))
    ||  el.contains(efp(rect.left,  rect.bottom))
    );
};