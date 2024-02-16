<?php


trait MyApp_Interface_Mobile_Menu_Start
{
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Start()
    {
        $url=$this->CGI_URI2Hash();
        $url[ "Action" ]="Start";
        unset($url[ "ModuleName" ]);

        $url=
            array
            (
                "Action" => "Start",
            );
        return
            $this->Htmls_SPAN
            (
                "Start",
                $this->MyApp_Interface_Mobile_Menu_Options($url)
            );
    }
    
}

?>