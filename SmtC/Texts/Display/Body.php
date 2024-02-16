<?php

include_once("Body/Parse.php");

trait Texts_Display_Body
{
    use
        Texts_Display_Body_Parse;
    
    //*
    //*
    //*

    function Text_Display_Body($text,$trailing=array())
    {
        if ($this->Text_Is_Code($text))
        {
            return
                $this->Text_Display_Code($text);
        }

        $html=array();
        if ($this->Text_Is_Curve($text))
        {
            $html=$this->Text_Curve_Handle($text);
        }
        elseif ($this->Text_Is_Carousel($text))
        {
            $html=$this->Text_Carousel_Handle($text);
        }
        
        $style=
            $this->Text_Display_Body_Style($text);
        
        $divs=
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->Htmls_H(3,$text[ "Title" ]),
                        $this->Text_Display_Body_Parse($text),
                        $trailing,
                    ),
                    array
                    (
                        "ID" => "Display_".$text[ "ID" ],
                        "CLASS" => "Text_Body",
                    ),
                    $style
                )
            );

        if (!empty($text[ "Solution" ]))
        {
            $text[ "Solution" ]=
                preg_replace
                (
                    '/\s/',
                    "&nbsp;&nbsp;&nbsp;",
                    preg_replace
                    (
                        '/\n+/',
                        "<BR>",
                        $text[ "Solution" ]
                    )
                );

            if ($this->Text_Is_Exercise($text))
            {
                array_push
                (
                    $divs,
                    $this->HR(),
                    $this->B("Solution:")
                );
            }

            array_push
            (
                $divs,
                $this->Htmls_DIV
                (
                    $text[ "Solution" ],
                    array
                    (
                        "ID" => "Display_".$text[ "ID" ],
                        //"CLASS" => "Text_Body",
                    ),
                    $style
                )
            );
        }

        if (!empty($html))
        {
            array_push($divs,$html);
        }

        return $divs;
    }
    
    //*
    //*
    //*

    function Text_Display_Body_Style($text)
    {
        return
            array
            (
                /* "max-height" => '300px', */
                /* "max-width" => '80%', */
                /* "border" => '2px solid red', */
                /* "border-radius" => '5px', */
                /* 'text-align' => 'left', */
                /* 'overflow-x' => 'wrap', */
                /* 'overflow-y' => 'auto', */
                /* 'align' => 'left', */
                /* 'margin' => 'auto', */
            );
    }
}

?>