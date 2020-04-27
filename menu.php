<?php
    function write_menu_script() {
        global $prefix;
?>


<!-- <?php
require_once './login_google/vendor/autoload.php';
include_once "connection.php";
include_once "prefix.php";
// Lấy những giá trị này từ https://console.google.com
###################################################################
$client_id = '581565119917-8pot7uvm83sfos22dcvfm090jcf5mm4f.apps.googleusercontent.com'; 
$client_secret = 'gV79TL3rdZL5eMKkwjgYoNT7';
$redirect_uri = 'http://lab.daithangminh.vn/home_co/jd/close.php';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
 
$service = new Google_Service_Oauth2($client);
 
// Nếu kết nối thành công, sau đó xử lý thông tin và lưu vào database
 
//Nếu sẵn sàng kết nối, sau đó lưu session với tên access_token
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else { // Ngược lại tạo 1 link để login
    $authUrl = $client->createAuthUrl();
}
?> -->


<script type="text/javascript">
// jobdesc.menu.tabPanel = DOMElement.tabPanel({
//     border: "curved-content",
//     width: "100vw",
//     height: "calc(100vh - 70px)",
//     closebutton: true,
//     onchange: function(index, me , i, a, b) {
//         console.log(index, me , i, a, b);
//         DOMElement.removeAllChildren(document.getElementById("title_page_init"));
//         document.getElementById("title_page_init").appendChild(DOMElement.textNode(jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent.titleText));
//             console.log(index,jobdesc.menu.tabPanel.localData.tabData.selectedIndex);
//             jobdesc.menu.onChange(index);
//     },
//     // onexit: 
// });
jobdesc.menu.tabPanel = absol.buildDom({
    tag:"tabview",
    style:{
        width:"100%",
        height:"calc(100vh - 65px)"
    },
    on:{
        activetab:function(event){
            console.log(event)
            // jobdesc.menu.onChange(index);
        },
        exit:function(event){
            console.log(event)
        }
    }
})


jobdesc.menu.onChange = function (index,selectedIndexMain){
    // if(index===selectedIndexMain||index===jobdesc.menu.tabPanel.localData.tabData.selectedIndex)
    //     return;
    if(selectedIndexMain!==undefined)
    var selectedTabIndex=selectedIndexMain;
    else
    var selectedTabIndex=jobdesc.menu.tabPanel.localData.tabData.selectedIndex;
    jobdesc.menu.tabPanel.localData.tabData.selectedIndex=index;
    
        console.log(selectedTabIndex,jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex],jobdesc.menu.tabPanel.localData.tabData.list)
        if(selectedTabIndex!==undefined&&jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex]===undefined)
        jobdesc.menu.tabPanel.localData.tabData.selectedIndex=selectedTabIndex;
        if(jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex]!==undefined&&jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex].rawcontent.host!==undefined&&jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex].rawcontent.host.bot!==undefined){
            var parentNode=jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex].rawcontent;
                while(parentNode.classList.contains("resetClass")===false)
                {
                    parentNode=parentNode.parentNode;
                }
                console.log(parentNode.style.display,parentNode,"1")
                if(parentNode.style.display==="none")
                {
                    jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex].rawcontent.host.bot.style.display="none";
                }    
                if(parentNode.style.display==="block")
                {
                    jobdesc.menu.tabPanel.localData.tabData.list[selectedTabIndex].rawcontent.host.bot.style.display="block";
                }        
        }
    

        if(jobdesc.menu.tabPanel.localData.tabData.list[index]!==undefined&&jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent.host!==undefined&&jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent.host.bot!==undefined){
            var parentNode=jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent;
                    while(parentNode.classList.contains("resetClass")===false)
                    {
                        parentNode=parentNode.parentNode;
                    }
                    console.log(parentNode.style.display,"2")
                    if(parentNode.style.display==="block")
                    {
                        jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent.host.bot.style.display="block";
                    }
                    if(parentNode.style.display==="none")
                    {
                        jobdesc.menu.tabPanel.localData.tabData.list[index].rawcontent.host.bot.style.display="none";
                    } 
        }
}

jobdesc.menu.hiddenCkeditor = function(host){
    jobdesc.menu.tabPanel.localData.tabData.selectedIndex=jobdesc.menu.tabPanel.localData.tabData.selectedTabIndex;
    console.log(host.bot)
    if(host.bot!==undefined)
    host.bot.style.display="none"; 
}

jobdesc.menu.removeCkeditor = function(host){
    if(host.bot!==undefined)
    {
        if(host.bot.parentNode!==undefined)
        host.bot.parentNode.removeChild(host.bot);
    } 
}

