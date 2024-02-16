<?php

include_once("Child/Display.php");
include_once("Child/Item.php");
include_once("Child/Toggles.php");

trait Texts_Display_Child
{
    use
        Texts_Display_Child_Display,
        Texts_Display_Child_Item,
        Texts_Display_Child_Toggles;
    
    //*
    //*
    //*

    function Text_Display_Child($text,$child,$children)
    {        
        if ($this->Text_Is_List($child))
        {
            return
                array
                (
                    $this->Text_Display_Child_In_List($text,$child),
                );
        }
        else
        {
            return
                array
                (
                    $this->Text_Display_Child_Item($text,$child,$children),
                );
        }
    }
    
    //*
    //*
    //*

    function Text_Display_Child_In_List($text,$child)
    {
        return
            array
            (
                array
                (
                    $this->Text_Display_Child_Toggles($text,$child),
                ),

                $this->Text_Display_Child_Display_DIV($text,$child)
            );
    }
}

?>