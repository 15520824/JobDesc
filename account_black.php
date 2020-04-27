<?php
    function write_account_script_black() {
        global $prefix;

?>
<script type="text/javascript">
     blackTheme.account.init = function(host){
        host.holder.functionCheck = undefined;
        host.holder.functionSave = undefined;
        var tdiv;
        host.systempriv = <?php if (isset($_SESSION[$prefix."privilege"])) echo $_SESSION[$prefix."privilege"]; else echo "0";?>;
        host.frameList = DOMElement.frameList({});
        DOMElement.removeAllChildren(host.holder);
        // if (data_module.usersDataList.items[data_module.usersDataList.getByhomeid(systemconfig.userid)].username == "yentest"){
        //     host.direct = 1; //tam thoi de test
        // }
        if (host.direct == 0){
            host.password_confirm = DOMElement.input({
                attrs: {
                    type: "password",
                    className: "KPIsimpleInput",
                    style: {
                        width: "200px"
                    },
                    onkeydown: function(event){
                        if (event.keyCode == 13) blackTheme.account.confirmPassword(host);
                    }
                }
            });
            host.notification = DOMElement.td({});
            host.inputsearchbox = absol.buildDom({
                tag:'searchcrosstextinput',
                style: {
                    width: blackTheme.menu.searchboxwidth
                },
                props:{
                    placeholder: LanguageModule.text("txt_search"),
                    value:''
                }
            });

            ModalElement.showWindow({
                index: 1,
                title: "Xác nhận mật khẩu",
                bodycontent: DOMElement.table({
                    data: [
                        [
                            {},{},host.notification
                        ],
                        [
                            {
                                attrs: {style: {whiteSpace: "nowrap"}},
                                text: LanguageModule.text("txt_password")
                            },
                            {attrs: {style: {width: "10px"}}},
                            host.password_confirm
                        ],
                        [{attrs: {style: {height: "20px"}}}],
                        [{
                            attrs :{
                                colSpan: 3,
                                align: "center",
                                style: {
                                    border: "0"
                                }
                            },
                            children: [DOMElement.table({
                                attrs: {
                                    style: {
                                        border: "0"
                                    }
                                },
                                data: [[
                                    {
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [blackTheme.button071218.showButton({
                                            sym: DOMElement.i({
                                                    attrs: {
                                                        className: "material-icons "
                                                   },
                                                   text: "done"
                                               }),
                                            typebutton: 0,
                                            onclick: function(host){
                                                return function(event, me){
                                                    blackTheme.account.confirmPassword(host);
                                                }
                                            }(host),
                                            text: LanguageModule.text("txt_ok")
                                        })]
                                    },
                                    {
                                        attrs: {style: {width: "20px"}}
                                    },
                                    {
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [blackTheme.button071218.showButton({
                                            sym: DOMElement.i({
                                                    attrs: {
                                                        className: "material-icons "
                                                   },
                                                   text: "clear"
                                               }),
                                            typebutton: 0,
                                            onclick: function(event,me) {
                                                ModalElement.close();
                                                jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                            },
                                            text: LanguageModule.text("txt_close")
                                        })]
                                    }
                                ]]
                            })]
                        }]
                    ]
                })
            });
            host.password_confirm.focus();
            return;
        }
        host.holder.appendChild(host.frameList);
        tdiv = DOMElement.div({
            attrs: {
                style: {
                    width: "100%",
                    height: "100%"
                }
            }
        });
        var i;
        // host.criteriaindexlist = [];
        // host.orgsList = [];
        // for (i = 0; i < data_module.criteriadefinitionsList.items.length; i++) host.criteriaindexlist.push(i);
        // sort(host.criteriaindexlist, data_module.criteriadefinitionsList.indexCmpFunc);
        // for (i = 0; i < data_module.orgsList.items.length; i++) {
        //     if ((data_module.orgsList.items[i].profileid == systemconfig.selectedpf) && (data_module.orgsList.items[i].parentid == 0)) host.orgsList.push(i);
        // }
        // sort(host.orgsList, data_module.orgsList.indexCmpFunc);
        host.account_black_div = DOMElement.div({

        });
        tdiv.appendChild(host.account_black_div);
        setTimeout(function(host){
            return function(event,me){
                console.log(host)
                blackTheme.account.redraw(host);
            }
        }(host),10);
        host.frameList.add(tdiv);
        blackTheme.menu.footer(host.holder);
    };

    
    blackTheme.account.redraw = function (host) {
        var x;
        var st; //thanhyen
        DOMElement.removeAllChildren(host.pagetitle);
        host.pagetitle.appendChild(DOMElement.textNode(LanguageModule.text("txt_account")));
        host.holder.tilteText = LanguageModule.text("txt_account");
        x = DOMElement.table({
            attrs: {style: {width: "100%"}},
            header: [{
                attrs: {style: {width: "40px"}},
                text: LanguageModule.text("txt_number")
            },
            {
                attrs: {style: {width: "100px"}},
                text: LanguageModule.text("txt_account")
            },
            {
                attrs: {style: {width: "200px"}},
                text: LanguageModule.text("txt_fullname")
            },
            {
                text: LanguageModule.text("txt_email")
            },
            {
                attrs: {style: {width: "180px"}},
                text: LanguageModule.text("txt_last_access")
            },
            {
                text: LanguageModule.text("txt_profile")
            },
            {
                attrs: {style: {width: "100px"}},
                text: LanguageModule.text("txt_admin")
            },
            {
                attrs: {style: {width: "100px"}},
                text: LanguageModule.text("txt_active")
            },
            {
                attrs: {style: {width: "100px"}},
                text: LanguageModule.text("txt_language")
            },
            {
                text: LanguageModule.text("txt_node")
            },
            {attrs: {style: {width: "40px"}}}],
            data: blackTheme.account.generateTableData(host)
        });
        var uploadwindow = DOMElement.input({
            attrs: {
                type: "file",
                style: {display: "none"}
            }
        });
        host.holder.redrawFunction = function(host){
            return function (event, me) {
                blackTheme.account.redraw(host);
            }
        } (host);
        var buttonPanel = DOMElement.div({
            attrs: {
                style: {
                    position: "fixed",
                    overflow: "hidden",
                    width: "calc(100vw - 40px)",
                    verticalAlign: "bottom",
                    backgroundColor: "white",
                    zIndex: 88
                }
            },
            children: [DOMElement.table({
                data: [[
                        {
                            children: [blackTheme.button071218.showButton({
                                sym: DOMElement.i({
                                        attrs: {
                                            className: "material-icons "
                                       },
                                       text: "clear"
                                   }),
                                typebutton: 0,
                                onclick: function(host){
                                    return function (event, me) {
                                        jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                    }
                                } (host),
                                text: LanguageModule.text("txt_close")
                            })]
                        },
                        {
                            attrs: {
                                style: {
                                    paddingLeft: "10px",
                                    display: (host.systempriv >= 2)? "" : "none"
                                }
                            },
                            children: [blackTheme.button071218.showButton({
                                sym: DOMElement.i({
                                        attrs: {
                                            className: "material-icons "
                                       },
                                       text: "add"
                                   }),
                                typebutton: 1,
                                text: LanguageModule.text("txt_add"),
                                onclick: function(host){
                                    return function (event, me) {
                                          blackTheme.account.newAccountDialog(host,0);
                                    }
                                } (host)
                            })]
                        },
                        {
                            attrs: {
                                style: {
                                    paddingLeft: "10px",
                                    display: (host.systempriv >= 2)? "" : "none"
                                }
                            },
                            children: [blackTheme.button071218.showButton({
                                sym: DOMElement.span({
                                    attrs:{
                                        className: "glyphicon glyphicon-export"
                                    }
                                }),
                                typebutton: 0,
                                text: LanguageModule.text("txt_export"),
                                onclick: function(host){
                                    return function (event, me) {
                                        if (host.systempriv >= 2) blackTheme.account.export(host);
                                    }
                                } (host)
                            })]
                        },
                        {
                            attrs: {
                                style: {
                                    paddingLeft: "10px",
                                    display: (host.systempriv >= 2)? "" : "none"
                                }
                            },
                            children: [blackTheme.button071218.showButton({
                                sym: DOMElement.span({
                                    attrs:{
                                        className: "glyphicon glyphicon-import"
                                    }
                                }),
                                typebutton: 0,
                                text: LanguageModule.text("txt_import"),
                                onclick: function(host){
                                    return function (event, me) {
                                        if (host.systempriv >= 2) uploadwindow.click();
                                    }
                                } (host)
                            })]
                        },
                        {
                          attrs: {
                            style: {
                              paddingLeft: "10px",
                              display: (host.systempriv >= 2)? "" : "none"
                            }
                          },
                          children: [blackTheme.button071218.showButton({
                              sym: DOMElement.i({
                                    attrs: {
                                        className: "mdi mdi-delete-variant"
                                   }
                               }),
                              typebutton: 0,
                              text: LanguageModule.text("txt_delete_all_user"),
                              onclick: function(){
                                  blackTheme.account.deleteAllUser(host);
                              }
                          })]
                        },
                        {
                            attrs: {style: {paddingLeft: "10px"}},
                            children: [blackTheme.button071218.showButton({
                                sym: DOMElement.i({
                                     attrs: {
                                         className: "material-icons " +  DOMElement.dropdownclass.button
                                    },
                                    text: "refresh"
                                }),
                                typebutton: 0,
                                text: LanguageModule.text("txt_refresh"),
                                onclick: function(){
                                    contentModule.refreshCheck();
                                }
                            })]
                        },
                        {
                            attrs: {style: {height: "50px"}}
                        }
                    ]]
            })]
        });
        st = DOMElement.table({
            attrs: {style: {width: "100%"}},
            data: [
                [{children: [buttonPanel]}],
                [{attrs:{style:{height:"40px"}}}],
                [{
                    attrs: {
                             colSpan: "3",
                             style: {
                                 height: "20px"
                             }
                         },
                     children: [
                         DOMElement.hr({
                             attrs: {
                                 style: {
                                     marginTop: "0.5em",
                                     marginBottom: "0.5em",
                                     borderColor: "#d6d6d6",
                                     width: "calc(100vw - 50px)"
                                 }
                             }
                         })
                     ]
                }],
                [
                    {
                    attrs: {
                        align: "right"
                    },
                    children: [host.inputsearchbox]
                    }
                ],
                [{attrs: {
                    style: {
                        height: "10px",
                        fontSize: "4px"
                    }
                }}],
                [
                    DOMElement.div({
                        attrs: {
                            className: "KPIsimpletableclass row2colors KPItablehover",
                            style: { width: "100%"}
                        },
                        children: [x]
                    })
                ],
                [{attrs:{style:{height:"150px"}}}]
            ]
        });
        x.addSearchBox(host.inputsearchbox);
        DOMElement.removeAllChildren(host.account_black_div);
        host.account_black_div.appendChild(st);
        host.inputsearchbox.onchange();
        uploadwindow.onchange = function (){
            blackTheme.account.import(host,this);
        };
    };

    blackTheme.account.generateTableData = function(host){
        var data = [];
        var celldata = [];
        var indexlist = [];
        var i, k, sym, con;
        for (i = 0; i < data_module.usersDataList.items.length; i++) {
            indexlist.push(i);
        }
        sort(indexlist, function (a, b) {
            var k;
            if (data_module.usersDataList.items[a].privilege < data_module.usersDataList.items[b].privilege) return 1;
            if (data_module.usersDataList.items[a].privilege > data_module.usersDataList.items[b].privilege) return -1;
            k = stricmp(data_module.usersDataList.items[a].username, data_module.usersDataList.items[b].username);
            return k;
        });
        for (k = 0; k < data_module.usersDataList.items.length; k++) {
            i = indexlist[k];
            celldata = [k+1];
            celldata.push({
                text: data_module.usersDataList.items[i].username
            });
            celldata.push({
                text: data_module.usersDataList.items[i].fullname
            });
            celldata.push({
                text: data_module.usersDataList.items[i].email
            });
            celldata.push({
                text: contentModule.getTimeSend(data_module.usersDataList.items[i].privupdate)
            });
            if (data_module.usersDataList.items[i].profileIndex >= 0) {
                celldata.push({
                    text: data_module.profilesList.items[data_module.usersDataList.items[i].profileIndex].name
                });
            }
            else {
                celldata.push({
                    text: "-"
                });
            }
            if(data_module.usersDataList.items[i].privilege >= 2){
                celldata.push({
                    text: LanguageModule.text("txt_yes")
                });
            }
            else{
                celldata.push({
                    text: LanguageModule.text("txt_no")
                });
            }
            if(data_module.usersDataList.items[i].available == 1){
                celldata.push({
                    text: LanguageModule.text("txt_yes")
                });
            }
            else{
                celldata.push({
                    text: LanguageModule.text("txt_no")
                });
            }
            var languagevalue = "";
            for (var li = 0; li < LanguageModule.code.length; li++){
                if (data_module.usersDataList.items[i].language == LanguageModule.code[li].name){
                    languagevalue = LanguageModule.code[li].value;
                    break;
                }
            }
            celldata.push({
                text: languagevalue
            });
            if (data_module.usersDataList.items[i].comment == ""){
                celldata.push({
                    text: ""
                });
            }
            else {
              celldata.push({
                  valign: "middle;",
                  innerHTML: DOMClass.tooltipString({
                      color: "white",
                      hpos: -1,
                      width: 250,
                      height: 50,
                      backgroundcolor: "grey",
                      innerHTML: "<div style=\"overflow: hidden; width: 150px; height: 26px; white-space: nowrap;\">" + EncodingClass.textshow(data_module.usersDataList.items[i].comment) + "</div>",
                      tooltiptext: data_module.usersDataList.items[i].comment
                  })
              });
            }
            list = [];
            if (host.systempriv >=2){
                sym = DOMElement.i({
                    attrs: {
                        className:"material-icons",
                        style: {fontSize: "20px", color: "#929292"}
                    },

                    text: "mode_edit"
                });
                con = DOMElement.div({
                    attrs: {
                        style: {
                            width: "100px"
                        }
                    },
                    text: LanguageModule.text("txt_edit")
                });
                sym.onmouseover = con.onmouseover = function (sym, con) {
                    return function(event, me) {
                        sym.style.color = "black";
                        con.style.color = "black";
                    }
                } (sym, con);
                sym.onmouseout = con.onmouseout = function (sym, con) {
                    return function(event, me) {
                        sym.style.color = "#929292";
                        con.style.color = "#929292";
                    }
                } (sym, con);
                list.push({
                    attrs: {style: {width: "170px"}},
                    symbol: sym,
                    content: con,
                    onclick: function(id){
                        return function(event, me) {
                            //host.searchboxvalue = host.searchbox.value;
                            blackTheme.account.newAccountDialog(host,id);
                            DOMElement.cancelEvent(event);
                            return false;
                        }
                    } (data_module.usersDataList.items[i].id)
                });
                sym = DOMElement.i({
                    attrs: {
                        className:"material-icons",
                        style: {fontSize: "20px", color: "#929292"}
                    },
                    text: "delete_sweep"
                });
                con = DOMElement.div({
                    attrs: {
                        style: {
                            width: "100px"
                        }
                    },
                    text: LanguageModule.text("txt_delete")
                });
                sym.onmouseover = con.onmouseover = function (sym, con) {
                    return function(event, me) {
                        sym.style.color = "red";
                        con.style.color = "black";
                    }
                } (sym, con);
                sym.onmouseout = con.onmouseout = function (sym, con) {
                    return function(event, me) {
                        sym.style.color = "#929292";
                        con.style.color = "#929292";
                    }
                } (sym, con);
                list.push({
                    attrs: {style: {width: "170px"}},
                    symbol: sym,
                    content: con,
                    onclick: function(id){
                        return function(event, me) {
                            //host.searchboxvalue = host.searchbox.value;
                            blackTheme.account.deleteAccountDialog(host,id);
                            DOMElement.cancelEvent(event);
                            return false;
                        }
                    } (data_module.usersDataList.items[i].id)
                });
            }
            sym = DOMElement.i({
                attrs: {
                    className:"material-icons",
                    style: {fontSize: "20px", color: "#929292"}
                },
                text: "lock_outline"
            }),
            con = DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("txt_permission")
            });
            sym.onmouseover = con.onmouseover = function (sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            } (sym, con);
            sym.onmouseout = con.onmouseout = function (sym, con) {
                return function(event, me) {
                    sym.style.color = "#929292";
                    con.style.color = "#929292";
                }
            } (sym, con);
            list.push({
                attrs: {style: {width: "170px"}},
                symbol: sym,
                content: con,
                onclick: function(id){
                    return function(event, me) {
                        //host.searchboxvalue = host.searchbox.value;
                        blackTheme.account.privilegeDialog(host,id);
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                } (data_module.usersDataList.items[i].id)
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

            celldata.push({
                attrs: {style: {width: "40px", textAlign: "center"}},
                children: [
                    DOMElement.i({
                        attrs: {
                            className: "material-icons " +  DOMElement.dropdownclass.button,
                            style: {
                                fontSize: "20px",
                                cursor: "pointer",
                                color: "#929292"
                            },
                            onmouseover: function(event, me) {
                                me.style.color = "black";
                            },
                            onmouseout: function(event, me) {
                                me.style.color = "#929292";
                            },
                            onclick: function (host1) {
                                return function(event, me) {
                                    host1.toggle();
                                    DOMElement.cancelEvent(event);
                                    return false;
                                }
                            } (h)
                        },
                        text: "more_vert"
                    }), h
                ]
            });
            data.push(celldata);
        }
        return data;
    };

    blackTheme.account.newAccountDialog = function(host,id) {
        var st;
        var selectedIndex = data_module.usersDataList.getIndex(id);
        DOMElement.removeAllChildren(host.pagetitle);
        if (selectedIndex < 0){
            host.pagetitle.appendChild(DOMElement.textNode(LanguageModule.text("txt_add_account")));
            host.holder.tilteText = LanguageModule.text("txt_add_account");
        }
        else {
            host.pagetitle.appendChild(DOMElement.textNode(LanguageModule.text("tit_edit_account")));
            host.holder.tilteText = LanguageModule.text("tit_edit_account");
        }
        host.holder.redrawFunction = function(host,id){
            return function (event, me) {
                var arr=host.frameList.getAllChild();
                host.frameList.activeFrame(arr[arr.length-1]);
                blackTheme.account.newAccountDialog(host,id);
            }
        } (host,id);
        var buttonPanel = DOMElement.div({
            attrs: {
                style: {
                    position: "fixed",
                    overflow: "hidden",
                    width: "calc(100vw - 40px)",
                    verticalAlign: "bottom",
                    backgroundColor: "white",
                    zIndex: 88
                }
            },
            children: [DOMElement.table({
                data: [[
                    {
                        children: [blackTheme.button071218.showButton({
                            sym: DOMElement.i({
                                    attrs: {
                                        className: "material-icons "
                                   },
                                   text: "clear"
                               }),
                            typebutton: 0,
                            onclick: function(host){
                                return function (event, me) {
                                    var arr=host.frameList.getAllChild();
                                    host.frameList.activeFrame(arr[arr.length-1]);
                                    blackTheme.account.redraw(host);
                                }
                            } (host),
                            text: LanguageModule.text("txt_close")
                        })]
                    },
                    {
                        attrs: {style: {width: "10px"}}
                    },
                    {
                        children: [blackTheme.button071218.showButton({
                            sym: DOMElement.i({
                                    attrs: {
                                        className: "material-icons "
                                   },
                                   text: "save"
                               }),
                            typebutton: 1,
                            text: LanguageModule.text("txt_save"),
                            onclick: function(host,id){
                                return function (event, me) {
                                    blackTheme.account.newAccountDialog_submit(host,id,0);
                                }
                            } (host,id)
                        })]
                    },
                    {
                        attrs: {style: {width: "10px"}}
                    },
                    {
                        children: [blackTheme.button071218.showButton({
                            sym: DOMElement.i({
                                 attrs: {
                                     className: "material-icons "
                                },
                                text: "save"
                            }),
                            typebutton: 0,
                            text: LanguageModule.text("txt_save_and_close"),
                            onclick: function(host,id){
                                return function (event, me) {
                                    blackTheme.account.newAccountDialog_submit(host,id,1);
                                }
                            } (host,id)
                        })]
                    },
                    {
                        attrs: {style: {width: "10px", height: "50px"}}
                    },
                    {
                        children: [blackTheme.button071218.showButton({
                            sym: DOMElement.i({
                                 attrs: {
                                     className: "material-icons "
                                },
                                text: "refresh"
                            }),
                            typebutton: 0,
                            text: LanguageModule.text("txt_refresh"),
                            onclick: function(){
                                contentModule.refreshCheck();
                            }
                        })]
                    }
                ]]
            })]
        });
        host.frameList.add(DOMElement.table({
            data :[
                [{children: [buttonPanel]}],
                [{attrs:{style:{height:"40px"}}}],
                [
                    {
                         attrs: {
                             colSpan: "3",
                             style: {
                                 height: "20px"
                             }
                         },
                         children: [
                             DOMElement.hr({
                                 attrs: {
                                     style: {
                                         marginTop: "0.5em",
                                         marginBottom: "0.5em",
                                         borderColor: "#d6d6d6",
                                         width: "calc(100vw - 50px)"
                                     }
                                 }
                             })
                         ]
                     }
                ],
                [
                     DOMElement.table({
                        data: blackTheme.account.editAccountData(host,selectedIndex)
                    })//table
                ]
            ]
        }));
        if (selectedIndex < 0){
            setTimeout(function(host){
                return function(){
                    host.username_inputtext.focus();
                }
            }(host), 50);
        }
        else {
            setTimeout(function(host){
                return function(){
                    host.fullname_inputtext.focus();
                }
            }(host), 50);
        }
        host.frameList.selectedIndex = host.frameList.count - 1;
    };

//# sourceURL=bsc:///src/account_black.php.js?
</script>
<?php
    }
?>
