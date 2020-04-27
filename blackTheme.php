<?php
    function write_reporter_script_black() {
        global $prefix;

?>
<script type="text/javascript">
blackTheme.reporter.deleteAccountDialog = function(host, id) {
    console.log(data_module.usersDataList.items[id].position)
    ModalElement.question({
        title: LanguageModule.text("title_deletepos"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.usersDataList.items[id]
            .position,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        blackTheme.reporter.deleteAccountDialog_submit(host, id);
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
};

blackTheme.reporter.deleteAccountDialog_submit = function(host, id) {
    jobdesc.categories.saveInDatabase(host, id, -1);
    data_module.usersDataList.items.splice(id, 1);
    jobdesc.menu.removeCkeditor(host)
    jobdesc.reporter_information.redrawTable(host);
};

blackTheme.account.newAccountDialog_submit = function(host, id, type) {
    var selectedIndex = host.database.users.getIndex(id);;
    var emailadd = host.email_inputtext.value;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(emailadd)) {
        ModalElement.alert({
            message: "Email không hợp lệ",
            className: "btn btn-primary"
        });
        return;
    }
    if (host.fullname_inputtext.value == "") {
        ModalElement.alert({
            message: "Chưa nhập họ và tên",
            className: "btn btn-primary"
        });
        return;
    }
    var params = [{
            name: "priv",
            value: host.priv_inputselect.value
        },
        {
            name: "first_name",
            value: host.fullname_inputtext.value
        },
        {
            name: "last_name",
            value: host.fullname_inputtext.value
        },
        {
            name: "comment",
            value: host.comment_inputtext.value
        },
        {
            name: "available",
            value: host.activated_inputselect.value
        }
    ];
    if (selectedIndex < 0) {
        if (host.username_inputtext.value == "") {
            ModalElement.alert({
                message: "Chưa nhập tài khoản",
                className: "btn btn-primary"
            });
            return;
        }
        if (host.password_inputtext.value == "") {
            ModalElement.alert({
                message: "Chưa nhập mật khẩu",
                className: "btn btn-primary"
            });
            return;
        }
        params.push({
            name: "id",
            value: 0
        });
        params.push({
            name: "username",
            value: host.username_inputtext.value
        });
        params.push({
            name: "password",
            value: host.password_inputtext.value
        });
        params.push({
            name: "email",
            value: host.email_inputtext.value
        });
        params.push({
            name: "pfid",
            value: systemconfig.selectedpf
        });
        params.push({
            name: "year",
            value: 2018
        });
        if (host.password_inputtext.value != host.password2_inputtext.value) {
            ModalElement.alert({
                message: "Mật khẩu không giống nhau",
                className: "btn btn-primary"
            });
            return;
        }
        params.push({
            name: "hint",
            value: host.passwordhint_inputtext.value
        });
        params.push({
            name: "homeid",
            value: 0
        });
    } else {
        id = host.userContent.id;
        params.push({
            name: "pfid",
            value: systemconfig.selectedpf
        });
        params.push({
            name: "year",
            value: 2018
        });
        params.push({
            name: "id",
            value: host.userContent.id
        });
        params.push({
            name: "homeid",
            value: host.userContent.homeid
        });
        params.push({
            name: "username",
            value: host.userContent.username
        });
        if (host.password_inputtext.value.trim() != "") {
            if (host.password_inputtext.value != host.password2_inputtext.value) {
                ModalElement.alert({
                    message: "Mật khẩu không giông nhau"
                });
                return;
            }
            if (host.password_inputtext.value.trim() == "123456") {
                ModalElement.alert({
                    message: "Không đc dùng mật khẩu này"
                });
                return;
            }
            params.push({
                name: "password",
                value: host.password_inputtext.value.trim()
            });
            params.push({
                name: "hint",
                value: host.passwordhint_inputtext.value.trim()
            });
        }
        params.push({
            name: "email",
            value: host.email_inputtext.value
        });
    }
    ModalElement.show_loading();
    FormClass.api_call({
        url: "user_update.php",
        params: params,
        func: function(success, message) {
            ModalElement.close(-1);
            if (success) {
                if (message.substr(0, 2) == "ok") {
                    if (selectedIndex < 0) {
                        id = parseInt(message.substr(2), 10);
                    }
                    if (type == 0) {
                        blackTheme.account.newAccountDialog(host, id);
                    } else if (type == 2) {
                        blackTheme.account.newAccountDialog(host, 0);
                    } else {
                        var arr=host.frameList.getAllChild();
                        host.frameList.activeFrame(arr[arr.length-1]);
                        blackTheme.account.redraw(host);
                    }
                } else if (message.substr(0, 5) == "check") {
                    var datau = EncodingClass.string.toVariable(message.substr(5));
                    ModalElement.question({
                        title: "Xác nhận tài khoản",
                        message: "Tài khoản: " + datau.username + "\nHọ và tên: " + datau
                            .fullname + "\nEmail: " + datau.email + "\n" + "Ghi chú: " + datau
                            .comment,
                        choicelist: [{
                                text: LanguageModule.text("btn_yes"),
                                class: "btn btn-primary"
                            },
                            {
                                class: "btn btn-primary",
                                text: LanguageModule.text("btn_no")
                            }
                        ],
                        onclick: function(index) {
                            switch (index) {
                                case 0:
                                    var param = {
                                        privilege: parseInt(host.priv_inputselect
                                            .value),
                                        privupdate: new Date(),
                                        lastprofileid: systemconfig.selectedpf,
                                        t_year: 2018,
                                        comment: "",
                                        language: "VN",
                                        theme: 1,
                                        available: 1,
                                        homeid: datau.id
                                    };
                                    ModalElement.show_loading();
                                    FormClass.api_call({
                                        url: "user_linkaccount.php",
                                        params: [{
                                            name: "data",
                                            value: EncodingClass.string
                                                .fromVariable(param)
                                        }],
                                        func: function(success, message) {
                                            ModalElement.close(-1);
                                            if (success) {
                                                if (message.substr(0, 2) ==
                                                    "ok") {
                                                    host.frameList
                                                        .removeByIndex(host
                                                            .frameList.count - 1
                                                            );
                                                    blackTheme.account.redraw(
                                                        host);
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
                                    break;
                                case 1:
                                    // do nothing
                                    break;
                            }
                        }
                    });
                    return;
                } else {
                    ModalElement.alert({
                        message: message,
                        class: "btn btn-primary"
                    });
                    return;
                }
            } else {
                ModalElement.alert({
                    message: message,
                    class: "btn btn-primary"
                });
                return;
            }
        }
    });
}

blackTheme.account.userprofile_update_submit = function() {
    var params = [];
    var indexid =
        <?php if (isset($_SESSION[$prefix.'jobdesc_user_id'])) echo $_SESSION[$prefix.'jobdesc_user_id']; else echo "0";?>;
    if (indexid !== 0)
        return;
    var np, nph, nn, s, theme, language, pfid, rp;
    params.push(["id", indexid]);
    ModalElement.show_loading();
    api_call(<?php api_getIndex(1); ?>, "user_update2.php", params, function(success, message) {
        ModalElement.close(-1);
        if (success) {
            if (message.substr(0, 2) == "ok") {} else {
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
    });
};

blackTheme.reporter.exportWord = function(id) {
    var promiseAll = [];
    promiseAll.push(data_module.countriesList.load());
    promiseAll.push(data_module.company.load());
    promiseAll.push(data_module.usersDataList.load());
    Promise.all(promiseAll).then(function() {
        jobdescui.extract(id, false).then(function(resolve) {
            var x = absol.JSDocx.fromHTMLCode(resolve);
            x.then((doc) => {
                console.log(doc)
                doc.saveAs("job_desc.docx");
            })
        })
    })
}

blackTheme.reporter.exportWordLocal = function(host) {
    console.log(host)
    jobdesc.responsibility.saveDataTask(host);
    //     data_module.usersDataList.items[host.data[0].Pos].data=[]
    //     for(var i=0;i<host.data.length;i++)
    //     {
    //         data_module.usersDataList.items[host.data[0].Pos].data[i+1]=host.data[host.checkIdProcess[host.information.childNodes[i].firstChild.innerHTML.slice(host.information.childNodes[i].firstChild.innerHTML.indexOf(" ")+2)]];
    //         if(data_module.usersDataList.items[host.data[0].Pos].data[i+1]===undefined)
    //         data_module.usersDataList.items[host.data[0].Pos].data[i+1]={}
    //         data_module.usersDataList.items[host.data[0].Pos].data[i+1].title=host.information.childNodes[i].firstChild.innerHTML.slice(host.information.childNodes[i].firstChild.innerHTML.indexOf(" ")+2);
    //         console.log(host.information.childNodes[i].firstChild.innerHTML.slice(host.information.childNodes[i].firstChild.innerHTML.indexOf(" ")+2))
    //     }
    // console.log(host.data)
    var string = "";
    string += LanguageModule.text("title_name_company") + " : " + data_module.company.item.nameCompany + "<br>";
    string += LanguageModule.text("title_address") + " : " + data_module.company.item.address + "<br>";
    string += LanguageModule.text("title_country") + " : " + data_module.countriesList.getID(host.data[0].country)
        .country_name + "<br>";
    string += LanguageModule.text("title_web") + " : " + data_module.company.item.webSite + "<br>";
    string += LanguageModule.text("title_department") + " : " + host.data[0].department + "<br>";
    string += LanguageModule.text("title_position") + " : " + host.data[0].position + "<br>";
    string += LanguageModule.text("title_job_code") + " : " + host.data[0].jobCode + "<br>";
    string += LanguageModule.text("title_job_replace") + " : " + host.data[0].jobReplace + "<br>";
    string += LanguageModule.text("title_note") + " : " + host.data[0].note + "<br>";
    for (var i = 1; i < host.data.length; i++) {
        var temp = host.data[i];
        if (temp.title !== undefined) {
            string += temp.title + "<br>";
            if (temp.data !== undefined) {
                for (var j = 0; j < temp.data.length; j++) {
                    string += temp.data[j][0] + "<br>";
                    string += temp.data[j][1];
                }
            }
        }
    }
    var x = absol.JSDocx.fromHTMLCode(string);
    x.then((doc) => {
        doc.saveAs("job_desc.docx");
    })
}

blackTheme.reporter.removeTaskContent = function(id) {
    console.log(id)
    ModalElement.question({
        title: LanguageModule.text("title_delete_content"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.taskContentsList.getID(id)
            .content,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.taskContentsList.removeOne(id);
                        for (var i = 0; i < data_module.taskContentsList.hosts.length; i++) {
                            var temp = data_module.taskContentsList.hosts[i].views.childNodes[
                                data_module.taskContentsList.checkID[id]];
                            temp.parentNode.removeChild(temp);
                            data_module.taskContentsList.hosts[i].me === undefined;
                        }
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
}



blackTheme.reporter.generateTableData = function(host) {

    var data = [];
    var celldata = [];
    var indexlist = [];
    var temp;
    var i, k, sym, con;
    for (i = 0; i < data_module.usersDataList.items.length; i++) {
        indexlist.push(i);
    }
    // sort(indexlist, function (a, b) {
    //     var k;
    //     if (data_module.usersDataList.items[a].privilege < data_module.usersDataList.items[b].privilege) return 1;
    //     if (data_module.usersDataList.items[a].privilege > data_module.usersDataList.items[b].privilege) return -1;
    //     k = stricmp(data_module.usersDataList.items[a].username, data_module.usersDataList.items[b].username);
    //     return k;
    // });
    for (k = 0; k < data_module.usersDataList.items.length; k++) {

        i = indexlist[k];
        celldata = [k + 1];
        temp = {};
        temp.Pos = i;
        //temp.nameCompany = data_module.usersDataList.items[i].nameCompany;
        // temp.address = data_module.usersDataList.items[i].address;
        // temp.webSite = data_module.usersDataList.items[i].webSite;
        temp.country = data_module.usersDataList.items[i].country;
        temp.direct = data_module.usersDataList.items[i].direct;
        temp.indirect = data_module.usersDataList.items[i].indirect;
        temp.ransack = data_module.usersDataList.items[i].ransack;
        temp.working_time = data_module.usersDataList.items[i].working_time;
        temp.position = data_module.usersDataList.items[i].position;
        temp.jobCode = data_module.usersDataList.items[i].jobCode;
        temp.jobReplace = data_module.usersDataList.items[i].jobReplace;
        temp.note = data_module.usersDataList.items[i].note;
        

        if (data_module.usersDataList.items[i].data === undefined)
            data_module.usersDataList.items[i].data = [];
        data_module.usersDataList.items[i].data[0] = temp;
        celldata.push({
            attrs: {
                onclick: function(host, k) {
                    return function(event, me) {
                        console.log(k)
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        host.me.k=k;
                        jobdescui.createIndexPreView(host, k);
                    }
                }(host, k),
            },
            text: data_module.company.item.nameCompany
        });
        celldata.push({
            attrs: {
                onclick: function(host, k) {
                    return function(event, me) {
                        console.log(k)
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        host.me.k=k;
                        jobdescui.createIndexPreView(host, k);
                    }
                }(host, k),
            },
            text: data_module.departmentsList.getID(data_module.positionsList.getID(data_module.usersDataList.items[i].position).departmentid).name
        });
        celldata.push({
            attrs: {
                onclick: function(host, k) {
                    return function(event, me) {
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        host.me.k=k;
                        jobdescui.createIndexPreView(host, k);
                    }
                }(host, k),
            },
            text: data_module.positionsList.getID(data_module.usersDataList.items[i].position).name
        });
        celldata.push({
            attrs: {
                onclick: function(host, k) {
                    return function(event, me) {
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        host.me.k=k;
                        jobdescui.createIndexPreView(host, k);
                    }
                }(host, k),
            },
            text: data_module.usersDataList.items[i].note
        });

        list = [];
        if (true) {
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
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "#929292";
                    con.style.color = "#929292";
                }
            }(sym, con);
            list.push({
                symbol: sym,
                content: con,
                onclick: function(tempabc, index, host) {
                    return function(event, me) {
                        //host.searchboxvalue = host.searchbox.value;
                        console.log(data_module.usersDataList.items[index].data)
                        jobdesc.menu.loadPage(7, data_module.usersDataList.items[index].data, host);
                        console.log(index)
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(data_module.usersDataList.items[i].data, i, host)
            });
            sym = DOMElement.i({
                attrs: {
                    className: "mdi mdi-file-word",
                    style: {
                        fontSize: "20px",
                        color: "#929292"
                    }
                },
            });
            con = DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_export")
            });
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "#929292";
                    con.style.color = "#929292";
                }
            }(sym, con);
            list.push({
                symbol: sym,
                content: con,
                onclick: function(id) {
                    return function(event, me) {
                        blackTheme.reporter.exportWord(id);
                    }
                }(i)
            });
            sym = DOMElement.i({
                attrs: {
                    className: "mdi fc59 mdi-file-search-outline",
                    style: {
                        fontSize: "20px",
                        color: "#929292"
                    }
                },
            });
            con = DOMElement.div({
                attrs: {
                    style: {
                        width: "100px"
                    }
                },
                text: LanguageModule.text("title_preview")
            });
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "#929292";
                    con.style.color = "#929292";
                }
            }(sym, con);
            list.push({
                symbol: sym,
                content: con,
                onclick: function(host, k) {
                    return function(event, me) {
                        me=event.path[7];
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        jobdescui.createIndexPreView(host, k);
                    }
                }(host, k),
            });
        }
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
                sym.style.color = "#929292";
                con.style.color = "#929292";
            }
        }(sym, con);
        list.push({
            symbol: sym,
            content: con,
            onclick: function(id) {
                return function(event, me) {
                    //host.searchboxvalue = host.searchbox.value;
                    me=event.path[7];
                    if (host.me !== undefined && host.me.classList.contains("choice"))
                        host.me.classList.remove("choice")
                        host.me=undefined;
                    console.log(id)
                    blackTheme.reporter.deleteAccountDialog(host, id);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(i)
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
        // h.style.marginTop = "-110px";
        // h.style.marginLeft = "-10px";
        celldata.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
                                host.style.top = "160px";
                                host.toggle();
                                console.log(host.childNodes[0].clientHeight)
                                if(!jobdescui.elementInViewport(host.childNodes[0]))
                                    {
                                        host.style.top = -host.childNodes[0].clientHeight +"px";
                                    }
                                else{
                                    host.style.top = 0 +"px";
                                }
                                DOMElement.cancelEvent(event);
                                return false;
                            }
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push(celldata);
    }
    return data;
};

blackTheme.reporter.selectPositions = function(host, position) {
    var dataList = data_module.positionsLibaryList.getTaskContent(position);

    for (var i = 0; i < dataList.length; i++) {

        if (host.checkSearch[dataList[i]] === undefined)
            host.checkSearch[dataList[i]] = {}
        if (host.checkSearch[dataList[i]].values === undefined)
            host.checkSearch[dataList[i]].values = 0;

        host.checkSearch[dataList[i]].values++;
    }
    for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
        if (host.checkSearch[data_module.taskContentsList.items[i].id] === undefined)
            host.checkSearch[data_module.taskContentsList.items[i].id] = {}
        if (host.checkSearch[data_module.taskContentsList.items[i].id].values === undefined)
            host.checkSearch[data_module.taskContentsList.items[i].id].values = 0;
        if (host.checkSearch[data_module.taskContentsList.items[i].id].check === undefined)
            host.checkSearch[data_module.taskContentsList.items[i].id].check = 1;
        if (host.checkSearch[data_module.taskContentsList.items[i].id].check === 1 && (host.checkSearch[data_module
                .taskContentsList.items[i].id].values > 0 || host.selectBox.values.length == 0))
            host.views.childNodes[i].style.display = ""
        else {
            host.views.childNodes[i].style.display = "none"
        }
    }
}

blackTheme.reporter.removePositions = function(host, position) {

    var dataList = data_module.positionsLibaryList.getTaskContent(position);

    for (var i = 0; i < dataList.length; i++) {
        host.checkSearch[dataList[i]].values--;
    }
    for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
        if (host.checkSearch[data_module.taskContentsList.items[i].id].check === 1 && (host.checkSearch[data_module
                .taskContentsList.items[i].id].values > 0 || host.selectBox.values.length == 0))
            host.views.childNodes[i].style.display = ""
        else {
            host.views.childNodes[i].style.display = "none"
        }
    }

}

blackTheme.reporter.removePositionsAll = function(host, id) {

    for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
        if (host.checkSearch[data_module.taskContentsList.items[i].id] === undefined) {
            host.checkSearch[data_module.taskContentsList.items[i].id] = {};
            host.checkSearch[data_module.taskContentsList.items[i].id].check = 1;
            host.checkSearch[data_module.taskContentsList.items[i].id].values = 0;
        }

        for (var j = 0; j < data_module.positionsLibaryList.getTaskContent(id).length; j++) {
            if (data_module.positionsLibaryList.getTaskContent(id)[j] === id)
                host.checkSearch[data_module.taskContentsList.items[i].id].values--;
            break;
        }
        console.log(host.checkSearch[data_module.taskContentsList.items[i].id].check === 1, (host.checkSearch[
            data_module
            .taskContentsList.items[i].id].values > 0, host.selectBox.values.length == 0))
        if (host.checkSearch[data_module.taskContentsList.items[i].id].check === 1 && (host.checkSearch[data_module
                .taskContentsList.items[i].id].values > 0 || host.selectBox.values.length == 0))
            host.views.childNodes[i].style.display = ""
        else {
            host.views.childNodes[i].style.display = "none"
        }
    }
}

blackTheme.reporter.updatePosition = function(host, views, temp) {
    console.log(views, temp)
    host.checkSearch[temp.id] = {};
    host.checkSearch[temp.id].values = 0;
    host.checkSearch[temp.id].check = 1;
    for (var i = 0; i < host.selectBox.values.length; i++) {
        for (var j = 0; j < data_module.taskContentsList.getPosition(temp.id).length; j++) {
            console.log(host.selectBox.values[i], data_module.taskContentsList.getPosition(temp.id)[j])
            if (host.selectBox.values[i] == data_module.taskContentsList.getPosition(temp.id)[j]) {
                host.checkSearch[temp.id].values++;
                break;
            }
        }
    }
    if (host.checkSearch[temp.id].check === 1 && (host.checkSearch[temp.id].values > 0 || host.selectBox.values
            .length === 0))
        views.style.display = ""
    else {
        views.style.display = "none"
    }
    if (host.evt !== undefined && host.values !== undefined)
        jobdescui.Search(host, host.evt);
}

blackTheme.reporter_categories.generateTableDataCategories = function(host) {

    var data = [];
    var celldata = [];
    var indexlist = [];
    var temp;
    var i, k, sym, con;

    for (i = 0; i < data_module.categoriesList.items.length; i++) {
        indexlist.push(i);
    }
    for (k = 0; k < data_module.categoriesList.items.length; k++) {
        i = indexlist[k];
        celldata = [k + 1];
        celldata.push({
            text: data_module.categoriesList.items[i].name
        });
        celldata.push({
            text: data_module.categoriesList.items[i].description
        });
        celldata.push({
            text: data_module.categoriesList.items[i].ver
        });
        // celldata.push({
        //     text: data_module.categoriesList.items[i].note
        // });
        // if (data_module.usersDataList.items[i].comment === ""){
        //     celldata.push({
        //         text: ""
        //     });
        // }
        // else {
        //   celldata.push({
        //       valign: "middle;",
        //       innerHTML: DOMClass.tooltipString({
        //           color: "white",
        //           hpos: -1,
        //           width: 250,
        //           height: 50,
        //           backgroundcolor: "grey",
        //           innerHTML: "<div style=\"overflow: hidden; width: 150px; height: 26px; white-space: nowrap;\">" + EncodingClass.textshow(data_module.usersDataList.items[i].comment) + "</div>",
        //           tooltiptext: data_module.usersDataList.items[i].comment
        //       })
        //   });
        // }
        list = [];

        //host.frameList.add(blackTheme.reporter_categories.updateCategory(data_module.categoriesList.items[i].id,data_module.categoriesList.items[i].name,data_module.categoriesList.items[i].description,i));

        if (true) {
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
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
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
                onclick: function(tempabc, index, host) {
                    return function(event, me) {
                        //to do something o day'
                        // ModalElement.showWindow({
                        //     index: 1,
                        //     title: "Thêm chỉ mục",
                        //     bodycontent:
                        // });
                        var temp1 = blackTheme.reporter_categories.updateCategory(host,tempabc.id, tempabc.name, tempabc.description, index)
                        host.frameList.addChild(temp1);
                        host.frameList.activeFrame(temp1);
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(data_module.categoriesList.items[i], i, host)
            });
            // sym = DOMElement.i({
            //     attrs: {
            //         className:"material-icons",
            //         style: {fontSize: "20px", color: "#929292"}
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
            //     return function(event, me) {
            //         sym.style.color = "red";
            //         con.style.color = "black";
            //     }
            // } (sym, con);
            // sym.onmouseout = con.onmouseout = function (sym, con) {
            //     return function(event, me) {
            //         sym.style.color = "#929292";
            //         con.style.color = "#929292";
            //     }
            // } (sym, con);
            // list.push({
            //     attrs: {style: {width: "170px"}},
            //     symbol: sym,
            //     content: con,
            //     onclick: function(id){
            //         return function(event, me) {
            //             blackTheme.reporter.exportWord(id);
            //         }
            //     } (i)
            // });
        }
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(id, host) {
                return function(event, me) {
                    console.log(id)
                    blackTheme.reporter_categories.removeCategory(host, id);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(data_module.categoriesList.items[i].id, host)
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
        // h.style.marginTop = "-110px";
        // h.style.marginLeft = "-10px";
        celldata.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
                                host.style.top = "60px";
                                host.toggle();
                                if(!jobdescui.elementInViewport(host.childNodes[0]))
                                    {
                                        host.style.top = -host.childNodes[0].clientHeight +"px";
                                    }
                                else{
                                        host.style.top = 0 +"px";
                                    }
                                DOMElement.cancelEvent(event);
                                return false;
                            }
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push(celldata);
    }
    return data;
};

blackTheme.reporter_categories.removeCategory = function(host, id) {
    ModalElement.question({
        title: LanguageModule.text("txt_delete_category"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.categoriesList.getID(id)
            .name,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.categoriesList.removeOne(id).then(function() {
                            jobdesc.reporter_categories_information.redrawTable(host);
                        })
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
}

blackTheme.reporter_categories.addCategory = function(host) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"));
    var desc = jobdescui.spanInput(LanguageModule.text("title_description"), "", false);
    var mainFrame = absol.buildDom({
        tag:'singlepage',
        child:[
            {
                class: 'absol-single-page-header',
                child:[
                    {
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                    host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    },
                    {
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "description",
                                        value: desc.childNodes[1].value
                                    },
                                ]
                                data_module.categoriesList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_categories_information
                                            .redrawTable(host);
                                    })

                            }
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
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "description",
                                        value: desc.childNodes[1].value
                                    },
                                ]
                                data_module.categoriesList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_categories_information
                                            .redrawTable(host);
                                    var arr=host.frameList.getAllChild();
                                    host.frameList.activeFrame(arr[arr.length-1]);
                                    })

                            }
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
            },
            {
                class: 'absol-single-page-footer'
            }
        ]
    }); 
    mainFrame.addChild(absol.buildDom({
        tag:"div",
        class:"update-catergory",
        child:[
            name,
            {
            tag:"div",
            class:"space",
            },
            desc
        ]
    }))
    jobdesc.menu.footer(absol.$('.absol-single-page-footer', mainFrame));
    return mainFrame;
}

