<?php

trait MyMod_CSS
{
    //*
    //* Returns list of Module specific Online CSS URLS.
    //*

    function MyMod_CSS_OnLine($css_uri)
    {
        return array();
    }
    
    //*
    //* Returns list of Module specific Online CSS URLS.
    //*

    function MyMod_CSS()
    {
        $action=$this->CGI_GET("Action");
        
        $stubs=
            array
            (
                $action,
                $this->ModuleName,
                $this->ModuleName."/".$action,
            );

        $files=array();
        
        foreach ($stubs as $stub)
        {
            $file=
                join
                (
                    "/",
                    array
                    (
                        $this->ApplicationObj()->MyApp_Interface_CSS_Root(),
                        $this->ApplicationObj()->MyApp_Interface_CSS_Path(),
                        $stub
                    )
                ).
                ".css";

            if (file_exists($file))
            {
                array_push($files,$file);
            }
        }
        
        return $this->Htmls_Styles_Inline($files);
    }
}

?>