jobdesc.menu.getAccountName = function() {
    // if (absol.cookie.get('userJD') !== undefined)
    //     return JSON.parse(absol.cookie.get('userJD')).familyName + " " + JSON.parse(absol.cookie.get('userJD'))
    //         .givenName;
    return data_module.uk;
}
jobdesc.menu.getAccountImage = function(h1) {
    // var src = "./images/baseline_account_box_black_48dp.png";
    // if (absol.cookie.get('userJD') !== undefined) {
    //     jobdesc.menu.Account = JSON.parse(absol.cookie.get('userJD'));
    //     src = JSON.parse(absol.cookie.get('userJD')).picture;
    // }
    return DOMElement.i({
        attrs: {
            className: "material-icons " + DOMElement.dropdownclass.button,
            style: {
                paddingLeft: "10px",
                fontSize: "40px",
                width: "40px",
                height: "40px",
                cursor: "pointer"
            },
            onclick: function(h1) {
                return function(event, me) {
                    jobdesc.menu.openDialog(h1)
                }
            }(h1)
        },
        text: "account_circle",
    })

}

jobdesc.menu.openDialog = function(h1) {
    h1.toggle();
    DOMElement.cancelEvent(event);
    return false;

    // } else {
    //     var x = window.open(<?php echo json_encode($authUrl); ?>, "_blank", width = 200, height = 100);
    //     jobdescui.waitForAccessToken().then(function(ac) {
    //         console.log(ac);
    //         if (absol.cookie.get('userJD') !== undefined) {
    //             console.log(JSON.parse(absol.cookie.get('userJD')));
    //             jobdesc.menu.AccountImageObject.src = JSON.parse(absol.cookie.get('userJD')).picture;
    //             jobdesc.menu.AccountNameObject.innerHTML = jobdesc.menu.getAccountName();
    //             jobdesc.menu.setAccount().then(function() {
    //                 if (jobdesc.menu.Account !== undefined)
    //                 {
    //                     var promiseAll=[];
    //                     promiseAll.push(data_module.usersDataList.load(jobdesc.menu.Account.id, "Google", true));
    //                     promiseAll.push(data_module.company.load());
    //                     Promise.all(promiseAll).then(
    //                         function() {
    //                             console.log(data_module.usersDataList)
    //                             jobdesc.reporter_information.redrawTable(host);
    //                             console.log(jobdesc.menu.Account.id)
    //                         })
    //                 }

    //             })

    //         }
    //     });
    // }
}

// jobdesc.menu.setAccount = function() {
//     return new Promise(function(resolve, reject) {
//         jobdesc.menu.Account = JSON.parse(absol.cookie.get('userJD'));
//         FormClass.api_call({
//             url: "insert_new_account.php",
//             params: [{
//                     name: "userData",
//                     value: absol.cookie.get('userJD')
//                 },
//                 {
//                     name: "oauth_provider",
//                     value: "Google"
//                 },
//             ],
//             func: (success, message) => {
//                 if (success) {
//                     if (message.substr(0, 2) == "ok") {
//                         message = message.substr(2);
//                         console.log("ok");
//                         resolve();
//                     } else {
//                         ModalElement.alert({
//                             message: message
//                         });
//                         reject();
//                         return;
//                     }
//                 } else {
//                     ModalElement.alert({
//                         message: message
//                     });
//                     reject();
//                     return;
//                 }
//             }
//         })
//     })


// }
jobdesc.menu.showMenuTab = function() {
    var box = document.getElementById("box_menutab");
    if (box.style.visibility == "hidden") {
        box.style.visibility = "visible";
        setTimeout(function() {
            absol.$('body').once('click', function() {
                box.style.visibility = "hidden";
            }, false);
        }, 100);
    } else {
        box.style.visibility = "hidden";
    }
}
jobdesc.menu.logoutAccount = function() {
    FormClass.api_call({
        url: "logout.php",
        params: [],
        func: function(success, message) {
            if (success) {
                if (message.substr(0, 2) == "ok") {
                    window.location.href = window.location.href;
                } else {
                    ModalElement.alert({
                        message: message,
                        class: "button-black-gray"
                    });
                }
            } else {
                ModalElement.alert({
                    message: message,
                    class: "button-black-gray"
                });
            }
        }
    });
    // jobdesc.menu.AccountImageObject.src = "./images/baseline_account_box_black_48dp.png";
    // jobdesc.menu.AccountNameObject.innerHTML = LanguageModule.text("txt_login");
    // jobdesc.menu.Account = undefined;
    // jobdescui.deleteAllCookies();
}

