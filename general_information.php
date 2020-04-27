<?php
    function write_general_information_script() {
        global $prefix;
?>
        <script type="text/javascript">

        // jobdesc.generalInformation.index = 0;
        //
        //    state 
        //    0:state information 
        //    1:state Mission
        jobdesc.generalInformation.tabPanel = function () {
            return absol._({
                    tag:'tabview',
                    style:{
                        width: '100%',
                        height: '100%'
                    }
                });
        } ;


        jobdesc.generalInformation.loadMenu = function(tabPanel,choice,host_all)
        {
            var holder, hostchild;
            var titlepage = document.getElementById("title_page_init");
            holder = absol._({
                tag:'tabframe',
            });
            tabPanel.classList.add('no-close-button');
            switch (choice) {
                case 1:
                    hostchild = {holder: holder, pagetitle: titlepage};
                    holder.name = LanguageModule.text("title_category");
                    tabPanel.addChild(holder);
                    jobdesc.responsibility.processTabbar(hostchild,host_all)
                    break;
                case 2:
                    hostchild = {holder: holder, pagetitle: titlepage};
                    holder.name = LanguageModule.text("title_library");
                    tabPanel.addChild(holder);
                    jobdesc.responsibility.listInfoInit(hostchild,host_all)
                    break;
                default:
                    holder.innerHTML = "under construction (" + choice + ")";
                    break;
            }
        }

        jobdesc.generalInformation.defineSize=window.innerWidth/3;
        
        jobdesc.generalInformation.Container=function()
        {
            return DOMElement.div({
                            attrs:{
                                className:"all-build-list",
                                style:{
                                    left : "calc("+this.defineSize/window.innerWidth*100+'% + 25px)',
                                    width: "calc(100% - "+(this.defineSize+30)+"px)",
                                    right:'0',// it is easier than width
                                    position: "absolute",
                                    background: "white",
                                    height:"100%",
                                    margin:'0',
                                    width:'unset'
                                }
                            },
                            children:[
                            ]
                        })
        }

        jobdesc.generalInformation.loadPage = function (container,host) {
            container.addStyle('height', '100%');//don't scroll, childrent with 100% will be set
            if(host.data===undefined)
            host.data=[];
            host.listEditor=[];
            if(host.data[0]===undefined)
            host.data[0]=[]
            host.state=0;
            host.stack=[];
            host.stackRedo=[];
            host.checkSearch=[];
            host.tempPositions=[];
            host.infoBar= jobdescui.InfoBar(host);
            var tabPanel= jobdesc.generalInformation.tabPanel();
            //you must handle better
            absol._('attachhook').addTo(host.infoBar)
                .once('error', function(){
                    tabPanel.addStyle('height', 'calc(100% - '+host.infoBar.getBoundingClientRect().height+'px)');
                    this.remove();
                        
                });
            host.tabPanel=tabPanel;
            var containerTab = DOMElement.div({
                        attrs:{
                            style:{
                                position: "absolute",
                                width: "calc("+this.defineSize/window.innerWidth*100 +'% - 7px)',
                                height: "100%",
                                marginLeft: "20px",
                                paddingRight: "10px"
                            }
                        },
                        children:[
                            host.infoBar,
                            tabPanel
                        ]
                    });

            var containerList=jobdesc.generalInformation.Container();

            
            host.containerTab=containerTab;
            host.containerList=containerList;
           
            
            host.editor = CKEDITOR;

            jobdesc.responsibility.BuildInfoInit(host);
            
            var resizer = DOMElement.div({
                        attrs:{
                            className:"common-resizer",
                            style:{
                                left:"calc("+this.defineSize/window.innerWidth*100+'% + 10px)'
                            }
                        }

                    });
            var resizerView = DOMElement.div({
                        attrs:{
                            className:"view-resizer",
                            style:{
                                left:"calc("+this.defineSize/window.innerWidth*100+'% + 10px)'
                            }
                        }

                    });
            var containerRelative=DOMElement.div({
                attrs:{
                    style:{
                    height:"100%",
                    position: "relative",
                    border: "1px solid rgb(214, 214, 214)"
                    }
                },
                children:[
                    containerTab,
                    containerList,
                    resizerView,
                    resizer
                ]
                
            });

           
            absol.event.defineDraggable(resizer); 
            var currentLeftWidth = this.defineSize;
            var oldWindowWidth = window.innerWidth;
            var needUpdateSizeList = [];      
            window.onresize = function(){
                currentLeftWidth = currentLeftWidth/oldWindowWidth*window.innerWidth;
                oldWindowWidth=window.innerWidth;
            }   
            resizer.on('begindrag', function(event) {
                resizer.addStyle('width', '305px');
                this.addStyle('left', currentLeftWidth + event.moveDX + (10-305)/2 +'px');
                currentLeftWidth += event.moveDX;
                needUpdateSizeList = [];    
            });

            resizer.on('enddrag', function(event) {
                resizer.removeStyle('width', '305px');
                currentLeftWidth += event.moveDX;
                this.addStyle('left', "calc("+currentLeftWidth/window.innerWidth*100+'% + 10px)');
                resizerView.style.left = "calc("+currentLeftWidth/window.innerWidth*100+'% + 10px)';
            });

            resizer.on('drag', function(event) {
                this.addStyle('left', currentLeftWidth + event.moveDX + (10-305)/21 +'px');
                resizerView.style.left = currentLeftWidth + event.moveDX + 10 +'px';
                host.containerTab.style.width = "calc("+(currentLeftWidth + event.moveDX)/window.innerWidth*100 +'% - 7px)';
                host.containerList.style.left = "calc("+(currentLeftWidth + event.moveDX)/window.innerWidth*100 +'% + 25px)';
                host.containerList.style.width =  "calc("+(window.innerWidth-(currentLeftWidth + event.moveDX ))/window.innerWidth*100+"% - 40px)";
            });
            
            
            container.appendChild(
                DOMElement.div({
                    attrs:{
                        className:"common",
                        },
                    children:[
                        //host.infoBar,
                        // tabPanel,
                        //processTabbar(0),
                        // jobdesc.generalInformation.container,
                        containerRelative
                        
                    ]
                })
            )
            jobdesc.generalInformation.loadMenu(tabPanel,1,host);
            jobdesc.generalInformation.loadMenu(tabPanel,2,host);
        }

        jobdesc.generalInformation.init = function(container,host){
            this.loadPage(container,host)
        }
        </script>
        
<?php
}
?>