blackTheme.reporter_categories.updateCategory = function(host, id, param, param1, index) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"), param);
    var desc = jobdescui.spanInput(LanguageModule.text("title_description"), param1, false);
    var mainFrame = absol.buildDom({
        tag:'singlepage',
        child:[
            {
                class: 'absol-single-page-header',
                child:[
                    {
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    },{
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "description",
                                        value: desc.childNodes[1].value
                                    },
                                ]
                                data_module.categoriesList.updateOne(paramEdit, index)
                                    .then(function() {
                                        jobdesc.reporter_categories_information
                                            .redrawTable(host);
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host);
                                    })


                            }
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
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "description",
                                        value: desc.childNodes[1].value
                                    },
                                ]
                                data_module.categoriesList.updateOne(paramEdit, index)
                                    .then(function() {
                                        jobdesc.reporter_categories_information
                                            .redrawTable(host);
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host);
                                        var arr=host.frameList.getAllChild();
                                        host.frameList.activeFrame(arr[arr.length-1]);
                                    })


                            }
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
            },
            {
                class: 'absol-single-page-footer'
            }
        ]
    }); 
    jobdesc.menu.footer(absol.$('.absol-single-page-footer', mainFrame));
    mainFrame.addChild(absol.buildDom({
        tag:"div",
        class:"update-catergory",
        child:[
            name,
             {
                 tag:"div",
                 class:"space"
             }
            desc,   
        ]
    }));
    host.frameList.addChild(mainFrame);
    host.frameList.activeFrame(mainFrame);

    return mainFrame;
}

