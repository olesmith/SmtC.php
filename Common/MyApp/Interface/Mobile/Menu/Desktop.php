<?php


trait MyApp_Interface_Mobile_Menu_Desktop
{    
    //*
    //* Link to desktop version.
    //*

    function MyApp_Interface_Mobile_Menu_Desktop()
    {
        $url=$this->CGI_URI2Hash();
        unset($url[ "Mobile" ]);
        $url[ "Mobile" ]="0";
        return
            $this->Htmls_SPAN
            (   
                "Desktop Version",
                $this->MyApp_Interface_Mobile_Menu_Options($url)
            );
    }
}

?>