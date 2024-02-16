<?php


trait MyApp_Interface_HorMenu
{
    //*
    //* 
    //*

    function MyApp_Interface_HorMenu_Echo()
    {
        if ($this->CGI_GETint("NoHorMenu")==1) { return; }
        
        $this->Htmls_Echo
        (
            $this->MyApp_Interface_HorMenu_Generate()
        );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_HorMenu_Generate()
    {
        $menu_file="System/Menu.php";
        
        $html=array();
        if (file_exists($this->ApplicationObj()->MyApp_Setup_Base()."/".$menu_file))
        {
            $menu=$this->ReadPHPArray($menu_file);

            $profile=$this->Profile();
            if (!empty($menu[ $profile ]))
            {
                foreach (array_keys($menu[ $profile ]) as $action)
                {
                    if (!empty($this->Actions[ $action ]))
                    {
                        
                        array_push
                        (
                            $html,
                            $this->MyApp_Interface_HorMenu_Entry($action),
                            "&nbsp;"
                        );
                    }
                }
            }
        }
        
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    $html,
                    array
                    (
                        "CLASS" => 'atablemenu',
                    ),
                    array
                    (
                        "text-align" => "center",
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_HorMenu_Entry($action)
    {
        return
            $this->Htmls_HRef
            (                
                $this->MyActions_Entry_URL
                (
                    $action
                ),
                $this->MyActions_Entry_Name($action),
                $this->MyActions_Entry_Title($action),
                'dynamicmenuitem'
            );        
    }
    
}

?>