blackTheme.reporter_positions.generateTableDataPositions = function(host, id) {

    var data = [];
    var celldata = [];
    var indexlist = [];
    var temp;
    var i, k, sym, con;
    var array = []
    if (id !== undefined) {
        for (var i = 0; i < data_module.departmentsList.getPosition(id).length; i++)
            array.push(data_module.positionsList.getID(data_module.departmentsList.getPosition(id)[i]));
        console.log(array)
    } else
        array = data_module.positionsList.items
    for (i = 0; i < array.length; i++) {
        indexlist.push(i);
    }
    for (k = 0; k < array.length; k++) {
        i = indexlist[k];
        celldata = [k + 1];
        celldata.push({
            text: array[i].name
        });
        celldata.push({
            text: data_module.departmentsList.getID(array[i].departmentid).name
        });
        celldata.push({
            text: array[i].code
        });
        list = [];
        if (true) {
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
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
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
                onclick: function(tempabc, host, index) {
                    return function(event, me) {
                        //to do something o day'
                        console.log(tempabc)
                        // ModalElement.showWindow({
                        //     index: 1,
                        //     title: "Thêm chỉ mục",
                        //     bodycontent:blackTheme.reporter_positions.updatePosition(tempabc.id,tempabc.name,tempabc.departmentid,index)
                        // });
                        host.frameList.add(blackTheme.reporter_positions.updatePosition(host,
                            tempabc.id, tempabc.name, tempabc.departmentid, tempabc.code,
                            index));
                        host.frameList.selectedIndex = host.frameList.count - 1;
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(array[i], host, id)
            });

        }
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(id, host, hostID) {
                return function(event, me) {
                    console.log(id)
                    blackTheme.reporter_positions.removePosition(host, id, hostID);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(array[i].id, host, id)
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
        // h.style.marginTop = "-110px";
        // h.style.marginLeft = "-10px";
        celldata.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
                                host.style.top = "60px";
                                host.toggle();
                                if(!jobdescui.elementInViewport(host.childNodes[0]))
                                    {
                                        host.style.top = -host.childNodes[0].clientHeight +"px";
                                    }
                                else{
                                        host.style.top = 0 +"px";
                                    }
                                DOMElement.cancelEvent(event);
                                return false;
                            }
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push(celldata);
    }
    return data;
};

blackTheme.reporter_positions_libary.generateTableDataPositions = function(host, id) {

var data = [];
var celldata = [];
var indexlist = [];
var temp;
var i, k, sym, con;
var array = data_module.positionsLibaryList.items;
for (i = 0; i < array.length; i++) {
    indexlist.push(i);
}
for (k = 0; k < array.length; k++) {
    i = indexlist[k];
    celldata = [k + 1];
    celldata.push({
        text: array[i].name
    });
    list = [];
    if (true) {
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "black";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(tempabc, host, index) {
                return function(event, me) {
                    //to do something o day'
                    console.log(tempabc)
                    // ModalElement.showWindow({
                    //     index: 1,
                    //     title: "Thêm chỉ mục",
                    //     bodycontent:blackTheme.reporter_positions.updatePosition(tempabc.id,tempabc.name,tempabc.departmentid,index)
                    // });
                    host.frameList.add(blackTheme.reporter_positions_libary.updatePosition(host,
                        tempabc.id, tempabc.name,index));
                    host.frameList.selectedIndex = host.frameList.count - 1;
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(array[i], host, id)
        });

    }
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
    sym.onmouseover = con.onmouseover = function(sym, con) {
        return function(event, me) {
            sym.style.color = "red";
            con.style.color = "black";
        }
    }(sym, con);
    sym.onmouseout = con.onmouseout = function(sym, con) {
        return function(event, me) {
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
        onclick: function(id, host, hostID) {
            return function(event, me) {
                console.log(id)
                blackTheme.reporter_positions_libary.removePosition(host, id);
                DOMElement.cancelEvent(event);
                return false;
            }
        }(array[i].id, host, id)
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
    // h.style.marginTop = "-110px";
    // h.style.marginLeft = "-10px";
    celldata.push({
        attrs: {
            style: {
                width: "40px",
                textAlign: "center"
            }
        },
        children: [
            DOMElement.i({
                attrs: {
                    className: "material-icons " + DOMElement.dropdownclass.button,
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
                    onclick: function(host) {
                        return function(event, me) {
                            host.style.top = "60px";
                            host.toggle();
                            if(!jobdescui.elementInViewport(host.childNodes[0]))
                                {
                                    host.style.top = -host.childNodes[0].clientHeight +"px";
                                }
                            else{
                                    host.style.top = 0 +"px";
                                }
                            DOMElement.cancelEvent(event);
                            return false;
                        }
                    }(h)
                },
                text: "more_vert"
            }), h
        ]
    });
    data.push(celldata);
}
return data;
};

blackTheme.reporter_positions_libary.removePosition = function(host, id) {
    ModalElement.question({
        title: LanguageModule.text("txt_delete_category"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.positionsLibaryList.getID(id).name,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.positionsLibaryList.removeOne(id).then(function() {
                            jobdesc.reporter_positions_libary_information.redrawTable();
                        })
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
}

blackTheme.reporter_positions.removePosition = function(host, id, hostID) {
    ModalElement.question({
        title: LanguageModule.text("txt_delete_category"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.positionsList.getID(id)
            .name,
        onclick: function(id, hostID) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.positionsList.removeOne(id).then(function() {
                            jobdesc.reporter_positions_information.redrawTable(host,
                            hostID);
                            jobdesc.reporter_information.redrawTable();
                        })
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id, hostID)
    });
}

blackTheme.reporter_positions_libary.addPosition = function(host) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"));
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                ]
                                data_module.positionsLibaryList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_positions_libary_information
                                            .redrawTable();
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                ]
                                data_module.positionsLibaryList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_positions_libary_information
                                            .redrawTable();
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {},
                },
                children: [
                    name,
                ]
            })
        ]
    })
}

