<?php

trait MyApp_Interface_Mobile_Languages
{
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Languages()
    {
        $rlang=$this->GetLanguage();

        $args=$this->CGI_Query2Hash();

        $html=array();
        foreach ($this->Languages as $lang => $langdef)
        {
            //$img=$this->IMG($this->Icons."/".$langdef[ "Icon" ],$langdef[ "Name" ],50,75);

            array_push
            (
                $html,
                $this->Htmls_DIV
                (
                    $this->Htmls_HRef
                    (
                        "?".
                        $this->CGI_Hash2Query
                        (
                            array_merge
                            (
                                $args,
                                array
                                (
                                    "Lang" => $lang,
                                )
                            )
                        ),
                        $this->Htmls_Tag_Start
                        (
                            "IMG",
                            "",
                            array
                            (
                                "SRC" =>
                                $this->Icons."/".$langdef[ "Icon" ].
                                //"?".time().
                                "",
                                "WIDTH" => '75px',
                                "HEIGHT" => '50px',
                            )
                        ),
                        $langdef[ "Name" ]
                    ),
                    array
                    (
                        "CLASS" => "Mobile_Bottom_Languages_DIV",
                    )
                )
            );
        }

        return
            $this->Htmls_DIV
            (
                $html,
                array
                (
                    "CLASS" => "Mobile_Bottom_Languages_DIVs",
                )
            );
    }
}

?>