<?php

trait Htmls_Style
{
    //*
    //*
    //*

    function Htmls_Styles_Inline($files)
    {
        $styles=array();
        foreach ($files as $file)
        {
            array_push
            (
                $styles,
                $this->Htmls_Style_Inline($file)
            );
        }
        
        return $styles;
    }
    //*
    //*
    //*

    function Htmls_Style_Inline($file)
    {
        if (!file_exists($file)) { return array(); }

        $css=$this->MyFile_Read($file);
        if (!preg_grep('/\S/',$css))
        {
            return array();
        }

        return
            $this->Htmls_Tag
            (
                "STYLE",
                $css
            );
    }
    
    //*
    //*
    //*

    function Htmls_Style_CSS($css,$options=array())
    {
        return
            $this->Htmls_Tag
            (
                "STYLE",
                $css,
                $options
            );
    }
}

?>