blackTheme.reporter_positions.addPosition = function(host, value) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"));
    var desc;
    if (value !== undefined)
        desc = jobdescui.spanSelect(LanguageModule.text("title_department"), data_module.departmentsList.items.map(
            function(u, i) {
                console.log({
                    text: u.name,
                    value: u.id
                })
                return {
                    text: u.name,
                    value: u.id
                }
            }), value);
    else
        desc = jobdescui.spanSelect(LanguageModule.text("title_department"), data_module.departmentsList.items.map(
            function(u, i) {
                console.log({
                    text: u.name,
                    value: u.id
                })
                return {
                    text: u.name,
                    value: u.id
                }
            }));
    var code = jobdescui.spanInput(LanguageModule.text("title_code"));
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "departmentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },

                                ]
                                data_module.positionsList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_positions_information
                                            .redrawTable(host, value);
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "departmentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.positionsList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_positions_information
                                            .redrawTable(host, value);
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {},
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    desc,
                ]
            })
        ]
    })
}


blackTheme.reporter_positions.updatePosition = function(host, id, param, param1, param2, index) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"), param);
    var desc = jobdescui.spanSelect(LanguageModule.text("title_department"), data_module.departmentsList.items.map(
        function(u, i) {
            console.log({
                text: u.name,
                value: u.id
            })
            return {
                text: u.name,
                value: u.id
            }
        }), param1);
    var code = jobdescui.spanInput(LanguageModule.text("title_code"), param2);
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "departmentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.positionsList.updateOne(paramEdit)
                                    .then(function() {
                                        jobdesc.reporter_positions_information
                                            .redrawTable(host, index);
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "departmentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.positionsList.updateOne(paramEdit)
                                    .then(function() {
                                        jobdesc.reporter_positions_information
                                            .redrawTable(host, index);
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {},
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),,
                    desc,
                ]
            })

        ]
    })
}

