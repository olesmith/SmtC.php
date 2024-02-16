<?php

trait Texts_Carousel
{
    //*
    //* 
    //*

    function Text_Carousel_Handle($text)
    {
        $dest="Text_DIV_".$text[ "ID" ];
        
        return
            array
            (
                "Carousellllll",
                $text[ "Carousel_Base_URI" ]
            );
    }

}

?>