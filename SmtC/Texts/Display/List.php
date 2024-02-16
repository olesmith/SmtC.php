<?php

trait Texts_Display_List
{
    var $__Text_Display_List_Types__=
            array
            (
                "decimal",
                "lower-alpha",
                "lower-greek",
                "lower-latin",
                "lower-roman",
                "upper-alpha",
                "upper-latin",
                "upper-roman",
                "decimal-leading-zero",
            );
    
    var $__Text_Display_List_Types_Hash__=
            array
            (
                //Root
                0 => "upper-roman",
                //Part
                2 => "decimal",
                //Chapter
                3 => "decimal",
                //Exercise
                9 => "lower-alpha",
                //Question
                11 => "disc",                
            );
    
    //*
    //*
    //*
    
    function Text_Display_List_Style_Type($text)
    {
        if ($this->Text_Is_Root($text))
        {
            return $this->__Text_Display_List_Types_Hash__[ 0 ];
        }
        if (!empty($this->__Text_Display_List_Types_Hash__[ $text[ "Type" ] ]))
        {
            return $this->__Text_Display_List_Types_Hash__[ $text[ "Type" ] ];
        }

        //Revert to $levl based
        $level=$this->Text_Display_Level($text);
        
        $level=$level % count($this->__Text_Display_List_Types__);
        
        return $this->__Text_Display_List_Types__[ $level ];
    }
   
    //*
    //*
    //*
    
    function Text_Display_List_Type($text)
    {
        $ul="OL";
        if ($this->Text_Is_Question($text))
        {
            $ul="UL";
        }
        
        return $ul;
    }
    
    //*
    //*
    //*
    
    function Text_Display_List_Style($text)
    {
        //if ($this->Text_Is_Question($text)) { return array(); }

        return
            array
            (
                "list-style-type" => $this->Text_Display_List_Style_Type($text),
            );
    }
    
}

?>