blackTheme.reporter_positions_libary.updatePosition = function(host, id, param, index) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"), param);
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                ]
                                data_module.positionsLibaryList.updateOne(paramEdit)
                                    .then(function() {
                                        jobdesc.reporter_positions_libary_information
                                            .redrawTable();
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                ]
                                data_module.positionsLibaryList.updateOne(paramEdit)
                                    .then(function() {
                                        jobdesc.reporter_positions_libary_information
                                            .redrawTable();
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {},
                },
                children: [
                    name,
                ]
            })

        ]
    })
}

blackTheme.reporter_departments.generateTableDataDepartment = function(host, content, departmentid) {
    var i, j, data = [],
        index, cells, cells_data, cells_dataCode;
    var sym, con, list, h;
    var values;
    console.log(host)
    for (i = 0; i < content.length; i++) {
        values = data_module.departmentsList.getID(content[i]);
        console.log(values)
        index = data_module.departmentsList.checkID[content[i]];
        list = [];
        sym = DOMElement.i({
            attrs: {
                className: "material-icons",
                style: {
                    fontSize: "20px",
                    color: "#929292"
                }
            },

            text: "add"
        });
        con = DOMElement.div({
            attrs: {
                style: {
                    width: "120px"
                }
            },
            text: LanguageModule.text("ctrl_add") + " " + LanguageModule.text("title_department")
        });
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "black";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(host, id) {
                return function() {
                    console.log(host)
                    host.frameList.add(blackTheme.reporter_departments.addDepartment(host, id));
                    host.frameList.selectedIndex = host.frameList.count - 1;
                }
            }(host, content[i])
        });
        sym = DOMElement.i({
            attrs: {
                className: "material-icons",
                style: {
                    fontSize: "20px",
                    color: "#929292"
                }
            },

            text: "add"
        });
        con = DOMElement.div({
            attrs: {
                style: {
                    width: "120px"
                }
            },
            text: LanguageModule.text("ctrl_add") + " " + LanguageModule.text("title_position")
        });
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "black";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(host, id) {
                return function() {
                    console.log(host)
                    host.frameList.add(blackTheme.reporter_positions.addPosition(host, id));
                    host.frameList.selectedIndex = host.frameList.count - 1;
                }
            }(host, content[i])
        });
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "black";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(tempabc, index, host) {
                return function(event, me) {
                    //to do something o day'
                    console.log(tempabc)
                    host.frameList.add(blackTheme.reporter_departments.updateDepartment(host,
                        tempabc.id, tempabc.name, tempabc.parentid, tempabc.code, index));
                    host.frameList.selectedIndex = host.frameList.count - 1;
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(values, i, host)
        });

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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(id, host) {
                return function(event, me) {
                    console.log(id)
                    blackTheme.reporter_departments.removeDepartment(host, id);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(values.id, host)
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
        h.style.left="-5px";
        cells_data = DOMElement.td({
            attrs: {
                style: {
                    cursor: "pointer",
                    whiteSpace: "nowrap"
                },
                onclick: function(id,host) {
                    return function(event, me) {
                        while (me.tagName.toLowerCase() !== "table") me = me.parentElement;
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")
                        host.me.id = id;
                        if (host.containerList.children.length === 0)
                            host.containerList.appendChild(jobdesc.reporter_positions_information
                                .tableCreate(host, id));
                        else
                            jobdesc.reporter_positions_information.redrawTable(host, id)

                    }
                }(values.id,host)
            },
            text: values.name
        });
        cells_dataCode = DOMElement.td({
            attrs: {
                style: {
                    cursor: "pointer",
                    whiteSpace: "nowrap"
                },
                onclick: function(id) {
                    return function(event, me) {
                        // while (me.tagName.toLowerCase() !== "table") me = me.parentElement;
                        while (me.tagName.toLowerCase() !== "tr") me = me.parentElement;
                        if (host.me !== undefined && host.me.classList.contains("choice"))
                            host.me.classList.remove("choice")
                        host.me = me;
                        host.me.classList.add("choice")

                        if (host.containerList.children.length === 0)
                            host.containerList.appendChild(jobdesc.reporter_positions_information
                                .tableCreate(host, id));
                        else
                            jobdesc.reporter_positions_information.redrawTable(host, id)

                    }
                }(values.id)
            },
            text: values.code
        });
        // if (content[j] == departmentid) host.oldCell = cells_data;
        cells = [
            cells_data,
            cells_dataCode
            // {
            //     attrs: {
            //         style: {
            //             whiteSpace: "nowrap"
            //         }
            //     },
            //     text: values.code
            // }
        ];
        if(host.me!==undefined&&content[i]==host.me.id)
        {
            console.log(cells,"aaaaaaa")
            // if (host.me !== undefined && host.me.classList.contains("choice"))
            //     host.me.classList.remove("choice")
            //     host.me = cells;
            //     host.me.classList.add("choice")
            //     host.me.id = id;
        }
        cells.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
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
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push({
            cells: cells,
            children: blackTheme.reporter_departments.generateTableDataDepartment(host, data_module
                .departmentsList.getChildren(content[i]), departmentid)
        });
    }
    return data;
};

