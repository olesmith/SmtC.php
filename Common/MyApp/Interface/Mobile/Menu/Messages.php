<?php


trait MyApp_Interface_Mobile_Menu_Messages
{
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Messages()
    {
        $url=$this->CGI_URI2Hash();
        $url[ "Action" ]="Search";
        $url[ "ModuleName" ]="Languages";
        
        return
            $this->Htmls_SPAN
            (
                "Messages",
                $this->MyApp_Interface_Mobile_Menu_Options($url)
            );
    }
    
}

?>