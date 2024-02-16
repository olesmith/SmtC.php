<?php

include_once("Menu/Start.php");
include_once("Menu/Profiles.php");
include_once("Menu/Desktop.php");
include_once("Menu/Login.php");
include_once("Menu/Messages.php");

trait MyApp_Interface_Mobile_Menu
{
    use
        MyApp_Interface_Mobile_Menu_Start,
        MyApp_Interface_Mobile_Menu_Profiles,
        MyApp_Interface_Mobile_Menu_Desktop,
        MyApp_Interface_Mobile_Menu_Login,
        MyApp_Interface_Mobile_Menu_Messages;
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_DIV()
    {
        return
            $this->Htmls_DIV
            (
                $this->MyApp_Interface_Mobile_Menu(),
                array
                (
                    "ID" => "MENU",
                    "CLASS" => array
                    (
                        "atablemenu App_Menu_DIV"
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu()
    {
        $html=array();

        foreach ($this->MyApp_Interface_Mobile_Menu_Items() as $menu_item)
        {
            array_push($html,$menu_item);
                
        }
        
        return $html;
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Items()
    {
        return
            array
            (
                $this->MyApp_Interface_Mobile_Menu_Desktop(),
                $this->MyApp_Interface_Mobile_Menu_Profiles(),
                $this->MyApp_Interface_Mobile_Menu_Login_Logoff(),
                $this->MyApp_Interface_Mobile_Menu_Messages(),
                $this->MyApp_Interface_Mobile_Menu_Start(),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Options($url)
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }
        
        return
            array
            (
                "CLASS" => "dynamicmenuitem",
                "ONCLICK" => array
                (
                    "Load_URL_2_Window('".$url."');",
                    
                )
            );
    }
    

}

?>