blackTheme.reporter_departments.removeDepartment = function(host, id) {
    console.log(id)
    ModalElement.question({
        title: LanguageModule.text("txt_delete_category"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.departmentsList.getID(id).name,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.departmentsList.removeOne(host, id).then(function() {
                            jobdesc.reporter_departments_information.redrawTable(host);
                        })
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
}

blackTheme.reporter_departments.addDepartment = function(host, value) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"));
    var desc;
    if (value !== undefined)
        desc = jobdescui.spanSelect(LanguageModule.text("title_parent_department"), data_module.departmentsList
            .items.map(
                function(u, i) {
                    console.log({
                        text: u.name,
                        value: u.id
                    })
                    return {
                        text: u.name,
                        value: u.id
                    }
                }), value);
    else {
        desc = jobdescui.spanSelect(LanguageModule.text("title_parent_department"), [{
            text: LanguageModule.text("title_head_department"),
            value: 0
        }], 0);
        desc.childNodes[1].style.pointerEvents = "none";
        desc.childNodes[1].style.backgroundColor = "#ebebe4";
    }
    var code = jobdescui.spanInput(LanguageModule.text("title_code"));
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            marginLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "parentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },

                                ]
                                console.log(param)
                                data_module.departmentsList.addOne(host, param).then(
                                    function() {
                                        jobdesc.reporter_departments_information
                                            .redrawTable(host);
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            marginLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "parentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                console.log(param)
                                data_module.departmentsList.addOne(host, param).then(
                                    function() {
                                        jobdesc.reporter_departments_information
                                            .redrawTable(host);
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {},
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    desc,
                ]
            })
        ]
    })
}

blackTheme.reporter_departments.updateDepartment = function(host, id, param, param1, param2, index) {
    var arr = [];
    var name = jobdescui.spanInput(LanguageModule.text("title_name"), param);
    var desc;
    if (param1 === 0) {
        desc = jobdescui.spanSelect(LanguageModule.text("title_parent_department"), [{
            text: LanguageModule.text("title_head_department"),
            value: 0
        }], 0);
        desc.childNodes[1].style.pointerEvents = "none";
        desc.childNodes[1].style.backgroundColor = "#ebebe4";
    } else {
        for (var i = 0; i < data_module.departmentsList.items.length; i++) {
            if (data_module.departmentsList.items[i].id === id)
                continue;
            arr.push({
                text: data_module.departmentsList.items[i].name,
                value: data_module.departmentsList.items[i].id
            })
        }
        desc = jobdescui.spanSelect(LanguageModule.text("title_parent_department"), arr, param1);
    }
    var code = jobdescui.spanInput(LanguageModule.text("title_code"), param2);
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "parentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.departmentsList.updateOne(host, paramEdit,
                                        index)
                                    .then(function() {
                                        if (host.me != undefined && host.me.id ==
                                            id)
                                            jobdesc.reporter_positions_information
                                            .redrawTable(host, id);
                                        jobdesc.reporter_departments_information
                                            .redrawTable(host);
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "parentid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.departmentsList.updateOne(host, paramEdit,
                                        index)
                                    .then(function() {
                                        if (host.me != undefined && host.me.id ==
                                            id)
                                            jobdesc.reporter_positions_information
                                            .redrawTable(host, id);
                                        jobdesc.reporter_departments_information
                                            .redrawTable(host);
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                    style: {

                    },
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    desc,
                ]
            })

        ]
    })
}
blackTheme.reporter_tasks.generateTableDataTasks = function(host) {

    var data = [];
    var celldata = [];
    var indexlist = [];
    var temp;
    var i, k, sym, con;
    var array = []
    array = data_module.tasksList.items
    var stringCategory;

    for (i = 0; i < array.length; i++) {
        indexlist.push(i);
    }
    for (k = 0; k < array.length; k++) {
        i = indexlist[k];
        celldata = [k + 1];
        if (data_module.categoriesList.getID(array[i].categoryid) !== undefined)
            stringCategory = data_module.categoriesList.getID(array[i].categoryid).name
        else
            stringCategory = "";
        celldata.push({
            text: array[i].name
        });
        celldata.push({
            text: stringCategory
        });
        celldata.push({
            text: array[i].code
        });
        list = [];
        if (true) {
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
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
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
                onclick: function(tempabc, host, index) {
                    return function(event, me) {
                        //to do something o day'
                        console.log(tempabc)
                        // ModalElement.showWindow({
                        //     index: 1,
                        //     title: "Thêm chỉ mục",
                        //     bodycontent:blackTheme.reporter_positions.updatePosition(tempabc.id,tempabc.name,tempabc.departmentid,index)
                        // });
                        host.frameList.add(blackTheme.reporter_tasks.updateTask(host,
                            tempabc.id, tempabc.name, tempabc.categoryid, tempabc.code,
                            index));
                        host.frameList.selectedIndex = host.frameList.count - 1;
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(array[i], host, i)
            });

        }
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(id, host) {
                return function(event, me) {
                    console.log(id)
                    blackTheme.reporter_tasks.removeTask(host, id);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(array[i].id, host)
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
        h.style.left = "-10px";
        celldata.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
                                host.style.top = "80px";
                                host.toggle();
                                if(!jobdescui.elementInViewport(host.childNodes[0]))
                                    {
                                        host.style.top = -host.childNodes[0].clientHeight +"px";
                                    }
                                else{
                                    host.style.top = 0 +"px";
                                }
                                DOMElement.cancelEvent(event);
                                return false;
                            }
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push(celldata);
    }
    return data;
};

blackTheme.reporter_tasks.addTask = function(host, value) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"));
    var desc;
    if (value !== undefined)
        desc = jobdescui.spanSelect(LanguageModule.text("title_group_job"), data_module.categoriesList.items.map(
            function(u, i) {
                console.log({
                    text: u.name,
                    value: u.id
                })
                return {
                    text: u.name,
                    value: u.id
                }
            }), value);
    else
        desc = jobdescui.spanSelect(LanguageModule.text("title_group_job"), data_module.categoriesList.items.map(
            function(u, i) {
                console.log({
                    text: u.name,
                    value: u.id
                })
                return {
                    text: u.name,
                    value: u.id
                }
            }));
    var code = jobdescui.spanInput(LanguageModule.text("title_code"));
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "categoryid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },

                                ]
                                data_module.tasksList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host, value);
                                    })
                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var param = [{
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "categoryid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },

                                ]
                                data_module.tasksList.addOne(param).then(
                                    function() {
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host, value);
                                    })
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
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
                    })
                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    desc,
                ]
            })
        ]
    })
};