jobdesc.menu.loadPage = function(taskid, data, hostParent) {
    var holder, host, oc;
    var titlepage = document.getElementById("title_page_init");
    // oc = jobdesc.menu.tabPanel.count;
    // holder = DOMElement.div({
    //     attrs: {
    //         style: {
    //             width: "100%",
    //             backgroundColor: "white"
    //         }
    //     }
    // });
    holder = absol.buildDom({
        tag:"tabframe",
        style:{
            backgroundColor: "white"
        }
    })

    switch (taskid) {
        case 1:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name=LanguageModule.text("title_editor");
            jobdesc.menu.tabPanel.addChild(holder);
            // jobdesc.menu.tabPanel.add(LanguageModule.text("title_editor"), holder);
            jobdesc.categories.init(host, 1);
            break;
        case 2:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name = LanguageModule.text("tit_home_quickjd");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.reporter.init(host, 1);
            break;
        case 3:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name=LanguageModule.text("title_group_job");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.reporter_categories.init(host, 1);
            break;
        case 4:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name=LanguageModule.text("title_task_content");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.ListButtonCategoriesPosition.init(host, 1);
            break;
        case 5:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name=LanguageModule.text("title_job");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.reporter_tasks.init(host, 1);
            break;
        case 6:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name=LanguageModule.text("title_organizational_chart");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.reporter_departments.init(host, 1);
            break;
        case 7:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data,
                hostParent: hostParent,
            };
            holder.name = data_module.positionsList.getID(data[0].position).name;
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.categories.init(host, 1);
            break;
        case 8:
            host = {
                holder: holder,
                pagetitle: titlepage,
                direct: 0
            };
            holder.name = LanguageModule.text("txt_personal_profile");
            jobdesc.menu.tabPanel.addChild(holder);
            var promiseAll = [];
            promiseAll.push(data_module.usersListHome.load());
            promiseAll.push(data_module.usersList.load());
            promiseAll.push(data_module.countriesList.load());
            Promise.all(promiseAll).then(function() {
                jobdesc.menu.showProfile(host);
            })
            break;
        case 9:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name = LanguageModule.text("title_system");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.menu.showListUser(host);
            break;
        case 10:
            host = {
                holder: holder,
                pagetitle: titlepage,
                data: data
            };
            holder.name = LanguageModule.text("title_position");
            jobdesc.menu.tabPanel.addChild(holder);
            jobdesc.reporter_positions_libary.init(host, 1);
            break;
        default:
            holder.innerHTML = "under construction (" + taskid + ")";
            break;
    }
    // var tempC=jobdesc.menu.tabPanel.localData.tabData.selectedTabIndex
    // jobdesc.menu.tabPanel.localData.tabData.selectedTabIndex = jobdesc.menu.tabPanel.count - 1;
    // jobdesc.menu.tabPanel.redraw();
    // if (jobdesc.menu.tabPanel.count > oc) jobdesc.menu.tabPanel.selectedIndex = jobdesc.menu.tabPanel.count - 1;
    // jobdesc.menu.onChange(jobdesc.menu.tabPanel.count - 1,tempC);

}

