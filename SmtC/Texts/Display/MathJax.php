<?php

trait Texts_Display_MathJax
{        
    //*  
    //* Activate MathJax, if $text[ "IsLatex" ]==2.
    //*

    function Text_Display_MathJax($text)
    {
        $scripts=array();
        if (intval($text[ "IsLatex" ])==2)
        {
            $scripts=
                array
                (
                    //Load mathjax, if necessary - retype set
                    $this->Htmls_Tag
                    (
                        "SCRIPT",
                        array
                        (
                            'Load_MathJax("Display_'.$text[ "ID" ].'");',
                        ),
                        array
                        (
                            "src" => "JS/MathJax.js",
                            "type" => 'text/javascript',
                        )
                    )
                );
        }

        return $scripts;
    }
}

?>