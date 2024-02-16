<?php

trait Texts_Curve
{
    //*
    //* 
    //*

    function Text_Curve_Handle($text)
    {
        $dest="Text_DIV_".$text[ "ID" ];
        
        return
            array
            (
                $this->Text_Curves_Select($text),
                $this->Text_Curves_Scripts($text),
                
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                        "Curve_SVGs(".
                        $this->JS_Quote($dest).
                        ");"
                    ),
                    array
                    (
                        "type" => 'text/javascript',
                    )
                ),
            );
    }

    //*
    //* 
    //*

    function Text_Curves_Scripts($text)
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    $this->Text_Curve_JSs($text),
                    array
                    (
                        "type" => 'text/javascript',
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function Text_Curves_Select($text)
    {
        if ($this->CGI_GETint("Text")!=$text[ "ID" ])
        {
            return array();
        }

        $curve_texts=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Type" => $this->__Types__[ "Curve" ],
                ),
                array("ID","Name","Title"),
                "Name"
            );

        $url="?".$this->CGI_Hash2URI($_GET);
        
        return
            array
            (
                $this->Htmls_Select_Hashes_Field
                (
                    "Text",
                    $curve_texts,
                    array
                    (
                        "Selected" =>$text[ "ID" ],
                    ),
                    array
                    (
                        "ONCHANGE" => "Select_Reload(this,'".$url."');",
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function Text_Curve_JSs($text)
    {
        $jss=preg_split('/\s*,\s*/',$text[ "URL" ]);

        $lines=array();
        foreach ($jss as $js)
        {
            $lines=
                array_merge
                (
                    $lines,
                    $this->MyFile_Read($js)
                );
        }

        return $lines;
    }
}

?>