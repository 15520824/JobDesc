<?php
    function write_category_script() {
        global $prefix;
?>
        <script type="text/javascript">

        // jobdesc.generalInformation.index = 0;
        //
       

        jobdesc.category.loadPage = function () {
            
        }

        jobdesc.category.init = function(container){
            container.appendChild(
                absol.buildDom({
                    class:"general",
                    child:[
                        '<form></form>',
                            {
                                class:"container-container-form",
                                child:[
                                    {
                                        class: 'container-form',
                                        child: ['<span class="infotext">Tên công ty</span>',
                                                '<input class="properties"></input>']
                                    },
                                    {
                                        class: 'container-form',
                                        child: ['<span class="infotext">Địa chỉ</span>',
                                                '<input class="properties"></input>']
                                    },
                                    {
                                        class: 'container-form',
                                        child: ['<span class="infotext">Website</span>',
                                                '<input class="properties"></input>']
                                    },
                                ]
                            },
                            
                            {
                                class: 'container-image',
                                child: ['<img class="" src="price-icon.jpg"></img>',
                                        ]
                            },
                            

                    ]
                })
           
            )
        }
        </script>
<?php
}
?>
