<?php

trait Texts_Types
{
    var $__Types__=
        array
        (
            "Text"      => 1,
            "Exercise"  => 9,
            "Code"      => 10,
            "Question"  => 11,
            "Itemize"   => 7,
            "Enumerate" => 8,
            "List"      => 12,
            "Input"     => 13,
            "Image"     => 13,
            "URL"       => 13,
            "Curve"     => 19,
            "Carousel"  => 20,
            "Link"      => 21,
        );
    
    var $__Code_2_Ext__=
        array
        (
            1 => "html",
            2 => "js",
            3 => "svg",
            4 => "tex",
            5 => "py",
            6 => "php",
        );
    var $__Code_2_Name__=
        array
        (
            1 => "HTML",
            2 => "Java Script",
            3 => "SVG",
            4 => "\\LaTeX",
            5 => "Python (3)",
            6 => "PHP",
        );
    var $__Code_2_Bin__=
        array
        (
            1 => "",
            2 => "",
            3 => "/usr/bin/svg2pdf",
            4 => "/usr/bin/pdflatex",
            5 => "/usr/bin/python3",
            6 => "",
        );
    
    //*
    //* 
    //*

    function Text_Is_Python($text,$data="Code_Type")
    {
        $res=False;
        if ($text[ $data ]==5)
        {
            $res=True;
        }
        
        return $res;
    }

    //*
    //* 
    //*

    function Text_Type_No($key)
    {
        return intval($this->__Types__[ $key ]);
    }

    //*
    //* 
    //*

    function Text_Type_Is($key,$text)
    {
        return
            (
                intval($text[ "Type" ])
                ==
                intval
                (
                    $this->Text_Type_No($key)
                )
            );
    }

    
    //*
    //* 
    //*

    function Text_Type_Code_Name($text,$data="Code_Type")
    {
        $type="-";
        
        if
            (
                !empty($text[ $data ])
                &&
                !empty($this->__Code_2_Name__[ $text[ $data ] ])
            )
        {
            
            $type=$this->__Code_2_Name__[ $text[ $data ] ];
        }
        
        return $type;
    }
    //*
    //* 
    //*

    function Text_Type_Code_Ext($text,$data="Code_Type")
    {
        $ext="-";
        
        if
            (
                !empty($text[ $data ])
                &&
                !empty($this->__Code_2_Ext__[ $text[ $data ] ])
            )
        {
            
            $ext=$this->__Code_2_Ext__[ $text[ $data ] ];
        }
        
        return $ext;
    }
    //*
    //* 
    //*

    function Text_Type_Code_Bin($text,$data="Code_Type")
    {
        $bin="-";
        
        if
            (
                !empty($text[ $data ])
                &&
                !empty($this->__Code_2_Bin__[ $text[ $data ] ])
            )
        {
            
            $bin=$this->__Code_2_Bin__[ $text[ $data ] ];
        }
        
        return $bin;
    }
}

?>