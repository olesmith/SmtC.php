<?php

include_once("Mobile/Top.php");
include_once("Mobile/Menu.php");
include_once("Mobile/Bottom.php");
include_once("Mobile/Languages.php");

trait MyApp_Interface_Mobile
{
    use
        MyApp_Interface_Mobile_Top,
        MyApp_Interface_Mobile_Menu,
        MyApp_Interface_Mobile_Bottom,
        MyApp_Interface_Mobile_Languages;

    var $__MyApp_Interface_Mobile__=False;
    var $__MyApp_Interface_Mobile_Default__=1;
    var $__MyApp_Interface_Mobile_Regexps__=
        array
        (
            'Android',
            'Mobile;',
        );
    
    //*
    //* return interface head left cell.
    //*

    function MyApp_Interface_Mobile_Is()
    {
        if (isset($_GET[ "Mobile" ]) && $this->CGI_GETint("Mobile")==0)
        {
            return False;
        }
        
        return
            $this->__MyApp_Interface_Mobile__
            &&
            (
                $this->MyApp_Interface_Mobile_HTTP_USER_AGENT()
                ||
                $this->CGI_GETint("Mobile")==1
                ||
                $this->__MyApp_Interface_Mobile_Default__==1
            );
    }

  
    //*
    //* Mobile HTTP_USER_AGENT's.
    //*

    function MyApp_Interface_Mobile_HTTP_USER_AGENT()
    {
        return
            preg_match
            (
                '/\b('.
                join
                (
                    "|",
                    $this->__MyApp_Interface_Mobile_Regexps__
                ).
                ')/i',
                $_SERVER[ "HTTP_USER_AGENT" ]
            );
    }
    
    //*
    //* Mobile_Layout
    //*

    function MyApp_Interface_Mobile_Layout()
    {
        if (!empty($_GET[ "TOP"] ))
        {
            return
                $this->MyApp_Interface_Mobile_Top_DIV();                
        }
        
        return
            array
            (
                $this->Htmls_Tag
                (
                    "BODY",
                    array
                    (
                        $this->Htmls_Tag
                        (
                            "STYLE",
                            array
                            (
                                "*.fcell {overflow: visible;}",
                                ".wrapper {",
                                "   display: grid;",
                                "   grid-template-columns: 1fr;",
                                "}",
                            )
                        ),
                        $this->Htmls_DIV
                        (
                            array
                            (
                                $this->MyApp_Interface_Mobile_Top_DIV(),
                                $this->Htmls_DIV
                                (
                                    array
                                    (
                                        $this->MyApp_Interface_Mobile_Menu_DIV(),
                                        $this->MyApp_Interface_Middle_Right(),
                                        $this->MyApp_Interface_Sponsors()
                                    ),
                                    array
                                    (
                                        "ID" => "MC",
                                        "CLASS" =>  array
                                        (
                                            "section",
                                            "ModuleCell",
                                            "fcell",
                                            "first"
                                        ),
                                    )
                                ),

                                $this->Htmls_DIV
                                (
                                    $this->MyApp_Interface_Mobile_Bottom(),
                                    array
                                    (
                                        "ID" => "BOTTOM",
                                        "CLASS" => array
                                        (
                                            "fcell",
                                            "first",
                                        )
                                    )
                                ),
                            )
                        ),
                    )
                )
            );

    }
}

?>