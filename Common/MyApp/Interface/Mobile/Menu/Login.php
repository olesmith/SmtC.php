<?php


trait MyApp_Interface_Mobile_Menu_Login
{
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Login_Logoff()
    {
        if (!$this->MyApp_Logon_May())
        {
            return array();
        }
        
        $title="";
        $url=$this->CGI_URI2Hash();
        
        if ($this->Profile_Public_Is())
        {
            $title=$this->MyLanguage_GetMessage("Logon");
            $url[ "Action" ]="Logon";
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Logoff");
            $url[ "Action" ]="Logoff";
        }

        
        return
            $this->Htmls_SPAN
            (   
                $title,
                $this->MyApp_Interface_Mobile_Menu_Options
                (
                    $url
                )
            );
    }
}

?>