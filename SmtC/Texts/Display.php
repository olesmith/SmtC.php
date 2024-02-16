<?php

include_once("Display/Body.php");
include_once("Display/Code.php");
include_once("Display/Exec.php");
include_once("Display/List.php");
include_once("Display/Form.php");
include_once("Display/Html.php");
include_once("Display/Children.php");
include_once("Display/Child.php");
include_once("Display/MathJax.php");
include_once("Display/Parents.php");
include_once("Display/Icons.php");


trait Texts_Display
{
    use
        Texts_Display_Body,
        Texts_Display_Code,
        Texts_Display_Exec,
        Texts_Display_List,
        Texts_Display_Form,
        Texts_Display_Html,
        Texts_Display_Children,
        Texts_Display_Child,
        Texts_Display_MathJax,
        Texts_Display_Parents,
        Texts_Display_Icons;
    
    //*
    //* Text_Display_Handle handler.
    //*

    function Text_Display_Handle($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }

        if
            (
                $this->Text_Is_Link($text)
                &&
                !empty($text[ "Destination" ])
            )
        {
            $text=
                $this->Sql_Select_Hash
                (
                    array("ID" => $text[ "Destination" ])
                );
        }
        
        return
            $this->Htmls_Echo
            (
                $this->Text_Display_Form($text)
            );
    }

    //*
    //*
    //*
    
    function Text_Display_Level(&$text)
    {
        $rtext=$text;
        $level=0;
        $parent=0;
        while (!empty($rtext[ "Parent" ]))
        {
            $level++;
            $rtext=
                $this->Sql_Select_Hash
                (
                    array("ID" => $rtext[ "Parent" ]),
                    array("ID","Parent")
                );

            if (!empty($rtext[ "Parent" ]))
            {
                $parent=$rtext[ "Parent" ];
            }
        }

        $text[ "Parent" ]=$parent;
        $text[ "Level" ]=$level;

        return $level;
    }
    

}

?>