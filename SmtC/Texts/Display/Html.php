<?php

trait Texts_Display_Html
{
    //*
    //* For rapid testing of JS: Include reading file(s).
    //*

    function Text_Display_JS($text)
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                        $this->MyFile_Read("JS/MathJax.js")
                    ),
                    array
                    (
                        "type" => 'text/javascript',
                    )
                )
            );
    }
    
    //*
    //*
    //*

    function Text_Display_Html($text,$data="File",$pdata="Path")
    {
        $html=
            array
            (
                $this->Text_Display_MathJax($text),
            );
        
        array_push
        (
            $html,

            $this->Htmls_DIV
            (
                array
                (
                    $this->Text_Display_Body
                    (
                        $text,
                        array
                        (
                            $this->Text_Display_Children_Mode_List($text),
                            $this->Text_Display_Children_Mode_Items($text),
                            $this->Text_Display_Body_Parse_File($text),
                            $this->Text_Display_Body_Parse_Exec($text),
                        )
                    ),
                ),
                //$options=
                array
                (
                    "ID" => $this->Text_Display_Html_Destination_ID($text),
                )
            )
        );
        
        return
            $this->Htmls_DIV
            (
                $html,
                array
                (
                    "ID" => $this->Text_Display_Html_DIV_ID($text)
                )
            );
    }
    
    //*
    //* ID of the destination div.
    //*

    function Text_Display_Html_Destination_ID($text)
    {        
        $keys=array("Destination");

        array_push($keys,"T_".$text[ "ID" ]);

        return $keys;
    }

    //*
    //*
    //*

    function Text_Display_Html_DIV_ID($text)
    {
        return array("Text","DIV",$text[ "ID" ]);
    }
}

?>