jobdesc.menu.init = function(holder) {
    var h, h1, list1;
    var username;
    var promiseAll=[];
    data_module.company.load().then(function(resolve){
        promiseAll.push(data_module.register.load());
    
    promiseAll.push(data_module.services.load());
    Promise.all(promiseAll).then(function(){
        data_module.register.load().then(function() {
        var privilege = parseInt(
            "<?php if (isset($_SESSION[$prefix.'privilege'])) echo $_SESSION[$prefix.'privilege']; else echo 0; ?>",
            10);
        var child = [];
        if (privilege === 0)
            child = [{
                text: LanguageModule.text("title_description") + " " + LanguageModule
                    .text("title_job"),
                pageIndex: 2
            },
            {
                    text: LanguageModule.text("title_danhmuc"),
                    items: [{
                                    text: LanguageModule.text("title_organizational_chart"),
                                    pageIndex: 6
                            }]
            }
            ]
        else if (privilege === 1)
            child = [{
                    text: LanguageModule.text("title_description") + " " + LanguageModule
                        .text("title_job"),
                    pageIndex: 2
                },
                {
                    text: LanguageModule.text("title_danhmuc"),
                    items: [{
                            text: LanguageModule.text("title_group_job"),
                            pageIndex: 3
                        },
                        {
                            text: LanguageModule.text("title_task_content"),
                            pageIndex: 4
                        },
                        {
                            text: LanguageModule.text("title_job"),
                            pageIndex: 5
                        },
                        {
                            text: LanguageModule.text("title_position"),
                            pageIndex: 10
                        },
                        {
                            text: LanguageModule.text("title_organizational_chart"),
                            pageIndex: 6
                        }
                    ]
                },
            ]
        else
            child = [{
                    text: LanguageModule.text("title_description") + " " + LanguageModule
                        .text("title_job"),
                    pageIndex: 2
                },
                {
                    text: LanguageModule.text("title_danhmuc"),
                    items: [{
                            text: LanguageModule.text("title_group_job"),
                            pageIndex: 3
                        },
                        {
                            text: LanguageModule.text("title_task_content"),
                            pageIndex: 4
                        },
                        {
                            text: LanguageModule.text("title_job"),
                            pageIndex: 5
                        },
                        {
                            text: LanguageModule.text("title_position"),
                            pageIndex: 10
                        },
                        {
                            text: LanguageModule.text("title_organizational_chart"),
                            pageIndex: 6
                        }
                    ]
                },
                {
                    text: LanguageModule.text("title_system"),
                    pageIndex: 9
                }
            ]
        var tabMenu = absol.buildDom({
            tag: 'hmenu',
            style: {
                paddingLeft: "10px"
            },
            props: {
                items: child
            },
            on: {
                press: function(event) {
                    this.activeTab = -1;
                    var item = event.menuItem;
                    if (typeof item.pageIndex == 'number') {
                        jobdesc.menu.loadPage(item.pageIndex);
                    }
                }
            }
        });
        list1 = [{
                symbol: DOMElement.i({
                    attrs: {
                        className: "material-icons",
                        style: {
                            fontSize: "20px",
                        },
                    },
                    text: "person"
                }),
                content: LanguageModule.text("txt_personal_profile"),
                //content: LanguageModule.text("mnu_user_profile"),
                onclick: function() {
                    jobdesc.menu.loadPage(8);
                }
            },
            {
                symbol: DOMElement.i({
                    attrs: {
                        className: "material-icons",
                        style: {
                            fontSize: "20px",
                        },
                    },
                    text: "arrow_forward"
                }),
                content: LanguageModule.text("txt_logout"),
                //content: LanguageModule.text("mnu_log_out"),
                onclick: function(index) {
                    jobdesc.menu.logoutAccount();
                }
            }
        ];
        h1 = DOMElement.choicelist({
            align: "right",
            color2: "#d6d6d6",
            textcolor: "#7a7a7a",
            textcolor2: "black",
            attrs: {},
            list: list1
        });
        // h1.childNodes[0].style.right = "calc(100% + 20px)";
        h1.style.marginTop = "-50px";
        h1.style.marginLeft = "-10px";

        jobdesc.menu.AccountNameObject = DOMElement.span({
            attrs: {
                style: {
                    paddingLeft: "10px",
                    height: "50px",
                    cursor: "pointer"
                },
                innerHTML: jobdesc.menu.getAccountName()
            },
        })

        jobdesc.menu.AccountImageObject = jobdesc.menu.getAccountImage(h1);

        var dataMenuTab1 = [];
        var dataMenuTab2 = [];
        var serviceId,serviceIndex;
        var isLibrary = false;
        var dataMenuTab1, dataMenuTab2;
        var homehref;
        homehref = window.location.origin + "/";
        var homepath = window.location.pathname.substr(1);
        var x0 = homepath.indexOf("/");
        homehref += homepath.substr(0,x0 + 1);
        for (i = 0; i < data_module.register.items.length; i++){
                                serviceId = data_module.register.items[i].serviceid;
                                serviceIndex = jobdescui.getIndexByID(serviceId,data_module.services.items);
                                if ((data_module.services.items[serviceIndex].name == "salary_library") && (data_module.services.items[serviceIndex].prefix == "")) {
                                    isLibrary = true;
                                    continue;
                                }
                                if ((data_module.services.items[i].target == "") && (data_module.services.items[i].prefix == "")) continue;
                                data_module.services.items[serviceIndex].avai = 1;
                                dataMenuTab1.push({
                                    attrs: {
                                        style: {
                                            width: "100%",
                                            textAlign: "center",
                                            paddingTop: "10px",
                                            paddingBottom: "10px",
                                            paddingRight: "10px",
                                            paddingLeft: (i == 0) ? "10px" :""
                                        }
                                    },
                                    children: [DOMElement.div({
                                        attrs: {
                                            style: {
                                                display: "inline-block"
                                            }
                                        },
                                        children: [DOMElement.a({
                                            attrs: {
                                                target: "_blank",
                                                href: homehref + data_module.services.items[serviceIndex].subDNS,
                                                onclick: function(){
                                                    var box = document.getElementById("box_menutab");
                                                    box.style.visibility = "hidden";
                                                }
                                            },
                                            children: [DOMElement.div({
                                                attrs: {
                                                    align: "center",
                                                    style: {
                                                        height: "80px",
                                                        backgroundColor: "#ffffff",
                                                        width: "80px",
                                                        border: "1px solid #c0c0c0",
                                                        display: "table-cell",
                                                        verticalAlign: "middle"
                                                    }
                                                },
                                                children: [DOMElement.img({
                                                    attrs: {
                                                        style: {
                                                            maxHeight: "60px",
                                                            maxWidth: "60px",
                                                            marginLeft:"10px",
                                                            marginRight: "10px",
                                                            cursor: "pointer",
                                                        },
                                                        src: data_module.services.items[serviceIndex].srcimg,
                                                        alt: LanguageModule.text(data_module.services.items[serviceIndex].name)
                                                    }
                                                })]
                                            })]
                                        })]
                                    })]
                                });
                                dataMenuTab2.push({
                                    attrs: {
                                        style: {
                                            textAlign: "center",
                                            cursor: "pointer",
                                            textDecoration: "underline",
                                            whiteSpace: "nowrap",
                                            paddingBottom: "20px"
                                        },
                                        align: "center"
                                    },
                                    children: [DOMElement.a({
                                        attrs: {
                                            style: {color: "black"},
                                            target: "_blank",
                                            href: homehref + data_module.services.items[serviceIndex].subDNS,
                                            onclick: function(){
                                                var box = document.getElementById("box_menutab");
                                                box.style.visibility = "hidden";
                                            }
                                        },
                                        text: LanguageModule.text(data_module.services.items[serviceIndex].name)
                                    })]
                                });
                            }
                            for (i = 0; i < data_module.services.items.length; i++){
                                if ((data_module.services.items[i].name == "salary_library") && (data_module.services.items[i].prefix == "")) continue;
                                if ((data_module.services.items[i].target == "") && (data_module.services.items[i].prefix == "")) continue;
                                if (data_module.services.items[i].avai != 1){
                                    dataMenuTab1.push({
                                        attrs: {
                                            style: {
                                                width: "100%",
                                                textAlign: "center",
                                                paddingTop: "10px",
                                                paddingBottom: "10px",
                                                paddingRight: "10px"
                                            }
                                        },
                                        children: [DOMElement.div({
                                            attrs: {
                                                style: {
                                                    display: "inline-block"
                                                }
                                            },
                                            children: [DOMElement.a({
                                                attrs: {
                                                    //href: homehref + data_module.services.items[i].subDNS,
                                                    onclick: function(){
                                                        var box = document.getElementById("box_menutab");
                                                        box.style.visibility = "hidden";
                                                    }
                                                },
                                                children: [DOMElement.div({
                                                    attrs: {
                                                        align: "center",
                                                        style: {
                                                            verticalAlign: "middle",
                                                            height: "80px",
                                                            width: "80px",
                                                            border: "1px solid #c0c0c0",
                                                            backgroundColor: "rgba(0, 0, 0, 0.3)",
                                                            display: "table-cell"
                                                        }
                                                    },
                                                    children: [DOMElement.img({
                                                        attrs: {
                                                            style: {
                                                                maxHeight: "60px",
                                                                maxWidth: "60px",
                                                                marginLeft:"10px",
                                                                marginRight: "10px",
                                                                cursor: "pointer",
                                                            },
                                                            src: data_module.services.items[i].srcimg,
                                                            alt: LanguageModule.text(data_module.services.items[i].name)
                                                        }
                                                    })]
                                                })]
                                            })]
                                        })]
                                    });
                                    dataMenuTab2.push({
                                        attrs: {
                                            style: {
                                                cursor: "pointer",
                                                textDecoration: "underline",
                                                color: "#7a7a7a",
                                                whiteSpace: "nowrap",
                                                paddingBottom: "20px",
                                                textAlign: "center"
                                            },
                                            onclick: function(){
                                                var box = document.getElementById("box_menutab");
                                                box.style.visibility = "hidden";
                                            }
                                        },
                                        children: [DOMElement.span({
                                            text: LanguageModule.text(data_module.services.items[i].name)
                                        })]
                                    });
                                }
                            }

        DOMElement.removeAllChildren(holder);
        holder.appendChild(
            DOMElement.div({
                attrs: {
                    style: {
                        width: "100%",
                        border: "1px solid #d6d6d6",
                    }
                },
                children: [
                    DOMElement.table({
                        attrs: {
                            width: "100%"
                        },
                        data: [
                            [{
                                    attrs: {
                                        style: {
                                            width: "50px",
                                            textAlign: "center",
                                            height: "10px"
                                        }
                                    },
                                    children: [
                                        DOMElement.i({
                                            attrs: {
                                                className: "material-icons",
                                                style: {
                                                    height: "30px",
                                                    cursor: "pointer",
                                                    paddingRight: "5px",
                                                    color: "black"
                                                },
                                                onclick: function(event, me) {
                                                    jobdesc.menu
                                                        .showMenuTab(
                                                            holder);
                                                }
                                            },
                                            text: "reorder"
                                        })
                                    ]
                                }, DOMElement.div({
                                    attrs: {
                                        style: {
                                            position: "relative",
                                            maxHeight: "200px"
                                        }
                                    },
                                    children: [DOMElement.div({
                                        attrs: {
                                            id: "box_menutab",
                                            style: {
                                                position: "absolute",
                                                zIndex: 1001,
                                                left: "0px",
                                                top: "25px",
                                                backgroundColor: "#ffffff",
                                                border: "1px solid #d6d6d6",
                                                zIndex: "1001",
                                                borderRadius: "3px",
                                                boxShadow: "2.8px 2.8px 12px 0 rgba(7, 7, 7, 1)",
                                                visibility: "hidden"
                                            }
                                        },
                                        children: DOMElement.table({
                                            attrs: {
                                                style: {
                                                    width: "100%",
                                                    cursor: "pointer"
                                                }
                                            },
                                            data: [
                                                dataMenuTab1,
                                                dataMenuTab2
                                            ]
                                        })
                                    })]
                                }),
                                {
                                    attrs: {
                                        style: {
                                            borderLeft: "1px solid #d6d6d6",
                                            height: "50px",
                                            width: "20px"
                                        }
                                    }
                                },
                                {
                                    attrs: {
                                        style: {
                                            textAlign: "center",
                                            paddingTop: "10px",
                                            paddingBottom: "10px",
                                            height: "50px",
                                            width: "30px"
                                        }
                                    },
                                    children: [DOMElement.img({
                                        attrs: {
                                            id: "company_logo_img",
                                            src: "favicon-16x16.png",
                                            style: {
                                                maxHeight: "30px"
                                            }
                                        }
                                    })]
                                },
                                {
                                    attrs: {
                                        style: {
                                            borderRight: "1px solid #d6d6d6",
                                            height: "50px",
                                            width: "20px"
                                        }
                                    }
                                },
                                {
                                    attrs: {
                                        id: "title_page_init",
                                        style: {
                                            color: "black",
                                            font: "16px Helvetica, Arial, sans-serif",
                                            fontWeight: "bold",
                                            whiteSpace: "nowrap",
                                            textAlign: "left",
                                            height: "40px",
                                            verticalAlign: "middle",
                                            paddingLeft: "10px",
                                            display:"none",
                                        }
                                    },
                                    children: [DOMElement
                                        .textNode( /*LanguageModule.text("mnu_scorecard")*/ )
                                    ]
                                },
                                tabMenu,
                                {
                                    attrs: {
                                        style: {
                                            width: "10px"
                                        }
                                    }
                                },
                                {
                                    attrs: {
                                        align: "right",
                                        style: {
                                            width: "208px",
                                            //borderLeft: "1px solid #aaaaaa"
                                        }
                                    },
                                    children: [
                                        DOMElement.table({
                                            attrs: {
                                                align: "left"
                                            },
                                            data: [
                                                [

                                                    {
                                                        attrs: {
                                                            style: {
                                                                paddingRight: "10px",
                                                                height: "50px",
                                                                paddingLeft: "10px",
                                                                borderRight: "1px solid #aaaaaa",
                                                            }
                                                        },
                                                        children: [
                                                            DOMElement
                                                            .i({
                                                                attrs: {
                                                                    className: "material-icons",
                                                                    style: {
                                                                        fontSize: "30px",
                                                                        color: "#ff3823",
                                                                        cursor: "pointer"
                                                                    },
                                                                },

                                                                text: "comment"
                                                            })
                                                        ]
                                                    },
                                                    {
                                                        attrs: {
                                                            style: {
                                                                paddingLeft: "10px",
                                                                height: "50px"
                                                            }
                                                        },
                                                        children: [
                                                            DOMElement
                                                            .img({
                                                                attrs: {
                                                                    style: {
                                                                        maxHeight: "30px",
                                                                        maxWidth: "60px",
                                                                        cursor: "pointer"
                                                                    },
                                                                    onclick: function(
                                                                        event
                                                                    ) {
                                                                        event
                                                                            .preventDefault();
                                                                        if (data_module
                                                                            .company
                                                                            .item
                                                                            .website
                                                                            .substr(
                                                                                0,
                                                                                4
                                                                            ) ==
                                                                            "http"
                                                                        ) {
                                                                            var win =
                                                                                window
                                                                                .open(
                                                                                    data_module
                                                                                    .company
                                                                                    .item
                                                                                    .website,
                                                                                    '_blank'
                                                                                );
                                                                        } else {
                                                                            var win =
                                                                                window
                                                                                .open(
                                                                                    "http://" +
                                                                                    data_module
                                                                                    .company
                                                                                    .item
                                                                                    .website,
                                                                                    '_blank'
                                                                                );
                                                                        }
                                                                        win
                                                                            .focus();
                                                                    },
                                                                    src: (data_module
                                                                            .company
                                                                            .item
                                                                            .logo ==
                                                                            ""
                                                                        ) ?
                                                                        "" :
                                                                        "../company_logo/" +
                                                                        data_module
                                                                        .company
                                                                        .item
                                                                        .logo
                                                                }
                                                            })
                                                        ]
                                                    },
                                                    jobdesc.menu
                                                    .AccountImageObject,
                                                    {
                                                        attrs: {
                                                            style: {
                                                                width: "10px"
                                                            }
                                                        }
                                                    },
                                                    {
                                                        attrs: {
                                                            className: DOMElement
                                                                .dropdownclass
                                                                .button,
                                                            style: {
                                                                marginLeft: "10px",
                                                                cursor: "pointer"
                                                            },
                                                            onclick: function(
                                                                host) {
                                                                return function(
                                                                    event,
                                                                    me
                                                                ) {
                                                                    jobdesc
                                                                        .menu
                                                                        .openDialog(
                                                                            host
                                                                        )
                                                                }
                                                            }(h1)
                                                        },
                                                        children: [
                                                            jobdesc.menu
                                                            .AccountNameObject
                                                        ]
                                                    },
                                                    h1
                                                ]
                                            ]
                                        })
                                    ]
                                }
                            ]
                        ]
                    })
                ]
            })
        );
        holder.appendChild(DOMElement.div({
            attrs: {
                style: {
                    height: "10px",
                    backgroundColor: "#f7f6f6"
                }
            }
        }));
        holder.appendChild(DOMElement.div({
            attrs: {
                style: {
                    backgroundColor: "#f7f6f6",
                }
            },
            children: [jobdesc.menu.tabPanel]
        }));
        jobdesc.menu.loadPage(2);
    });
    })
});
}

