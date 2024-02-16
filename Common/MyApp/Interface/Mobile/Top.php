<?php


trait MyApp_Interface_Mobile_Top
{  
    //*
    //* Called by Module.php
    //*

    function MyApp_Interface_Mobile_Top_DIV()
    {
        return
            $this->Htmls_DIV
            (
                $this->MyApp_Interface_Mobile_Tops_Cells(),
                array
                (
                    "ID" => "TOP",
                    "CLASS" => array
                    (
                        "CLASS" => "Mobile_Top",
                    )
                )
            );
    }
    
    //*
    //* Create: logo1, titles, logo2.
    //*

    function MyApp_Interface_Mobile_Tops_Cells()
    {
        return
            array
            (
                $this->MyApp_Interface_Mobile_Top_Logo(1),
                $this->MyApp_Interface_Mobile_Top_Titles_DIV(),
                $this->MyApp_Interface_Mobile_Top_Logo(2),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Top_Logo($n=1)
    {
        return
            $this->Htmls_DIV
            (
                array
                (
                    $this->MyApp_Interface_Logo
                    (
                        $n,
                        array
                        (
                            "ALT" => "Logo",
                            "TITLE" => "Logo",
                        )
                    )
                ),
                array
                (
                    "CLASS" => "Mobile_Top_Logo_".$n,
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Top_Titles_DIV()
    {
        $h=1;
        return
            $this->Htmls_DIV
            (
                $this->MyApp_Interface_Mobile_Top_Titles_Get(),
                array
                (
                    "CLASS" => "Mobile_Top_Titles",
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Top_Titles_Get()
    {
        return
            array_merge
            (
                array
                (
                    $this->Htmls_DIV
                    (
                        $this->MyApp_Interface_Top_App(),
                        array
                        (
                            "ID" => "APP",
                            "CLASS" => array
                            (
                                "Mobile_Top_Title",
                                "Mobile_Top_Title_First",
                            )
                        )
                    ),
                ),
                $this->MyApp_Interface_Top_Titles_Owner()
            );
    }

    
    //*
    //* Default Owner title. Define in specific app.
    //*

    function MyApp_Interface_Top_Titles_Owner()
    {
        return array("Define function MyApp_Interface_Top_Titles_Owner");
    }

    
    //*
    //* Default Application title. Define in specific app.
    //*

    function MyApp_Interface_Top_App()
    {
        return "Define function MyApp_Interface_Top_App";
    }

    
    
}

?>