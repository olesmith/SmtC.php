<?php

trait Texts_Display_Code
{
    //Code no to hightligt language
    var $__Code_Types__=array
        (
            1 => "haml",
            2 => "latex",
            3 => "python",
            4 => "haml",
            5 => "javascript",
            6 => "c",
        );
    
    //*
    //*
    //*

    function Text_Display_Code($text)
    {
        $element_id=$this->Text_Display_Code_ID($text);
        
        $language=$this->__Code_Types__[ $text[ "Code_Type" ] ];
         
        $class=$this->Code_CLASS_HighLight($text);

        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        "<pre><code CLASS='".$class."'>".
                        $text[ "Body" ].
                        "</code></pre>\n",
                    ),
                    array
                    (
                        "ID" => $element_id,
                    ),
                    array
                    (
                        //"white-space" => 'pre',
                    )
                ),
                $this->MyMod_Load_Highlight_By_Class($element_id,$language),

                $this->Text_Display_Exec($text)
            );

        
    }
    
    //*
    //*
    //*

    function Text_Display_Code_CLASS_HighLight($text)
    {
        $language=$this->__Code_Types__[ $text[ "Code_Type" ] ];
         
        return "language-".$language;
    }
    
    //*
    //*
    //*

    function Text_Display_Code_ID($text)
    {
        return "Text_Code_".$text[ "ID" ];
    }
}

?>