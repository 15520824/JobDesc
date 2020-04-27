<?php

$datamodule_script_written = 0;

function write_data_script() {
    global $prefix, $prefixhome, $datamodule_script_written;
    if ($datamodule_script_written != 0) return;
    $datamodule_script_written = 1;
    ?>
<script type="text/javascript">
'use strict';

var data_module = {
    debugMode: true,
    caller: FormClass.queue(4),
    positionsList: {},
    positionsLibaryList: {},
    departmentsList: {},
    countriesList: {},
    taskContentsList: {},
    categoriesList: {},
    tasksList: {},
    usersDataList: {},
    usersList:{},
    usersListHome:{},
    company: {},
    register: {},
    services: {},
    link_position_taskcontent: {},
    uk: <?php
                    if (isset($_SESSION[$prefixhome."username"])) {
                        echo "\"".$_SESSION[$prefixhome."username"]."\",";
                    }
                    else {
                        echo "\"\",";
                    }
                ?>
};
data_module.usersDataList.id=parseInt("<?php if (isset($_SESSION[$prefix.'formTest_user_id'])) echo $_SESSION[$prefix.'formTest_user_id']; else echo 0; ?>", 10);
data_module.usersDataList.homeid=parseInt("<?php if (isset($_SESSION[$prefix.'userid'])) echo $_SESSION[$prefix.'userid']; else echo 0; ?>", 10);
data_module.usersDataList.load = function(id,loadAgain = false) {
    if (data_module.usersDataList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "dataload_users_data.php",
            params: [{
                    name: "id",
                    value: id
                }
            ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        var st = EncodingClass.string.toVariable(message.substr(2));
                        console.log(message.substr(2));
                        var dataString;
                        data_module.usersDataList.items = st;
                        for (var i = 0; i < data_module.usersDataList.items.length; i++) {
                            data_module.usersDataList.items[i].data = JSON.parse(data_module
                                .usersDataList.items[i].data);
                            for (var j = 0; j < data_module.usersDataList.items[i].data
                                .length; j++) {
                                if (data_module.usersDataList.items[i].data[j].data !== undefined) {
                                    dataString = data_module.usersDataList.items[i].data[j].data;
                                    data_module.usersDataList.items[i].data[j].data = JSON.parse(
                                        Base64.decode(dataString));
                                    console.log(JSON.parse(Base64.decode(dataString)))
                                    console.log(dataString)
                                }
                            }
                        }
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersDataList.addOne = function(data,Pos)
{
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_account_task.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.usersDataList.updateAdd(EncodingClass.string.toVariable(
                            message),Pos);
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersDataList.updateAdd = function(data,Pos)
{
    data_module.usersDataList.items[Pos].id=data.id;
    data_module.usersDataList.items[Pos].userID=data.userid;
}

data_module.usersDataList.updateOne = function(data)
{
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_account_task.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.usersDataList.updateEdit(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersDataList.updateEdit = function(data)
{

}

data_module.usersDataList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_account_task.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.usersDataList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.usersDataList.updateRemove = function(id){

}
data_module.usersDataList.getDataFromPositionID  = function(id){
    for(var i=0;i<data_module.usersDataList.items.length;i++)
    {
        if(data_module.usersDataList.items[i].positionid===id)
        return i;
    }
    return -1;
}
data_module.usersList.load = function(loadAgain = false) {
    if (data_module.usersList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_users.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.usersList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })

}

data_module.usersList.getID = function(id,checkAgain=false)
{
    if ((data_module.usersList.checkID === undefined&&!checkAgain)||(data_module.usersList.checkID !== undefined&&checkAgain)) {
        data_module.usersList.checkID = [];
        for (var i = 0; i < data_module.usersList.items.length; i++) {
            data_module.usersList.checkID[data_module.usersList.items[i].id]=i
        }
    }
    return data_module.usersList.items[data_module.usersList.checkID[id]];
}

data_module.usersList.getDataID = function(id,checkAgain=false)
{
    if ((data_module.usersList.checkData === undefined&&!checkAgain)||(data_module.usersList.checkData !== undefined&&checkAgain)) {
        data_module.usersList.checkData = [];
        for (var i = 0; i < data_module.usersDataList.items.length; i++) {
            if (data_module.usersList.checkData[data_module.usersDataList.items[i].id] === undefined)
                data_module.usersList.checkData[data_module.usersDataList.items[i].id] = [];
            data_module.usersList.checkData[data_module.usersDataListt.items[i].id].push(i);
        }
    }
    if(id===-1)
    return undefined;
    if (data_module.usersList.checkData[id] === undefined)
        return [];
    return data_module.usersList.checkData[id];
}

data_module.usersList.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_user.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.usersList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersList.updateAdd =function(data){
    data_module.usersList.items.push(data);
    data_module.usersListHome.checkID[data.id]=data_module.usersList.items.length-1;
    //data_module.usersList.getDataID(-1,true)
}

data_module.usersList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_user.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.usersList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.usersList.updateRemove = function(id){
    data_module.usersList.getID(id);
    data_module.usersList.items.splice(data_module.usersList.checkID[id], 1);
    data_module.usersList.getID(-1,true);
    if(data_module.usersDataList.items!==undefined){
        for(var i=0;i<data_module.usersDataList.items.length;i++)
        {
            if(data_module.usersDataList.items[i].userid===id)
            data_module.usersDataList.items.splice(i--,1);
        }
        formTest.reporter_users_information.redrawTable();
    }
}

data_module.usersList.updateOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_user.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.usersList.updateEdit(EncodingClass.string.toVariable(
                            message));
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersList.updateEdit = function(data)
{
    var temp=Object.assign(data_module.usersList.getID(data.id),data);
    data_module.usersList.items[data_module.usersList.checkID[data.id]]=temp;
}

data_module.usersListHome.load = function(loadAgain = false) {
    if (data_module.usersListHome.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_users_home.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.usersListHome.items = EncodingClass.string.toVariable(message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })

}

data_module.usersListHome.getID = function(id,checkAgain=false)
{
    if ((data_module.usersListHome.checkID === undefined&&!checkAgain)||(data_module.usersListHome.checkID !== undefined&&checkAgain)) {
        data_module.usersListHome.checkID = [];
        for (var i = 0; i < data_module.usersListHome.items.length; i++) {
            data_module.usersListHome.checkID[data_module.usersListHome.items[i].id]=i
        }
    }
    return data_module.usersListHome.items[data_module.usersListHome.checkID[id]];
}

data_module.usersListHome.getName = function(name,checkAgain=false)
{
    if ((data_module.usersListHome.checkName === undefined&&!checkAgain)||(data_module.usersListHome.checkName !== undefined&&checkAgain)) {
        data_module.usersListHome.checkName = [];
        for (var i = 0; i < data_module.usersListHome.items.length; i++) {
            data_module.usersListHome.checkName[data_module.usersListHome.items[i].username]=i
        }
    }
    return data_module.usersListHome.items[data_module.usersListHome.checkName[name]];
}


data_module.usersListHome.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_userHome.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.usersList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersListHome.updateOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_user_home.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.usersListHome.updateEdit(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.usersListHome.updateEdit = function(data)
{
    var temp=Object.assign(data_module.usersListHome.getID(data.id),data);
    data_module.usersListHome.items[data_module.usersListHome.checkID[data.id]]=temp;
}
data_module.usersListHome.getID = function(id,checkAgain=false)
{
    if ((checkAgain===false&&data_module.usersListHome.checkID === undefined)||(checkAgain===true&&data_module.usersListHome.checkID!==undefined)) {
        data_module.usersListHome.checkID = [];
        for (var i = 0; i < data_module.usersListHome.items.length; i++) {
            data_module.usersListHome.checkID[data_module.usersListHome.items[i].id] = i
        }
    }
    if(id===-1)
    return undefined;
    return data_module.usersListHome.items[data_module.usersListHome.checkID[id]];
}

data_module.positionsList.load = function(loadAgain = false) {
    if (data_module.positionsList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_positions.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.positionsList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })

}

data_module.positionsList.getID = function(id,checkAgain=false) {
    if ((checkAgain===false&&data_module.positionsList.checkID === undefined)||(checkAgain===true&&data_module.positionsList.checkID!==undefined)) {
        data_module.positionsList.checkID = [];
        for (var i = 0; i < data_module.positionsList.items.length; i++) {
            data_module.positionsList.checkID[data_module.positionsList.items[i].id] = i
        }
    }
    if(id===-1)
    return undefined;
    if(data_module.positionsList.items[data_module.positionsList.checkID[id]] === undefined)
    id=1;
    return data_module.positionsList.items[data_module.positionsList.checkID[id]];
    
}

data_module.positionsList.getName = function(name,checkAgain=false) {

    if ((data_module.positionsList.checkName === undefined&&checkAgain==false)||(data_module.positionsList.checkName !== undefined&&checkAgain==true)) {
        data_module.positionsList.checkName = [];
        for (var i = 0; i < data_module.positionsList.items.length; i++) {
            data_module.positionsList.checkName[data_module.positionsList.items[i].name] = i;
        }
    }
    if(name!==-1)
    return data_module.positionsList.items[data_module.positionsList.checkName[name]];
    return undefined;
}

data_module.positionsList.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_position.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.positionsList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.positionsList.updateOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_position.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(
                            message))
                        data_module.positionsList.updateEdit(EncodingClass.string.toVariable(
                            message));
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.positionsList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_position.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.positionsList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.positionsList.updateRemove = function(id) {
    data_module.positionsList.items.splice(data_module.positionsList.checkID[id], 1);
    data_module.usersDataList.items.splice(data_module.usersDataList.getDataFromPositionID(id),1);
    data_module.positionsList.getID(-1,true);
    data_module.positionsList.getName(-1,true);
    data_module.departmentsList.getPosition(-1,true);
}

data_module.positionsList.updateAdd = function(data) {
    data_module.positionsList.items.push(data);
    data_module.positionsList.getID(-1,true);
    data_module.positionsList.getName(-1,true);
    data_module.departmentsList.getPosition(-1,true);
}

data_module.positionsList.updateEdit = function(data) {
    var departmentid = data_module.positionsList.items[data_module.positionsList.checkID[data.id]].departmentid;
    for (var i = 0; i < data_module.departmentsList.checkPosition[departmentid].length; i++) {
        if (data_module.departmentsList.checkPosition[departmentid][i] == data.id) {
            data_module.departmentsList.checkPosition[departmentid].splice(i, 1);
            break;
        }
    }
    if(data_module.departmentsList.checkPosition!==undefined)
    data_module.departmentsList.checkPosition[data.departmentid].push(data.id)
    data_module.positionsList.items[data_module.positionsList.checkID[data.id]] = data;


}

data_module.positionsLibaryList.load = function(loadAgain = false) {
    if (data_module.positionsLibaryList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_positions_libary.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.positionsLibaryList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })

}

data_module.positionsLibaryList.getTaskContent = function(id,checkAgain=false) {
    if ((data_module.positionsLibaryList.checkTaskContent === undefined&&!checkAgain)||(data_module.positionsLibaryList.checkTaskContent !== undefined&&checkAgain)) {
        data_module.positionsLibaryList.checkTaskContent = [];
        for (var i = 0; i < data_module.link_position_taskcontent.items.length; i++) {
            if (data_module.positionsLibaryList.checkTaskContent[data_module.link_position_taskcontent.items[i]
                    .positionid] === undefined)
                data_module.positionsLibaryList.checkTaskContent[data_module.link_position_taskcontent.items[i]
                    .positionid] = [];
            data_module.positionsLibaryList.checkTaskContent[data_module.link_position_taskcontent.items[i].positionid]
                .push(data_module.link_position_taskcontent.items[i].taskcontentid);
        }
    }
    if(id===-1)
    return undefined;
    if (data_module.positionsLibaryList.checkTaskContent[id] === undefined)
        return [];
    return data_module.positionsLibaryList.checkTaskContent[id];
}

data_module.positionsLibaryList.getID = function(id,checkAgain=false) {
    if ((checkAgain===false&&data_module.positionsLibaryList.checkID === undefined)||(checkAgain===true&&data_module.positionsLibaryList.checkID!==undefined)) {
        data_module.positionsLibaryList.checkID = [];
        for (var i = 0; i < data_module.positionsLibaryList.items.length; i++) {
            data_module.positionsLibaryList.checkID[data_module.positionsLibaryList.items[i].id] = i
        }
    }
    if(id===-1)
    return undefined;
    return data_module.positionsLibaryList.items[data_module.positionsLibaryList.checkID[id]];
    
}

data_module.positionsLibaryList.getName = function(name,checkAgain=false) {

    if ((data_module.positionsLibaryList.checkName === undefined&&checkAgain==false)||(data_module.positionsLibaryList.checkName !== undefined&&checkAgain==true)) {
        data_module.positionsLibaryList.checkName = [];
        for (var i = 0; i < data_module.positionsLibaryList.items.length; i++) {
            data_module.positionsLibaryList.checkName[data_module.positionsLibaryList.items[i].name] = i;
        }
    }
    if(name!==-1)
    return data_module.positionsLibaryList.items[data_module.positionsLibaryList.checkName[name]];
    return undefined;
}

data_module.positionsLibaryList.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_position_libary.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.positionsLibaryList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.positionsLibaryList.updateOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_position_libary.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(
                            message))
                        data_module.positionsLibaryList.updateEdit(EncodingClass.string.toVariable(
                            message));
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.positionsLibaryList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_position_libary.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.positionsLibaryList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.positionsLibaryList.updateRemove = function(id) {
    data_module.positionsLibaryList.items.splice(data_module.positionsLibaryList.checkID[id], 1);
    data_module.positionsLibaryList.getID(-1,true);
    data_module.positionsLibaryList.getName(-1,true);
    
    var isContain=false;
    absol.$('selectbox', false, e=>{
        var temp=[];
        for(var i=0;i<e.values.length;i++)
            if(e.values[i]!==id)
                temp.push(e.values[i])
            else
            isContain = true;
        e.values=temp;
        temp=[];
        for(var i=0;i<e.items.length;i++)
            if(e.items[i].value!==id){
                temp.push(e.items[i])
            }
                e.items = temp;
        
    })
    console.log(isContain)
    if(isContain&&data_module.taskContentsList.items!==undefined)
    for(var i=0;i<data_module.taskContentsList.hosts.length;i++)
        blackTheme.reporter.removePositionsAll(data_module.taskContentsList.hosts[i],id)

    data_module.positionsLibaryList.getTaskContent(-1,true);
    data_module.taskContentsList.getPosition(-1,true);
    
    
    
}

data_module.positionsLibaryList.updateAdd = function(data) {
    data_module.positionsLibaryList.items.push(data);
    data_module.positionsLibaryList.getID(-1,true);
    data_module.positionsLibaryList.getName(-1,true);
    absol.$('selectbox', false, e=>{
        e.items.push({
                    text: data.name,
                    value:data.id,
                });
        e.items = e.items.slice(0)
    })
}

data_module.positionsLibaryList.updateEdit = function(data) {
    data_module.positionsLibaryList.getID(0);
    data_module.positionsLibaryList.items[data_module.positionsLibaryList.checkID[data.id]] = data;

    absol.$('selectbox', false, e=>{
        for(var i=0;i<e.items.length;i++)
            if(e.items[i].value===data.id){
                e.items[i].text=data.name;
                break;
            }
        var temp=e.items.slice(0);
        e.items=[];
        e.items=temp;
        e.values=e.values.slice(0);
    })

}

data_module.countriesList.load = function(loadAgain = false) {
    if (data_module.countriesList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_countries.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.countriesList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })

}

data_module.countriesList.getID = function(id,checkAgain=false) {
    if ((data_module.countriesList.checkID === undefined&&checkAgain===false)||(data_module.countriesList.checkID !== undefined&&checkAgain===true)) {
        data_module.countriesList.checkID = [];
        for (var i = 0; i < data_module.countriesList.items.length; i++) {
            data_module.countriesList.checkID[data_module.countriesList.items[i].id] = i;
        }
    }
    if(id!==-1)
    return data_module.countriesList.items[data_module.countriesList.checkID[id]];
    else
    return undefined;
}

data_module.departmentsList.load = function(loadAgain = false) {
    if (data_module.departmentsList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_departments.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.departmentsList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.departmentsList.getID = function(id,checkAgain=false) {
    if ((data_module.departmentsList.checkID === undefined&&checkAgain===false)||(data_module.departmentsList.checkID !== undefined&&checkAgain===true)) {
        data_module.departmentsList.checkID = [];
        for (var i = 0; i < data_module.departmentsList.items.length; i++) {
            data_module.departmentsList.checkID[data_module.departmentsList.items[i].id] = i;
        }
    }
    if(id!==-1)
    return data_module.departmentsList.items[data_module.departmentsList.checkID[id]];
    else
    return undefined;
}

data_module.departmentsList.getPosition = function(id, checkAgain = false) {
    if (data_module.departmentsList.checkPosition === undefined || checkAgain === true) {
        data_module.departmentsList.checkPosition = [];
        for (var i = 0; i < data_module.positionsList.items.length; i++) {
            if (data_module.departmentsList.checkPosition[data_module.positionsList.items[i].departmentid] ===
                undefined)
                data_module.departmentsList.checkPosition[data_module.positionsList.items[i].departmentid] = [];
            data_module.departmentsList.checkPosition[data_module.positionsList.items[i].departmentid].push(
                data_module.positionsList.items[i].id);
        }
    }
    if (data_module.departmentsList.checkPosition[id] === undefined)
        data_module.departmentsList.checkPosition[id] = []
    return data_module.departmentsList.checkPosition[id];
};

data_module.departmentsList.getChildren = function(id,checkAgain=false)
{
    if(data_module.departmentsList.checkChildren===undefined||checkAgain===true)
    {
        data_module.departmentsList.checkChildren=[];
        for(var i=0;i<data_module.departmentsList.items.length;i++)
        {
            if(data_module.departmentsList.checkChildren[data_module.departmentsList.items[i].parentid]===undefined)
            {
                data_module.departmentsList.checkChildren[data_module.departmentsList.items[i].parentid]=[];
            }
            data_module.departmentsList.checkChildren[data_module.departmentsList.items[i].parentid].push(data_module.departmentsList.items[i].id);
        }
    }
    if(data_module.departmentsList.checkChildren[id]===undefined)
        data_module.departmentsList.checkChildren[id]=[]
    return data_module.departmentsList.checkChildren[id];
}

data_module.departmentsList.addOne = function(host, data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_department.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok")
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.departmentsList.updateDataAdd(host, EncodingClass.string
                            .toVariable(message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.departmentsList.updateOne = function(host, data, index) {
    console.log(data)
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_department.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok")
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.departmentsList.updateDataEdit(host, EncodingClass.string
                            .toVariable(message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.departmentsList.removeOne = function(host, id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_department.php",
            params: [{
                name: "id",
                value: id
            }],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok")
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.departmentsList.updateDataRemove(host, EncodingClass.string
                            .toVariable(message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.departmentsList.updateDataAdd = function(host, data) {
    data_module.departmentsList.items.push(data);
    data_module.departmentsList.getID(-1,true);
    data_module.departmentsList.getPosition(-1,true);
    data_module.departmentsList.getChildren(-1,true);
}

data_module.departmentsList.updateDataEdit = function(host, data) {
    data_module.departmentsList.items[data_module.departmentsList.checkID[data.id]] = data;
    data_module.departmentsList.getChildren(-1,true);
}

data_module.departmentsList.updateDataRemove = function(host, data) {
    data_module.departmentsList.items.splice(data_module.departmentsList.checkID[data.id], 1);
    data_module.departmentsList.getID(-1,true);
    data_module.departmentsList.getPosition(-1,true);
    data_module.departmentsList.getChildren(-1,true);
}

data_module.taskContentsList.load = function(loadAgain = false) {
    if (data_module.taskContentsList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_task_content.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.taskContentsList.items = EncodingClass.string.toVariable(
                            message);
                        if(data_module.taskContentsList.hosts===undefined)
                        data_module.taskContentsList.hosts=[];
                        data_module.taskContentsList.items.sort(data_module.taskContentsList
                            .compare);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.taskContentsList.compare = function(a, b) {
    // Dùng toUpperCase() để không phân biệt ký tự hoa thường
    const genreA = a.content.toUpperCase();
    const genreB = b.content.toUpperCase();

    var comparison = 0;
    if (genreA > genreB) {
        comparison = 1;
    } else if (genreA < genreB) {
        comparison = -1;
    }
    return comparison;
}

data_module.taskContentsList.getID = function(id,checkAgain=false) {
    if ((data_module.taskContentsList.checkID === undefined&&checkAgain===false)||(data_module.taskContentsList.checkID !== undefined&&checkAgain===false)) {
        data_module.taskContentsList.checkID = [];
        for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
            data_module.taskContentsList.checkID[data_module.taskContentsList.items[i].id] = i;
        }
    }
    if(id!==-1)
    return data_module.taskContentsList.items[data_module.taskContentsList.checkID[id]];
    else
    return undefined;
}

data_module.taskContentsList.getName = function(name,checkAgain=false) {
    if ((data_module.taskContentsList.checkName === undefined&&checkAgain===false)||(data_module.taskContentsList.checkName !== undefined&&checkAgain===true)) {
        data_module.taskContentsList.checkName = [];
        for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
            data_module.taskContentsList.checkName[data_module.taskContentsList.items[i].content] = i
        }
    }
    if(name===-1)
    return undefined;
    return data_module.taskContentsList.items[data_module.taskContentsList.checkName[name]];
}

data_module.taskContentsList.getPosition = function(id,checkAgain=false) {
    if ((data_module.taskContentsList.checkPosition === undefined&&checkAgain===false)||(data_module.taskContentsList.checkPosition !== undefined&&checkAgain===true&&data_module.link_position_taskcontent.items!==undefined)) {
        data_module.taskContentsList.checkPosition = [];
        for (var i = 0; i < data_module.link_position_taskcontent.items.length; i++) {
            if (data_module.taskContentsList.checkPosition[data_module.link_position_taskcontent.items[i]
                    .taskcontentid] === undefined)
                data_module.taskContentsList.checkPosition[data_module.link_position_taskcontent.items[i]
                    .taskcontentid] = [];
            data_module.taskContentsList.checkPosition[data_module.link_position_taskcontent.items[i].taskcontentid]
                .push(data_module.link_position_taskcontent.items[i].positionid);
        }
    }
    if (id===-1||data_module.taskContentsList.checkPosition[id] === undefined)
        return [];
    return data_module.taskContentsList.checkPosition[id];
    // })
}

data_module.taskContentsList.setNewLink = function(data) {
    if (data_module.taskContentsList.checkPosition !== undefined && data.length >= 1)
        data_module.taskContentsList.checkPosition[data[0].taskcontentid] = [];
    for (var i = 0; i < data.length; i++) {
        data[i].taskcontentid = Number(data[i].taskcontentid);
        data_module.taskContentsList.checkPosition[data[i].taskcontentid].push(data[i].positionid);
        if (data_module.positionsLibaryList.checkTaskContent !== undefined) {
            if (data_module.positionsLibaryList.checkTaskContent[data[i].positionid] === undefined)
                data_module.positionsLibaryList.checkTaskContent[data[i].positionid] = [];
            data_module.positionsLibaryList.checkTaskContent[data[i].positionid].push(data[i].taskcontentid);
        }
        data_module.link_position_taskcontent.items.push(data[i]);
    }
    if (i >= 1)
        data_module.link_position_taskcontent.getIDformParam(data[i - 1].positionid, data[i - 1].taskcontentid,
            true)
}

data_module.taskContentsList.deleteTargetPosition = function(id, data) {
    for (var i = 0; i < data.length; i++) {
        data[i] = Number(data[i]);
        if (data_module.taskContentsList.checkPosition !== undefined) {
            delete data_module.taskContentsList.checkPosition[id];
        }
        if (data_module.positionsLibaryList.checkTaskContent !== undefined) {
            if (data_module.positionsLibaryList.checkTaskContent[data[i]] !== undefined)
                for (var j = 0; j < data_module.positionsLibaryList.checkTaskContent[data[i]].length; j++)
                    if (data_module.positionsLibaryList.checkTaskContent[data[i]][j] === id) {
                        data_module.positionsLibaryList.checkTaskContent[data[i]].splice(j, 1);
                        break;
                    }
        }
        if (data_module.link_position_taskcontent.getIDformParam(data[i], id) !== undefined)
            data_module.link_position_taskcontent.items.splice(data_module.link_position_taskcontent
                .checkIDformParam[data[i], id], 1);
    }
}

data_module.taskContentsList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_task_content.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.taskContentsList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.taskContentsList.updateRemove = function(id,host) {
    data_module.taskContentsList.items.splice(data_module.taskContentsList.checkID[id], 1);
    data_module.taskContentsList.getID(-1,true);
    data_module.taskContentsList.getPosition(-1,true);
    data_module.taskContentsList.getName(-1,true)

}

data_module.taskContentsList.updateContent = function(host, data) {
    console.log(data)
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_task_content.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok")
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.taskContentsList.updateData(host, EncodingClass.string
                            .toVariable(message));
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.taskContentsList.updateData = function(host, data) {
    var selected;
    if (data_module.taskContentsList.getID(data.id) === undefined) {
        if(data_module.taskContentsList.checkPosition!==undefined)
        data_module.taskContentsList.checkPosition[data.id] = data.position.map(function(u) {
            return u.position;
        });
        if (data_module.positionsLibaryList.checkTaskContent !== undefined)
            for (var i = 0; i < data.position.length; i++) {
                if (data_module.positionsLibaryList.checkTaskContent[data.position[i].positionid] === undefined)
                    data_module.positionsLibaryList.checkTaskContent[data.position[i].positionid] = [];
                data_module.positionsLibaryList.checkTaskContent[data.position[i].positionid].push(data.id);
            }

        var temp = {};
        var view;
        temp.id = data.id
        temp.taskid = Number(data.taskid);
        temp.content = data.content;
        temp.ver = 1;
        temp.position = data_module.taskContentsList.getPosition(temp.id);



        for (var i = -1; i < data_module.taskContentsList.items.length; i++) {
            if ((data_module.taskContentsList.items[i] === undefined || data_module.taskContentsList.items[i]
                    .content.toUpperCase() <= temp.content.toUpperCase()) && (data_module.taskContentsList.items[i + 1] === undefined ||
                    data_module.taskContentsList.items[i + 1].content.toUpperCase() >= data.content.toUpperCase())) {
                selected = i + 1;

                for (var j = 0; j < data_module.taskContentsList.hosts.length; j++) {
                    console.log(data_module.taskContentsList.hosts[j].type,data_module.taskContentsList.hosts[j].type == "preview")
                    if (data_module.taskContentsList.hosts[j].type == "preview")
                        view = formTestui.spanIcon(data_module.taskContentsList.hosts[j], temp.content, "file_copy", "lv-item", temp.content, temp
                            .taskid);
                    else {
                        view = formTestui.spanIconList(data_module.taskContentsList.hosts[j], temp.content, "more_vert", "lv-item", temp);
                        view.id=temp.id;
                        if(data_module.taskContentsList.hosts[j]===host){
                            if (host.me !== undefined)
                            host.me.classList.remove("choice");
                            host.me = view;
                            host.me.classList.add("choice");
                            host.me.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                        }
                    }
                    if (data_module.taskContentsList.items[i + 1] === undefined) {
                        selected = i;
                        data_module.taskContentsList.hosts[j].views.childNodes[i].parentNode.appendChild(view);
                    } else {
                        data_module.taskContentsList.hosts[j].views.childNodes[i + 1].parentNode.insertBefore(
                            view,
                            data_module.taskContentsList.hosts[j].views.childNodes[i + 1]
                        )
                    }
                }


            data_module.taskContentsList.items.splice(i + 1, 0, temp);
            data_module.taskContentsList.getID(-1,true)
            data_module.taskContentsList.getName(-1,true)
            
            break;
        }
    }
    data_module.taskContentsList.setNewLink(data.position)
    for (var i = 0; i < data_module.taskContentsList.hosts.length; i++)
        //updateSearch
        blackTheme.reporter.updatePosition(data_module.taskContentsList.hosts[i], data_module.taskContentsList
            .hosts[i].views.childNodes[selected], temp);
        data_module.tasksList.getID(-1,true);
        data_module.tasksList.getName(-1,true);
        data_module.tasksList.getTaskContent(-1,true);
} else {
    data.id = Number(data.id);
    data.taskid = Number(data.taskid);
    for (var i = -1; i < data_module.taskContentsList.items.length; i++) {
        if ((data_module.taskContentsList.items[i] === undefined || data_module.taskContentsList.items[i]
                .content.toUpperCase() <= data.content.toUpperCase()) && (data_module.taskContentsList.items[i + 1] === undefined ||
                data_module.taskContentsList.items[i + 1].content.toUpperCase() >= data.content.toUpperCase())) {
            selected = i + 1;
            data_module.taskContentsList.getID(data.id).content = data.content;
            for (var j = 0; j < data_module.taskContentsList.hosts.length; j++){
                if(data_module.taskContentsList.hosts[j]===host){
                    host.me.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
                }
                data_module.taskContentsList.hosts[j].views.childNodes[data_module.taskContentsList.checkID[data.id]].childNodes[0].innerHTML = "<span>" + data.content.replace(/^\s+|\s+$/g, '') + "</span>";
                if (data_module.taskContentsList.items[i + 1] === undefined) {
                    selected = i;
                    for (var j = 0; j < data_module.taskContentsList.hosts.length; j++)
                        data_module.taskContentsList.hosts[j].views.childNodes[i].parentNode.appendChild(
                            data_module.taskContentsList.hosts[j].views.childNodes[data_module.taskContentsList
                                .checkID[data.id]]);
                } else {
                    data_module.taskContentsList.hosts[j].views.childNodes[i + 1].parentNode.insertBefore(
                        data_module.taskContentsList.hosts[j].views.childNodes[data_module.taskContentsList
                            .checkID[data.id]],
                        data_module.taskContentsList.hosts[j].views.childNodes[i + 1]
                    )
                }
        }
                var j=data_module.taskContentsList.checkID[data.id];
                    if(i+1<j)
                        {
                            var temp=data_module.taskContentsList.items[j]
                            for(var k=j-1;k>i+1;k--)
                            {
                                data_module.taskContentsList.items[k+1]=data_module.taskContentsList.items[k];
                            }
                            data_module.taskContentsList.items[i+1]=temp;
                        }
                        else if(i+1>j)  {
                            var temp=data_module.taskContentsList.items[j]
                            for(var k=j;k<i+1;k++)
                            {
                                data_module.taskContentsList.items[k]=data_module.taskContentsList.items[k+1];
                            }
                            data_module.taskContentsList.items[i]=temp;
                        }
                    // data_module.taskContentsList.items.splice(i + 1, 0, data_module.taskContentsList.items[j]);
                    // data_module.taskContentsList.items.splice(j, 1);
                    data_module.taskContentsList.getID(-1,true)
                    data_module.taskContentsList.getName(-1,true)

            break;
        }
    }
    data_module.taskContentsList.getID(data.id).taskid = data.taskid;
    data_module.taskContentsList.deleteTargetPosition(data.id, data_module.taskContentsList.getPosition(data.id));
    data_module.taskContentsList.setNewLink(data.position);
    for (var i = 0; i < data_module.taskContentsList.hosts.length; i++)
        blackTheme.reporter.updatePosition(data_module.taskContentsList.hosts[i], data_module.taskContentsList
            .hosts[i].views.childNodes[selected], data);
        data_module.tasksList.getID(-1,true);
    data_module.tasksList.getName(-1,true);
    data_module.tasksList.getTaskContent(-1,true)
}
}


data_module.taskContentsList.addOne = function(host, data) {

    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_taskcontent.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok")
                        console.log(EncodingClass.string.toVariable(message));
                        data_module.taskContentsList.updateData(host, EncodingClass.string
                            .toVariable(message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.categoriesList.load = function(loadAgain = false) {
    if (data_module.categoriesList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_categories.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.categoriesList.items = EncodingClass.string.toVariable(
                            message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.categoriesList.getID = function(id,checkAgain=false) {
    if ((data_module.categoriesList.checkID === undefined&&checkAgain===false)||(data_module.categoriesList.checkID !== undefined&&checkAgain===true)) {
        data_module.categoriesList.checkID = [];
        for (var i = 0; i < data_module.categoriesList.items.length; i++) {
            data_module.categoriesList.checkID[data_module.categoriesList.items[i].id] = i
        }
    }
    if(id!==-1)
    return data_module.categoriesList.items[data_module.categoriesList.checkID[id]];
    else
    return undefined;
}



data_module.categoriesList.removeOne = function(id) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_category.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.categoriesList.updateRemove(id);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.categoriesList.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_category.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.categoriesList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.categoriesList.updateOne = function(data, index) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_category.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.categoriesList.updateEdit(EncodingClass.string.toVariable(message), index);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.categoriesList.updateAdd = function(data) {
    data_module.categoriesList.items.push(data);
    if (data_module.categoriesList.checkID !== undefined)
        data_module.categoriesList.checkID[data.id] = data_module.categoriesList.items.length-1;
}

data_module.categoriesList.updateEdit = function(data, index) {
    data_module.categoriesList.items[index]=data
}

data_module.categoriesList.updateRemove = function(id) {
    data_module.categoriesList.items.splice(data_module.categoriesList.checkID[id], 1);
    data_module.categoriesList.getID(-1,true)
}

data_module.tasksList.load = function(loadAgain = false) {
    if (data_module.tasksList.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_tasks.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.tasksList.items = EncodingClass.string.toVariable(message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.tasksList.getID = function(id,checkAgain=false) {
    if ((data_module.tasksList.checkID === undefined&&checkAgain===false)||(data_module.tasksList.checkID !== undefined&&checkAgain===true)) {
        data_module.tasksList.checkID = [];
        for (var i = 0; i < data_module.tasksList.items.length; i++) {
            data_module.tasksList.checkID[data_module.tasksList.items[i].id] = i;
        }
    }
    if(id===-1)
    return undefined
    return data_module.tasksList.items[data_module.tasksList.checkID[id]];
}

data_module.tasksList.getName = function(name,checkAgain=false) {
    if ((data_module.tasksList.checkName === undefined&&checkAgain===false)||(data_module.tasksList.checkName !== undefined&&checkAgain===true)) {
        data_module.tasksList.checkName = [];
        for (var i = 0; i < data_module.tasksList.items.length; i++) {
            data_module.tasksList.checkName[data_module.tasksList.items[i].name] = data_module.tasksList.items[i];
            data_module.tasksList.checkName[data_module.tasksList.items[i].name].STT = i;
        }
    }
    if(name===-1)
    return undefined
    return data_module.tasksList.checkName[name];
}

data_module.tasksList.getTaskContent = function(id,checkAgain=false) {
    if ((data_module.tasksList.checkTaskContent === undefined&&checkAgain===false)||(data_module.tasksList.checkTaskContent !== undefined&&checkAgain===true&&data_module.taskContentsList.items!==undefined)) {
        data_module.tasksList.checkTaskContent = [];
        for (var i = 0; i < data_module.taskContentsList.items.length; i++) {
            if(data_module.tasksList.checkTaskContent[data_module.taskContentsList.items[i].taskid]===undefined)
            data_module.tasksList.checkTaskContent[data_module.taskContentsList.items[i].taskid]=[]
            data_module.tasksList.checkTaskContent[data_module.taskContentsList.items[i].taskid].push(data_module.taskContentsList.items[i].id);
        }
    }
    if(id===-1)
    return undefined
    return data_module.tasksList.checkTaskContent[id];
}

data_module.tasksList.removeOne = function(id,host) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "delete_task.php",
            params: [{
                name: "id",
                value: id
            }, ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.tasksList.updateRemove(id,host);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.tasksList.addOne = function(data) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "insert_new_task.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log("ok", message);
                        data_module.tasksList.updateAdd(EncodingClass.string.toVariable(
                            message));
                        resolve(EncodingClass.string.toVariable(message));
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}


data_module.tasksList.updateOne = function(data,index) {
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "update_task.php",
            params: data,
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        console.log(EncodingClass.string.toVariable(
                            message))
                        data_module.tasksList.updateEdit(EncodingClass.string.toVariable(
                            message),index);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })

    })
}

data_module.tasksList.updateAdd = function(data) {
    data_module.tasksList.items.push(data);
    if (data_module.tasksList.checkID !== undefined)
        data_module.tasksList.checkID[data.id] = data_module.tasksList.items.length-1;
    if (data_module.tasksList.checkName !== undefined)
        data_module.tasksList.checkName[data.name] = data_module.tasksList.items.length-1;
    if(data_module.tasksList.checkTaskContent!==undefined)
    data_module.tasksList.getTaskContent(-1,true);
}

data_module.tasksList.updateEdit = function(data,index){
    data_module.tasksList.items[index]=data;
}

data_module.tasksList.updateRemove = function(id,host) {
    if(data_module.taskContentsList.items!==undefined)
    for(var i=0;i<data_module.tasksList.getTaskContent(id).length;i++)
    {   
        data_module.taskContentsList.updateRemove(data_module.tasksList.getTaskContent(id)[i],host);
    }
    data_module.tasksList.items.splice(data_module.tasksList.checkID[id], 1);
    data_module.tasksList.getID(-1,true);
    data_module.tasksList.getName(-1,true);
    data_module.tasksList.getTaskContent(-1,true);
    
}

data_module.link_position_taskcontent.load = function(loadAgain = false) {
    if (data_module.link_position_taskcontent.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_link_position_taskcontent.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.link_position_taskcontent.items = EncodingClass.string
                            .toVariable(message);
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}
data_module.link_position_taskcontent.getIDformParam = function(positionid, taskcontentid, isCheck = false) {
    if (data_module.link_position_taskcontent.checkIDformParam === undefined || isCheck) {
        data_module.link_position_taskcontent.checkIDformParam = [];
        for (var i = 0; i < data_module.link_position_taskcontent.items.length; i++) {
            if (data_module.link_position_taskcontent.checkIDformParam[data_module.link_position_taskcontent.items[i].positionid] === undefined)
                data_module.link_position_taskcontent.checkIDformParam[data_module.link_position_taskcontent.items[i].positionid] = [];
            data_module.link_position_taskcontent.checkIDformParam[data_module.link_position_taskcontent.items[i].positionid][data_module.link_position_taskcontent.items[i].taskcontentid] = i;
        }
    }
    if(data_module.link_position_taskcontent.checkIDformParam[positionid]===undefined)
        data_module.link_position_taskcontent.checkIDformParam[positionid]=[];
    return data_module.link_position_taskcontent[data_module.link_position_taskcontent.checkIDformParam[positionid][taskcontentid]];
}

data_module.company.load = function(loadAgain = false) {
    if (data_module.company.item && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_company.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        var temp = EncodingClass.string
                            .toVariable(message);
                        temp = temp[0];
                        data_module.company.item = temp;
                        data_module.company.item.nameCompany = temp.name;
                        temp = EncodingClass.string.toVariable(temp.config);
                        data_module.company.item.address = temp.address;
                        data_module.company.item.email = temp.email;
                        data_module.company.item.logo = temp.logo;
                        data_module.company.item.webSite = temp.website;
                        data_module.company.item.ver = temp.ver;
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.services.load = function(loadAgain = false) {
    if (data_module.services.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_service.php",
            params: [],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        var temp = EncodingClass.string
                            .toVariable(message);
                        data_module.services.items = temp;
                        for (var i = 0; i < data_module.services.items.length; i++){
                            switch (data_module.services.items[i].name) {
                                case "tit_home_bsc":
                                    data_module.services.items[i].subDNS = "bsc";
                                    data_module.services.items[i].srcimg = "../logo-bsc-1511.png";
                                    data_module.services.items[i].srclink = "http://www.bsc2kpi.com";
                                    break;
                                case "tit_home_card":
                                    data_module.services.items[i].subDNS = "carddone";
                                    data_module.services.items[i].srcimg = "../logo-card-15-11.png";
                                    data_module.services.items[i].srclink = "http://www.bsc2kpi.com";
                                    break;
                                case "tit_home_salary":
                                    data_module.services.items[i].subDNS = "salary";
                                    data_module.services.items[i].srcimg = "../logo-salarytek-1511.png";
                                    data_module.services.items[i].srclink = "http://www.salarytek.com";
                                    break;
                                case "tit_home_quickjd":
                                    data_module.services.items[i].subDNS = "jd";
                                    data_module.services.items[i].srcimg = "../Logo-QuickJD.png";
                                    data_module.services.items[i].srclink = "http://www.quickjd.com";
                                    break;
                                case "HR":
                                    data_module.services.items[i].subDNS = "HR";
                                    data_module.services.items[i].srcimg = "";
                                    data_module.services.items[i].srclink = "";
                                    break;
                                case "Accounting":
                                    data_module.services.items[i].subDNS = "accounting";
                                    data_module.services.items[i].srcimg = "";
                                    data_module.services.items[i].srclink = "";
                                    break;
                                default:

                            }
                        }
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}

data_module.register.load = function(loadAgain = false) {
    if (data_module.register.items && !loadAgain)
        return Promise.resolve();
    return new Promise(function(resolve, reject) {
        FormClass.api_call({
            url: "load_register.php",
            params: [
                {name:"companyid",value:data_module.company.item.id}
            ],
            func: (success, message) => {
                if (success) {
                    if (message.substr(0, 2) == "ok") {
                        message = message.substr(2);
                        data_module.register.items = EncodingClass.string.toVariable(message);
                        for(var i=0;i<data_module.register.items.length;i++)
                        {
                            data_module.register.items[i].config = EncodingClass.string.toVariable(data_module.register.items[i].config);
                        }
                        resolve();
                    } else {
                        ModalElement.alert({
                            message: message
                        });
                        reject();
                        return;
                    }
                } else {
                    ModalElement.alert({
                        message: message
                    });
                    reject();
                    return;
                }
            }
        })
    })
}
</script>
<?php
}
?>