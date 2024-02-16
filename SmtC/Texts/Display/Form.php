<?php

trait Texts_Display_Form
{  
    //*
    //*
    //*

    function Text_Display_Form($text,$data="File",$pdata="Path")
    {
        return
            array
            (
                $this->Text_Display_Html($text,$data,$pdata),
            );
    }
}

?>