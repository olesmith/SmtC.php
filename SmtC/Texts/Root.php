<?php


trait Texts_Root
{
    //*
    //* Text_Root_Handle handler.
    //*

    function Text_Root_Handle($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }

        if (!empty($text[ "File" ]))
        {
            if (preg_match('/\.(png|jpg|svg)$/',$text[ "File" ]))
            {
                $this->Htmls_Echo
                (
                    $this->Center
                    (
                        $this->Html_IMG
                        (
                            "?".
                            $this->CGI_Hash2URI
                            (
                                array
                                (
                                    "ModuleName" => "Texts",
                                    "Action" => "Download",
                                    "Data" => "File",
                                    "ID" => $text[ "ID" ],
                                    "T" => time(),
                                )
                            )
                        )
                    )
                );
            }
        }

        $this->Text_Display_Handle($text);        
    }

    
}

?>