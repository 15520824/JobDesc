<?php
    include_once "prefix.php";
    include_once "style_categories.php";
    include_once "connection.php";
    include_once "common.php";
    include_once "jsdb.php";
    include_once "jsdom.php";
    include_once "jsdomelement.php";
    include_once "jsencoding.php";
    include_once "jsform_new.php";
    include_once "jsform.php";
    include_once "jsmodalelement.php";
    include_once "jsbootstrap.php";
    include_once "style_kpi.php";
    include_once "menu.php";
    include_once "categories.php";
    include_once "general_information.php";
    include_once "responsibility.php";
    include_once "reporter.php";
    include_once "reporter_information.php";
    include_once "reporter_categories.php";
    include_once "reporter_categories_information.php";
    include_once "reporter_positions.php";
    include_once "reporter_positions_information.php";
    include_once "reporter_tasks.php";
    include_once "reporter_tasks_information.php";
    include_once "reporter_departments.php";
    include_once "reporter_departments_information.php";
    include_once "reporter_users.php";
    include_once "reporter_users_information.php";
    include_once "reporter_positions_libary.php";
    include_once "reporter_positions_libary_information.php";
    include_once "ListButtonCategoriesPosition.php";
    include_once "MenuCategoriesPosition.php";
    include_once "categoriesPosition.php";
    include_once "data_module.php";
    include_once "blackTheme.php";
    include_once "languagemodule.php";
    include_once "jsbutton_071218.php";
    LanguageModule_load("JOB",$prefix."uitext");
        if (isset($_SESSION[$prefixhome."language"])) {
            $LanguageModule_v_defaultcode = $_SESSION[$prefixhome."language"];
        }
    session_start();
    $add =  $_SERVER['REQUEST_URI'];
    $protocal =  isset($_SERVER['HTTPS'])? "https://":"http://";
    $temp = substr($add, 1);
    $temp2 = strpos($temp, "/");
    if (!isset($_SESSION[$prefixhome."userid"])) {
        $x = $_SERVER['SERVER_NAME']."/".substr($temp, 0, $temp2)."?id=".substr($temp,$temp2+1);
        header("Location:".$protocal.$x);
        exit();
    }
    $conn = DatabaseClass::init($host, $username , $password, $dbname);
    $result = $conn->load($prefixCompany."users", "(homeid = ".$_SESSION[$prefixhome."userid"].")", "id");
    if ((count($result) == 0)){
        $_SESSION[$prefix.'jobdesc_user_id'] = 0;
        $x = $_SERVER['SERVER_NAME']."/".substr($temp, 0, $temp2);
        $pfid = 0;
    }
    else {
        $_SESSION[$prefix.'jobdesc_user_id'] = $result[0]['id'];
        $_SESSION[$prefix.'privilege'] = $result[0]['privilege'];
        $x = $_SERVER['SERVER_NAME']."/".substr($temp, 0, $temp2);
    }