blackTheme.reporter_tasks.removeTask = function(host, id) {
    ModalElement.question({
        title: LanguageModule.text("txt_delete_category"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.tasksList.getID(id)
            .name,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.tasksList.removeOne(id, host).then(function() {
                            jobdesc.reporter_tasks_information.redrawTable(host);
                        })
                        if (data_module.taskContentsList.hosts !== undefined) {
                            data_module.taskContentsList.getID(0);
                            for (var i = 0; i < data_module.taskContentsList.hosts.length; i++) {
                                for (var j = 0; j < data_module.tasksList.getTaskContent(id)
                                    .length; j++) {
                                    var temp = data_module.taskContentsList.hosts[i].views
                                        .childNodes[
                                            data_module.taskContentsList.checkID[data_module
                                                .tasksList.getTaskContent(id)[j]]];
                                    temp.parentNode.removeChild(temp);
                                    data_module.taskContentsList.hosts[i].me = undefined;
                                }
                            }
                        }
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
};

blackTheme.reporter_tasks.updateTask = function(host, id, param, param1, param2, index) {
    var name = jobdescui.spanInput(LanguageModule.text("title_name"), param);
    var desc = jobdescui.spanSelect(LanguageModule.text("title_group_job"), data_module.categoriesList.items.map(
        function(u, i) {
            console.log({
                text: u.name,
                value: u.id
            })
            return {
                text: u.name,
                value: u.id
            }
        }), param1);
    var code = jobdescui.spanInput(LanguageModule.text("title_code"), param2);
    return DOMElement.div({
        attrs: {
            style: {
                display: "table",
                height: "calc(100vh - 125px)",
            }
        },
        children: [
            DOMElement.div({
                attrs: {
                    style: {
                        display: "block",
                        textAlign: "left",                         
                        padding: "10px 10px 10px 20px",
                    },
                },
                children: [
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var arr=host.frameList.getAllChild();
                                host.frameList.activeFrame(arr[arr.length-1]);
                            }
                        },
                        child: [{
                                tag: 'i',
                                class: 'material-icons',
                                props: {
                                    innerHTML: 'save'
                                }
                            },
                            '<span>' + LanguageModule.text("ctrl_close") + '</span>'
                        ]
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        class:"info",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "categoryid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.tasksList.updateOne(paramEdit, index)
                                    .then(function() {
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host);
                                    })


                            }
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
                    }),
                    absol.buildDom({
                        tag: "iconbutton",
                        style: {
                            paddingLeft: "10px"
                        },
                        on: {
                            click: function(evt) {
                                var paramEdit = [{
                                        name: "id",
                                        value: id
                                    },
                                    {
                                        name: "name",
                                        value: name.childNodes[1].value
                                    },
                                    {
                                        name: "categoryid",
                                        value: absol.$('selectmenu', desc).value
                                    },
                                    {
                                        name: "code",
                                        value: code.childNodes[1].value
                                    },
                                ]
                                data_module.tasksList.updateOne(paramEdit, index)
                                    .then(function() {
                                        jobdesc.reporter_tasks_information
                                            .redrawTable(host);
                                            var arr=host.frameList.getAllChild();
                                            host.frameList.activeFrame(arr[arr.length-1]);
                                    })


                            }
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
                    }),

                ]
            }),
            DOMElement.div({
                attrs: {
                    className: "update-catergory",
                },
                children: [
                    name,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    code,
                    DOMElement.div({
                        attrs:{
                            className:"space"
                        }
                    }),
                    desc,
                ]
            })

        ]
    })
};
blackTheme.reporter_users.generateTableDataUsers = function(host) {

    var data = [];
    var celldata = [];
    var indexlist = [];
    var temp;
    var i, k, sym, con;
    var array = []
    array = data_module.usersList.items
    var stringCategory;

    for (i = 0; i < array.length; i++) {
        indexlist.push(i);
    }
    var stringPrivilege;
    var stringPrivilegeAccount;
    var stringAvailable;

    for (k = 0; k < array.length; k++) {
        i = indexlist[k];
        stringPrivilege = LanguageModule.text("txt_no");
        stringPrivilegeAccount = LanguageModule.text("txt_no");
        stringAvailable = LanguageModule.text("txt_no");
        if (array[i].privilege !== 0) {
            stringPrivilege = LanguageModule.text("txt_yes");
            if (array[i].privilege !== 1)
                stringPrivilegeAccount = LanguageModule.text("txt_yes");
        } else {

        }
        if (array[i].available !== 0)
            stringAvailable = LanguageModule.text("txt_yes");
        celldata = [k + 1];
        celldata.push({
            text: data_module.usersListHome.getID(array[i].homeid).username
        });
        celldata.push({
            text: data_module.usersListHome.getID(array[i].homeid).fullname
        });
        celldata.push({
            text: data_module.usersListHome.getID(array[i].homeid).email
        });
        celldata.push({
            text: array[i].privupdate
        });
        celldata.push({
            text: stringPrivilege
        });
        celldata.push({
            text: stringPrivilegeAccount
        });
        celldata.push({
            text: stringAvailable
        });
        celldata.push({
            text: data_module.countriesList.getID(array[i].language).country_name
        });
        celldata.push({
            text: array[i].comment
        });
        list = [];
        if (true) {
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
            sym.onmouseover = con.onmouseover = function(sym, con) {
                return function(event, me) {
                    sym.style.color = "black";
                    con.style.color = "black";
                }
            }(sym, con);
            sym.onmouseout = con.onmouseout = function(sym, con) {
                return function(event, me) {
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
                onclick: function(tempabc) {
                    return function(event, me) {
                        //to do something o day'
                        console.log(tempabc)
                        var temp1 = jobdescui.formAddUser(host, tempabc);
                        host.frameList.addChild(temp1);
                        host.frameList.activeFrame(temp1);
                        DOMElement.cancelEvent(event);
                        return false;
                    }
                }(array[i])
            });

        }
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
        sym.onmouseover = con.onmouseover = function(sym, con) {
            return function(event, me) {
                sym.style.color = "red";
                con.style.color = "black";
            }
        }(sym, con);
        sym.onmouseout = con.onmouseout = function(sym, con) {
            return function(event, me) {
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
            onclick: function(id, host) {
                return function(event, me) {
                    console.log(id)
                    blackTheme.reporter_users.removeUser(host, id);
                    DOMElement.cancelEvent(event);
                    return false;
                }
            }(array[i].id, host)
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
        // h.style.marginTop = "-110px";
        // h.style.marginLeft = "-10px";
        celldata.push({
            attrs: {
                style: {
                    width: "40px",
                    textAlign: "center"
                }
            },
            children: [
                DOMElement.i({
                    attrs: {
                        className: "material-icons " + DOMElement.dropdownclass.button,
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
                        onclick: function(host) {
                            return function(event, me) {
                                host.style.top = "80px";
                                host.toggle();
                                if(!jobdescui.elementInViewport(host.childNodes[0]))
                                    {
                                        host.style.top = -host.childNodes[0].clientHeight +"px";
                                    }
                                else{
                                    host.style.top = 0 +"px";
                                }
                                DOMElement.cancelEvent(event);
                                return false;
                            }
                        }(h)
                    },
                    text: "more_vert"
                }), h
            ]
        });
        data.push(celldata);
    }
    return data;
};

blackTheme.reporter_users.removeUser = function(host, id) {
    ModalElement.question({
        title: LanguageModule.text("title_delete_user"),
        message: LanguageModule.text("title_confirm_delete") + "" + data_module.usersListHome.getID(id).username,
        onclick: function(id) {
            return function(selectedindex) {
                switch (selectedindex) {
                    case 0:
                        data_module.usersList.removeOne(id).then(function() {
                            jobdesc.reporter_users_information.redrawTable(host);
                        })
                        break;
                    case 1:
                        // do nothing
                        break;
                }
            }
        }(id)
    });
};

blackTheme.reporter_users.UpdataFunction = function(host,param) {
    if (param !== undefined) {
        var paramEdit = [{
                name: "id",
                value: param.homeid
            },
            {
                name: "fullname",
                value: host.fullname.childNodes[1].value
            },
            {
                name: "email",
                value: host.email.childNodes[1].value
            },
        ];
        
        if (host.Password.childNodes[1].style.display !== "none" && host.Password.childNodes[1].value === host.checkPassword.childNodes[1].value&&host.Password.childNodes[1].value!==""){
            paramEdit.push({
                name: "password",
                value: host.Password.childNodes[1].value
            });
        }
        console.log(paramEdit)
        data_module.usersListHome.updateOne(paramEdit).then(function() {
            var paramEditJD = [
                {
                    name: "id",
                    value: param.id
                },
                {
                    name: "privilege",
                    value: host.AdminTrans.childNodes[1].value + host.AdminAccount.childNodes[1]
                        .value
                },
                {
                    name: "language",
                    value: host.language.childNodes[1].value
                },
                {
                    name: "available",
                    value: host.available.childNodes[1].value
                },
                {
                    name: "comment",
                    value: host.comment.childNodes[1].value
                },
                {
                    name: "theme",
                    value: host.theme.childNodes[1].value
                },
            ];
            data_module.usersList.updateOne(paramEditJD).then(function() {
                if(jobdesc.reporter_users_information.hosts!==undefined)
                {
                    jobdesc.reporter_users_information.redrawTable(host);
                }
            });
        });
    } else {
        if (host.idAccountHome === -1) {
            var dt = new Date();
            var paramEdit = [
                {
                    name: "username",
                    value: host.check.childNodes[1].value
                },
                {
                    name: "fullname",
                    value: host.fullname.childNodes[1].value
                },
                {
                    name: "email",
                    value: host.email.childNodes[1].value
                },
                {
                    name: "privilege",
                    value: 0
                },
                {
                    name: "language",
                    value: "VN"
                },
                {
                    name: "available",
                    value: 1
                },
                {
                    name: "comment",
                    value: ""
                },
                {
                    name: "theme",
                    value: 1
                },
                {
                    name: "t_year",
                    value: dt.getYear(),
                }
            ];
            if (host.Password.childNodes[1].style.display !== "none" && host.Password.childNodes[1].value === host
                .checkPassword.childNodes[1].value){
                    paramEdit.push({
                        name: "password",
                        value: host.Password.childNodes[1].value
                    });
                }
                data_module.usersListHome.addOne(paramEdit).then(function() {
                    var paramEditJD = [{
                            name: "privilege",
                            value: host.AdminTrans.childNodes[1].value + host.AdminAccount.childNodes[1]
                                .value
                        },
                        {
                            name: "language",
                            value: host.language.childNodes[1].value
                        },
                        {
                            name: "available",
                            value: host.available.childNodes[1].value
                        },
                        {
                            name: "comment",
                            value: host.comment.childNodes[1].value
                        },
                        {
                            name: "homeid",
                            value: host.idAccountHome
                        },
                        {
                            name: "id",
                            value: host.idAccountHome
                        },
                        {
                            name: "theme",
                            value: host.theme.childNodes[1].value
                        },
                    ];
                data_module.usersList.addOne(paramEditJD).then(function() {
                    jobdesc.reporter_users_information.redrawTable(host);
                });
            });
        } else {
            var paramEdit = [{
                    name: "id",
                    value: host.idAccountHome
                },
                {
                    name: "fullname",
                    value: host.fullname.childNodes[1].value
                },
                {
                    name: "email",
                    value: host.email.childNodes[1].value
                },
            ];
            if (host.Password.childNodes[1].style.display !== "none" && host.Password.childNodes[1].value === host.checkPassword.childNodes[1].value && host.Password.childNodes[1].value!=="")
                paramEdit.push({
                    name: "password",
                    value: host.Password.childNodes[1].value
                });
            data_module.usersListHome.updateOne(paramEdit).then(function() {
                var paramEditJD = [{
                        name: "privilege",
                        value: host.AdminTrans.childNodes[1].value + host.AdminAccount.childNodes[1]
                            .value
                    },
                    {
                        name: "language",
                        value: host.language.childNodes[1].value
                    },
                    {
                        name: "available",
                        value: host.available.childNodes[1].value
                    },
                    {
                        name: "comment",
                        value: host.comment.childNodes[1].value
                    },
                    {
                        name: "homeid",
                        value: host.idAccountHome
                    },
                    {
                        name: "id",
                        value: host.idAccountHome
                    },
                    {
                        name: "theme",
                        value: host.theme.childNodes[1].value
                    },
                ]
                data_module.usersList.addOne(paramEditJD).then(function() {
                    jobdesc.reporter_users_information.redrawTable(host);
                })
            });
        }

    }
}
</script>
<?php
    }
?>