<?php

trait Texts_Display_Child_Display
{
    
    //*
    //* 
    //*

    function Text_Display_Child_Display_DIV($text,$child)
    {
        $display='none';
        if
            (
                //$this->Text_Is_Inline($child)
                //||
                $this->Text_Is_Open($child)
            )
        {
            $display='block';
        }
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Text_Display_Child_Display_DIV_Contents($text,$child),

                    array
                    (
                        "ID" => $this->Text_Display_Child_Toggle_Cell_ID
                        (
                            "Cell",$text,$child
                        ),
                        "STYLE" => $this->Text_Display_Child_Display_Style
                        (
                            $text,$child
                        )
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function Text_Display_Child_Display_Style($text,$child)
    {
        return
            array
            (
                'display' => $this->Text_Display_Child_Display_CSS
                (
                    $text,$child
                ),
            );
    }
    
    //*
    //* 
    //*

    function Text_Display_Child_Display_CSS($text,$child)
    {
        $display='none';
        if
            (
                //$this->Text_Is_Inline($child)
                //||
                $this->Text_Is_Open($child)
            )
        {
            $display='block';
        }

        return $display;
    }
    //*
    //* 
    //*

    function Text_Display_Child_Display_DIV_Contents($text,$child)
    {
        return
            $this->Text_Display_Body($child);
    }
}

?>