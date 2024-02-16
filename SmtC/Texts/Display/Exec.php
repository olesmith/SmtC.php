<?php

trait Texts_Display_Exec
{
    //*
    //*
    //*

    function Text_Display_Exec($text)
    {
        $html=array("Implement");
        if (intval($text[ "Code_Type" ])==1) //HTML
        {
            $html=
                array
                (
                    $this->Htmls_Tag
                    (
                        "IFRAME",
                        array
                        (                            
                        ),
                        array
                        (
                            "SRCDOC" => $text[ "Body" ],
                        ),
                        array
                        (
                            "text-color" => 'orange',
                            "background" => 'white',
                        )
                    )
                );
        }
        elseif (intval($text[ "Code_Type" ])==4) //SVG
        {
            $html=
                array
                (
                    $this->Htmls_Tag
                    (
                        "SPAN",
                        $text[ "Body" ]
                    ),
                );
        }

        return $html;
    }
}

?>