jobdesc.menu.showProfile = function(host) {
    var st, ready = 0,
        i, uid, uindex;
    uid = data_module.usersDataList.id;
    uindex = data_module.usersDataList.homeid;
    if (host.direct !== 1) {
        host.password_confirm = DOMElement.input({
            attrs: {
                type: "password",
                className: "KPIsimpleInput",
                style: {
                    width: "200px"
                },
                onkeydown: function(event) {
                    if (event.keyCode == 13) jobdesc.menu.confirmPassword(host);
                }
            }
        });
        host.notification = DOMElement.td({});
        ModalElement.showWindow({
            index: 1,
            title: "Xác nhận mật khẩu",
            bodycontent: DOMElement.table({
                data: [
                    [{}, {}, host.notification],
                    [{
                            attrs: {
                                style: {
                                    whiteSpace: "nowrap"
                                }
                            },
                            text: LanguageModule.text("txt_password")
                        },
                        {
                            attrs: {
                                style: {
                                    width: "10px"
                                }
                            }
                        },
                        host.password_confirm
                    ],
                    [{
                        attrs: {
                            style: {
                                height: "20px"
                            }
                        }
                    }],
                    [{
                        attrs: {
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
                            data: [
                                [{
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [showButton({
                                            sym: DOMElement.i({
                                                attrs: {
                                                    className: "material-icons " +
                                                        DOMElement
                                                        .dropdownclass
                                                        .button
                                                },
                                                text: "done"
                                            }),
                                            typebutton: 0,
                                            onclick: function(
                                                host) {
                                                return function(
                                                    event,
                                                    me
                                                ) {
                                                    jobdesc
                                                        .menu
                                                        .confirmPassword(
                                                            host
                                                        );
                                                }
                                            }(host),
                                            text: LanguageModule
                                                .text("ctrl_ok")
                                        })]
                                    },
                                    {
                                        attrs: {
                                            style: {
                                                width: "20px"
                                            }
                                        }
                                    },
                                    {
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [showButton({
                                            sym: DOMElement.i({
                                                attrs: {
                                                    className: "material-icons " +
                                                        DOMElement
                                                        .dropdownclass
                                                        .button
                                                },
                                                text: "clear"
                                            }),
                                            typebutton: 0,
                                            onclick: function(
                                                event, me) {
                                                ModalElement
                                                    .close();
                                                jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                            },
                                            text: LanguageModule
                                                .text(
                                                    "ctrl_cancel"
                                                )
                                        })]
                                    }
                                ]
                            ]
                        })]
                    }]
                ]
            })
        });
        host.password_confirm.focus();
        return;
    }

    if (uindex == -1) {
        setTimeout("jobdesc.menu.logout();", 100);
        return;
    }
    DOMElement.removeAllChildren(host.holder);
    host.frameList = absol.buildDom({
        tag:'frameview',
        style:{
            width: '100%',
            height: '100%'
        }
    });
    var id = parseInt(
        "<?php if (isset($_SESSION[$prefix.'jobdesc_user_id'])) echo $_SESSION[$prefix.'jobdesc_user_id']; else echo 0; ?>",
        10);
    var mainFrame =jobdescui.formAddUser(host, data_module.usersList.items[jobdescui.getIndexByID(id,data_module.usersList.items)]);
    host.frameList.addChild(mainFrame);
    host.frameList.activeFrame(mainFrame);

}

