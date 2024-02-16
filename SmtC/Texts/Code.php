<?php

trait Texts_Code
{
    var $__Text_Code_Extension_2_Language__=
        array
        (
            "html" => "haml",
            "js" => "javascript",
            "svg" => "haml",
            "tex" => "latex",
            "py" => "python",
            "py3" => "python",
        );
    
    //*
    //*
    //*

    function Text_Code_Extension_2_Language($extension)
    {
        $extensions=
            preg_grep
            (
                '/^'.$extension.'$/',
                array_keys
                (
                    $this->__Text_Code_Extension_2_Language__
                )
            );

        if (count($extensions)>0)
        {
            $extension=array_shift($extensions);
        }
        
        if (!empty($this->__Text_Code_Extension_2_Language__[ $extension ]))
        {
            return $this->__Text_Code_Extension_2_Language__[ $extension ];
        }

        //var_dump("unknown type",$extension,$extensions);

        return "Undefined";
    }
            
    //*
    //*
    //*

    function Text_Code_File_2_Language($fname)
    {
        $extension="";
        if (preg_match('/\.\S+$/',$fname))
        {
            $extension=preg_split('/\./',$fname);
            $extension=array_pop($extension);
            $extension=strtolower($extension);

            $extension=$this->Text_Code_Extension_2_Language($extension);
        }

        return $extension;
    }

}

?>