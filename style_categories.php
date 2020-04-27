<?php
$kpi_script_written = 0;

function write_style() {
   
    ?>
    <style>
        .absol-single-page-scroller-viewport{
            height:100%;
        }
        .material-icons{
            vertical-align: middle;
        }
        i:hover{
            cursor: pointer;
        }
        .lv-item-content:hover{
            cursor: pointer;
        }
        .Info2:hover{
            cursor: pointer;
        }
        .nth>div:nth-child(odd) {
        background: rgb(247, 246, 246);
        }

        .nth>div:nth-child(even) {
        background: #ebebeb;
        }

        .nth>tbody :hover{
            background-color: #c0c0c0 !important;
            cursor: pointer;
        }
    </style>
    <style>
        .general{
            display: inline-block;
            padding: 10px;
            width: auto;
            vertical-align: top;
        }
        .general
        .title{
            white-space: nowrap;
            font-size:21px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }
        .properties{
                display:table-cell;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
                padding: 0.5em;
                vertical-align: middle;
                resize: none;
                width:100%;
                height:30px;
                border: solid 1px #d6d6d6;
                min-width: 374px;
        }
        textarea.properties{
               height:6em;
        }
        .container-form
        {
            display:table-row;
            margin-top:10px;
            min-width:374px;
        }
        .form-container>div{
        }
        .infotext{
           display:table-cell;
           vertical-align: top;
           height:30px;
           padding: 0.5em;
           padding-left: 10px;
           padding-right:10px;
        }
        .all-build{
            vertical-align: top;
            padding-left: 20px;
            padding-right: 10px;
            height:100%;
        }
        .all-build-list{
            vertical-align: top;
            height:100%;
        }
        .absol-vscroller{
            height:100%;
        }
        .form-container{
            margin-top:2em;
            margin-left:10px;
        }
        td{
            font-size:14px;
            font-family: Arial, Helvetica, sans-serif;
        }
        button{
            font-size:14px !important;
            font-family: Arial, Helvetica, sans-serif;
        }
        span{
            font-size:14px !important;
            font-family: Arial, Helvetica, sans-serif;
        }
       
    </style>
    <style>
        .container_responsibility{
            height:100%;
        }
        .information{
            border: 1px solid rgb(214, 214, 214);
            padding: 10px;
            width: 100%;
            display:inline-block;
            vertical-align: top;
            height: 100%;
            background: rgb(247, 246, 246);
            overflow-y: auto;
        }
        .common{
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .common>div>div>table{
            width:100%;
        }
        .common>div>div>div>div>table{
            width:100%;
        }
        .Info1{
            font-size:14px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            text-align: center;
        }
        .Info2{
            font-size:14px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            display:block;
            border: 1px solid #d6d6d6;
        }

        .Info2>i{
            display:table-cell;
            font-size:20px;
        }

        /* mouse over link */
        .Info2:hover {
        background-color: #c0c0c0 !important;
        }

        .lv-item:hover {
        background-color: #c0c0c0 !important;
        }
    
        .add_element{
            text-decoration: underline;
        }
        .lv-item{
        }
        .container-index
        {
            display:block;
            width:100%;
            margin-top:10px;
            height:calc(100% - 80px);
            overflow-y: auto;
        }
        /* .row2colors tr:nth-child(odd)
        {
            background:unset !important;
        } */
        .container-index>div>div{
           
        }
        .container-index>div{
            background-color: white;
        }
        .Info2>span{
            display:table-cell;
            vertical-align: middle;
            width:100%;
            padding-top: 7px;
            padding-bottom: 7px;
            padding-left:5px;
        }
        .infotitle{
           display:table-cell;
           vertical-align: top;
        }
        .no-close-button .absol-tabbar-button-close{
            visibility:hidden!important;
            pointer-events: none;
        }
    </style>
    <style>
        .container-container-form>div>input{
           
        }
        .container-container-form>div>textarea{
        }
        .auto-properties{
            display: table-cell;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
            vertical-align: middle;
            resize: none;
            width: 374px;
            height: 30px;
        }
        .container-image>img{
        }
        .container-image{
            display: table-cell;
            width: 15%;
            vertical-align: bottom;
        }
        .absol-single-page-header .absol-icon-button:not(:first-child)  {
            margin-left: 5px;
        }
        .absol-single-page-header .absol-icon-button:not(:last-child)  {
            margin-right: 5px;
        }


    </style>
    <style>
    .InfoBar{
        margin-top:10px;
        margin-bottom:10px;
        border: 1px solid #d6d6d6;
        background: rgb(247, 246, 246);
        padding: 10px;
        width:100%;
        text-align: center;
    }
    .common>div>div>div>div>table>tbody>tr>td{
        border-top: none !important;
    }
    </style>
    <style>
    .container-top>i{
        display:table-cell;
        color: darkgrey;
        border-top: 1px solid #d6d6d6;
        border-bottom: 1px solid #d6d6d6;
        padding-right: 5px;
        padding-left: 5px;
    }
    .container-top>span{
        width: 100%;
        vertical-align:middle;
        padding:5px;
        font-weight: bold;
        border: 1px solid #d6d6d6;
      
    }
    .container-top{
        display:table-row;
        background: rgb(247, 246, 246);
    }
    .index-top-bot
    {
        margin-right:10px;
        margin-top:10px;
        height: calc(100% - 20px);
    }
    .index-top-bot:last-child
    {
        margin-bottom:10px;
    }
    </style>
    <style>
    .common-resizer{
        position: absolute;
        z-index: 10;
        left: 0px;
        top: 0px;
        bottom: 0;
        width: 5px;
        background-color: transparent;
        cursor: col-resize;
    }
    .view-resizer{
        position: absolute;
        z-index: 10;
        left: 0px;
        top: 0px;
        bottom: 0;
        width: 1px;
        margin-left:2px;
        background-color: black;
        cursor: col-resize;
    }
    .resetClass{
        width:100% !important;
    }
    .resetClass>div{
        width:100% !important;
    }
    </style>
    <style>
    .choice{
        background:#c0c0c0 !important;
    }
    .Info2>div {
        display: table-cell !important;
        right: 12px;
    }

    .NoBolder{
        padding: unset;
        border: unset;
    }
    .hasBolder{
        border: 1px solid rgb(214, 214, 214);;
    }
    .margin{
        width:100%;
        height:10px;
        border-left: 1px solid #d6d6d6;
        border-right: 1px solid #d6d6d6;
    }
    .autocomplete-div{
        margin-left:10px;
    }
    .span-autocomplete{
        padding-top: 0.5em;
    }
    .update-catergory{
        margin-left: 10px;
        margin-top:10px;
    }
    .update-catergory>div{
        margin-bottom:10px;
        margin-top:unset;
    }
    .update-catergory>div>span{
    }
    .lv-item{
  position:relative;
  border: 1px solid #d6d6d6;
}

.lv-item-content{
  margin-right: 30px;
  padding:5px;
}
.vcenter>i{
    color: darkgrey;
    display: inline-block;
}


.lv-item-right-container{
    width:30px;
    top:0;
    right:0;
    bottom:0;
    position:absolute;
    border-left:1px solid #d6d6d6;
}

.lv-item-right-container>div{
  width:100%;
  height:100%;
}

.hcenter{
  display:table; 
  text-align:center;
}
.vcenter{
    display: table-cell;
    vertical-align:middle;
}
.absol-autocomplete-input>input{
    padding: 0.5em;
    height: 30px;
}
.absol-icon-button{
    min-width: 108px;
}
[data-placeholder]:empty:before {
  color: #AAA;
  content: attr(data-placeholder);
}
.absol-icon-button-text-container{
    min-width:79px;
}
.absol-vscroller{
    overflow-y: hidden;
}
.space{
    display:table-row;
    height:10px;
}
</style>
<style>
    /******************* *****************/
    .absol-single-page-header{
        padding: 10px 5px 10px 20px;
    }
</style>

<?php
}
?>