jobdesc.menu.showListUser = function(host) {

    var st, ready = 0,
        i, uid, uindex;
    uid = data_module.usersDataList.id;
    uindex = data_module.usersDataList.homeid;
    if (host.direct !== 1) {
        host.password_confirm = DOMElement.input({
            attrs: {
                type: "password",
                className: "KPIsimpleInput",
                style: {
                    width: "200px"
                },
                onkeydown: function(event) {
                    if (event.keyCode == 13) jobdesc.menu.confirmPasswordObject(host);
                }
            }
        });
        host.notification = DOMElement.td({});
        ModalElement.showWindow({
            index: 1,
            title: "Xác nhận mật khẩu",
            bodycontent: DOMElement.table({
                data: [
                    [{}, {}, host.notification],
                    [{
                            attrs: {
                                style: {
                                    whiteSpace: "nowrap"
                                }
                            },
                            text: LanguageModule.text("txt_password")
                        },
                        {
                            attrs: {
                                style: {
                                    width: "10px"
                                }
                            }
                        },
                        host.password_confirm
                    ],
                    [{
                        attrs: {
                            style: {
                                height: "20px"
                            }
                        }
                    }],
                    [{
                        attrs: {
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
                            data: [
                                [{
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [showButton({
                                            sym: DOMElement.i({
                                                attrs: {
                                                    className: "material-icons " +
                                                        DOMElement
                                                        .dropdownclass
                                                        .button
                                                },
                                                text: "done"
                                            }),
                                            typebutton: 0,
                                            onclick: function(
                                                host) {
                                                return function(
                                                    event,
                                                    me
                                                ) {
                                                    jobdesc
                                                        .menu
                                                        .confirmPasswordObject(
                                                            host
                                                        );
                                                }
                                            }(host),
                                            text: LanguageModule
                                                .text("ctrl_ok")
                                        })]
                                    },
                                    {
                                        attrs: {
                                            style: {
                                                width: "20px"
                                            }
                                        }
                                    },
                                    {
                                        attrs: {
                                            style: {
                                                border: "0"
                                            }
                                        },
                                        children: [showButton({
                                            sym: DOMElement.i({
                                                attrs: {
                                                    className: "material-icons " +
                                                        DOMElement
                                                        .dropdownclass
                                                        .button
                                                },
                                                text: "clear"
                                            }),
                                            typebutton: 0,
                                            onclick: function(
                                                event, me) {
                                                ModalElement
                                                    .close();
                                                    jobdesc.menu.tabPanel.removeTab(host.holder.id);
                                            },
                                            text: LanguageModule
                                                .text(
                                                    "ctrl_cancel"
                                                )
                                        })]
                                    }
                                ]
                            ]
                        })]
                    }]
                ]
            })
        });
        host.password_confirm.focus();
        return;
    }

    if (uindex == -1) {
        setTimeout("jobdesc.menu.logout();", 100);
        return;
    }
    jobdesc.reporter_users.init(host, 1);
}