?>
    

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- <link rel="icon" href="./images2/logo-bsc2kpi.png" type="image/x-icon"> -->
        <title>JOB DESC</title>
        <script>
            <?php
                include_once "absol/absol_full.php";
                include_once "absol/absol.Component.js";
                $thememode = 1;
                $pageIndex = 0;
            ?>
        </script>

        <script src="./ckeditor/ckeditor.js"></script>
        <script src="./fuzzysort.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="/css/materialdesignicons/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
        <?php
            DOMClass::write_script();
            DOMElementClass::write_script();
            EncodingClass::write_script();
            FormClass::write_script();
            ModalElementClass::write_script();
            BootstrapElementClass::write_script();
            write_common_script();
            write_form_script();
            write_style()
            
        ?>
        <script type="text/javascript">
            var jobdesc = {
                menu: {},
                categories: {},
                generalInformation: {},
                responsibility: {},
                reporter: {},
                reporter_information: {},
                reporter_categories: {},
                reporter_categories_information:{},
                reporter_positions:{},
                reporter_positions_information:{},
                reporter_departments:{},
                reporter_departments_information:{},
                reporter_tasks:{},
                reporter_tasks_information:{},
                reporter_users:{},
                reporter_users_information:{},
                reporter_positions_libary:{},
                reporter_positions_libary_information:{},
                ListButtonCategoriesPosition: {},
                MenuCategoriesPosition: {},
                categoriesPosition: {},
            };
            var blackTheme = {
                reporter: {},
                reporter_categories: {},
                reporter_positions:{},
                reporter_departments:{},
                reporter_tasks:{},
                reporter_users:{},  
                account:{},
                reporter_positions_libary:{},
            };
        </script>
        <?php
            write_data_script();
            LanguageModule_writeJavascript("JOB", $LanguageModule_v_defaultcode);
            write_reporter_script_black();
            write_menu_script();
            write_categories_script();
            write_general_information_script();
            write_responsibility_script();
            write_reporter_script();
            write_reporter_information_script();
            write_reporter_categories_script();
            write_reporter_categories_information_script();
            write_reporter_positions_script();
            write_reporter_positions_information_script();
            write_reporter_tasks_script();
            write_reporter_tasks_information_script();
            write_reporter_departments_script();
            write_reporter_departments_information_script();
            write_reporter_users_script();
            write_reporter_users_information_script();
            write_reporter_positions_libary_script();
            write_reporter_positions_libary_information_script();
            write_ListButtonCategoriesPosition_script();
            write_MenuCategoriesPosition_script();
            write_categoriesPosition_script();
            write_kpi_script();
            write_button_071218_style_black();
        ?>
        <script type="text/javascript">
            function init(){
                var userid = parseInt("<?php if (isset($_SESSION[$prefix.'jobdesc_user_id'])) echo $_SESSION[$prefix.'jobdesc_user_id']; else echo 0; ?>", 10);
                if (userid == 0){
                    ModalElement.alert({
                        message: "Tài khoản không có quyền truy cập ứng dụng này",
                        func: function(){
                            var link = "<?php echo $protocal.$x ?>";
                            location.href = link;
                        },
                        class: "btn btn-primary"
                    });
                    return;
                }
                ModalElement.alert = function (params) {
                    var message = params.message, func = params.func, h;
                    if (message === undefined) message = "";
                    if (func === undefined) func = function () {};
                    h = DOMElement.table({data: [
                        [{attrs: {style: {fontSize: "4px",height: "10px"}}}],
                        [{
                            attrs: {
                                align: "center",
                                style: {
                                    border: "0",
                                    minWidth: "200px"
                                }
                            },
                            text: message
                        }],
                        [{
                            attrs: {
                                style: {
                                    border: "0",
                                    fontSize: "4px",
                                    height: "20px"
                                }
                            }
                        }],
                        [{
                            attrs: {
                                align: "center",
                                style: {
                                    border: "0"
                                }
                            },
                            children: [showButton({
                                sym: DOMElement.i({
                                        attrs: {
                                            className: "material-icons "
                                       },
                                       text: "done",
                                   }),
                                typebutton: 0,
                                onclick: function(func) {
                                    return function (event, me) {
                                        ModalElement.close();
                                        func();
                                    }
                                } (func),
                                text: "OK"
                            })]
                        }]
                    ]});
                    ModalElement.show({
                        bodycontent: h,
                        overflow: params.overflow
                    });
                };

                ModalElement.question = function (params) {
                    var message = params.message,title = params.title, h, func = params.onclick, displaycheckbox = params.displaycheckbox;
                    if (message === undefined) message = "";
                    if (title === undefined) title = "Question";
                    if (func === undefined) func = function(){};
                    if (displaycheckbox === undefined) displaycheckbox = "";
                    var data = [
                        [{attrs: {style: {fontSize: "4px",height: "10px"}}}],
                        [{
                            attrs: {
                                align: "center",
                                style: {
                                    border: "0",
                                    minWidth: "300px",
                                }
                            },
                            text: message
                        }]
                    ];
                    data.push([{
                        attrs: {
                            style: {
                                border: "0",
                                fontSize: "4px",
                                height: "20px"
                            }
                        }
                    }],
                    [{
                        attrs: {
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
                                        align: "center",
                                        style: {
                                            border: "0"
                                        }
                                    },
                                    children: [showButton({
                                        sym: DOMElement.i({
                                            attrs: {
                                                className: "material-icons "
                                           },
                                           text: "done",
                                        }),
                                        typebutton: 0,
                                        onclick: function(func) {
                                            return function (event, me) {
                                                ModalElement.close();
                                                func(0);
                                            }
                                        } (func),
                                        text: "có"
                                    })]
                                },
                                {
                                    attrs: {style: {width: "20px"}}
                                },
                                {
                                    attrs: {
                                        align: "center",
                                        style: {
                                            border: "0"
                                        }
                                    },
                                    children: [showButton({
                                        sym: DOMElement.i({
                                                attrs: {
                                                    className: "material-icons "
                                               },
                                               text: "clear",
                                           }),
                                        typebutton: 0,
                                        onclick: function(func) {
                                            return function (event, me) {
                                                ModalElement.close();
                                                func(1);
                                            }
                                        }(func),
                                        text: "Không"
                                    })]
                                }
                            ]]
                        })]
                    }]);
                    h = DOMElement.table({data: data});
                    ModalElement.showWindow({
                        title: title,
                        bodycontent: h
                    });
                };
                var holder = DOMElement.div({
                    attrs: {
                        className: "bodyFrm"
                    }
                });
                DOMElement.bodyElement.appendChild(DOMElement.div({
                    attrs: {
                        className: "mainFrm",
                        style: {
                            font: "14px Arial"
                        }
                    },
                    children: [holder]
                }));
                jobdesc.menu.init(holder)
                window.listEditor=[];
                CKEDITOR.config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,language,Anchor,Flash,HorizontalRule,Smiley,PageBreak,Iframe,ShowBlocks,About';
                CKEDITOR.config.toolbarGroups = [
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'links' },
                    { name: 'insert' },
                    { name: 'forms' },
                    { name: 'tools' },
                    { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'others' },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                    { name: 'styles' },
                    { name: 'colors' },
                    { name: 'about' }
                ];
                CKEDITOR.config.resize_enabled = false;
                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                window.onresize= function(evt)
                {
                }
            }
        </script>
    </head>
    <body onload="setTimeout('init();',  10);">
    <!-- <?php
                echo '<div style="margin:20px">';
                if (isset($authUrl)){ 
                    //show login url
                    echo '<div align="center">';
                    echo '<h3>Login with Google -- Demo</h3>';
                    echo '<div>Please click login button to connect to Google.</div>';
                    echo '<a class="login" href="' . $authUrl . '">LOGIN</a>';
                    echo '</div>';
                    
                } 
                echo '</div>';
    ?> -->
    </body>
</html>