jobdesc.menu.confirmPasswordObject = function(host) {
    var pass = host.password_confirm.value.trim();
    if (pass == "") {
        ModalElement.alert({
            message: LanguageModule.text("war_no_password"),
            func: function() {
                host.password_confirm.focus();
            }
        });
        return;
    }
    ModalElement.show_loading();
    FormClass.api_call({
        url: "account_confirm_password.php",
        params: [{
            name: "pass",
            value: pass
        }],
        func: function(success, message) {
            ModalElement.close(-1);
            if (success) {
                if (message == "ok") {
                    ModalElement.close(1);
                    host.direct = 1;
                    jobdesc.menu.showListUser(host);
                } else if (message.substr(0, 6) == "failed") {
                    DOMElement.removeAllChildren(host.notification);
                    host.notification.appendChild(DOMElement.div({
                        attrs: {
                            style: {
                                color: "red",
                                paddingBottom: "5px"
                            }
                        },
                        text: LanguageModule.text("war_txt_password_incorrect")
                    }));
                    host.password_confirm.focus();
                    return;
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
};

jobdesc.menu.confirmPassword = function(host) {
    var pass = host.password_confirm.value.trim();
    if (pass == "") {
        ModalElement.alert({
            message: LanguageModule.text("war_no_password"),
            func: function() {
                host.password_confirm.focus();
            }
        });
        return;
    }
    ModalElement.show_loading();
    FormClass.api_call({
        url: "account_confirm_password.php",
        params: [{
            name: "pass",
            value: pass
        }],
        func: function(success, message) {
            ModalElement.close(-1);
            if (success) {
                if (message == "ok") {
                    ModalElement.close(1);
                    host.direct = 1;
                    jobdesc.menu.showProfile(host);
                } else if (message.substr(0, 6) == "failed") {
                    DOMElement.removeAllChildren(host.notification);
                    host.notification.appendChild(DOMElement.div({
                        attrs: {
                            style: {
                                color: "red",
                                paddingBottom: "5px"
                            }
                        },
                        text: LanguageModule.text("war_txt_password_incorrect")
                    }));
                    host.password_confirm.focus();
                    return;
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
};


jobdesc.menu.footer = function(holder) {
    var ij, listchildren = [];
            for (ij = 0; ij < holder.childNodes.length; ij++){
                listchildren.push(holder.childNodes[ij]);
            }
            DOMElement.removeAllChildren(holder);
            holder.appendChild(
                DOMElement.table({
                    attrs: {style: {width: "100%",height: "30px"}},
                    data: [
                        [{
                            // attrs: {style: {height: "calc(100vh - 140px)",verticalAlign: "top"}},//what?
                            children: listchildren
                        }],
                        [DOMElement.div({
                            attrs: {
                                style: {
                                    backgroundColor: "#f7f6f6",
                                }
                            },
                            children: [DOMElement.table({
                                attrs: {style: {height: "30px",width: "100%"}},
                                data: [[
                                    {attrs: {style: {width: "20px"}}},
                                    {
                                        children: [DOMElement.table({
                                            attrs: {style: {width: "100%"}},
                                            data: [
                                                [{
                                                    attrs: {style: {whiteSpace: "nowrap"}},
                                                    text:"Copyright © 2018, SoftAView Company, All rights reserved"
                                                }]
                                            ]
                                        })]
                                    },
                                    {attrs: {style: {width: "10px"}}},
                                    {
                                        attrs: {align: "right",style: {width: "150px"}},
                                        children: [DOMElement.table({
                                            data: [[
                                                {
                                                    attrs: {style: {whiteSpace: "nowrap"}},
                                                    children: [DOMElement.a({
                                                        attrs:{
                                                            style:{
                                                                cursor: "pointer"
                                                            }
                                                        },
                                                        text: LanguageModule.text("txt_about")
                                                    })]
                                                },
                                                {
                                                    attrs: {style: {whiteSpace: "nowrap",paddingLeft: "10px"}},
                                                    children: [DOMElement.a({
                                                        attrs:{
                                                            style:{
                                                                cursor: "pointer"
                                                            }
                                                        },
                                                        text: LanguageModule.text("txt_contact")
                                                    })]
                                                },
                                                {
                                                    attrs: {style: {whiteSpace: "nowrap",paddingLeft: "10px"}},
                                                    children: [DOMElement.a({
                                                        attrs:{
                                                            style:{
                                                                cursor: "pointer"
                                                            }
                                                        },
                                                        text: LanguageModule.text("txt_service_account")
                                                    })]
                                                }
                                            ]]
                                        })]
                                    },
                                    {attrs: {style: {width: "20px"}}}
                                ]]
                            })]
                        })]
                    ]
                })
            );
}
</script>
<?php
}
?>