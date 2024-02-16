<?php

trait Texts_Display_Body_Parse_File
{    
    //*
    //* Reads $text[ $fdata ] as file and generates code exhibit.
    //*

    function Text_Display_Body_Parse_File($text)
    {
        $fdata="File";
        $pdata="Path";
        if
            (
                empty($text[ $fdata ])
                ||
                !preg_match('/File_'.$text[ "ID" ].'/',$text[ $fdata ])
            )
        {
            return array();
        }
        
        $lines=
            $this->Text_Display_Body_Parse_File_Lines_Read($text,$fdata);

        if (empty($lines)) { return array(); }

        $text=
            $this->Sql_Select_Hash
            (
                array("ID" => $text[ "ID" ])
            );

        
        return
            $this->Htmls_Text
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->Htmls_DIV
                        (
                            $this->Text_Display_Body_Parse_File_HREF
                            (
                                $text,$fdata,$pdata
                            ),
                            array
                            (
                                "CLASS" => "Text_File_Info",
                            )
                        ),
                        $this->Text_Display_Body_Parse_File_Lines_PRE_CODE
                        (
                            $text,
                            $lines
                        ),
                    ),
                    array
                    (
                        "CLASS" => array
                        (
                            "File_".$this->Text_Display_Code_ID($text),
                            "Text_Code",
                        ),
                    )
                )
            );        
    }

    //*
    //* Download link to file.
    //*

    function Text_Display_Body_Parse_File_HREF($text,$fdata,$pdata)
    {
        $url=
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "Action" => "Download" ,
                    "Text" => $text[ "ID" ],
                    "Data" => "File",
                )
            );
        $file=
            $this->Text_Display_Body_Parse_File_Title
            (
                $text,$fdata,$pdata
            );

        return
            array
            (
                $this->Htmls_A
                (
                    $url,
                    $file,
                    "Download ".$file
                ),
                "-",
                $this->Text_Display_Body_Parse_File_Info
                (
                    $text,$fdata,$pdata
                ),
            );
    }
    
    //*
    //* Title to exibit with path, name.
    //*

    function Text_Display_Body_Parse_File_Title($text,$fdata,$pdata)
    {
        $rdata= $fdata."_OrigName";
        
        $titles=array();
        if (!empty($text[ $pdata ]))
        {
            array_push($titles,$text[ $pdata ]);
        }

        array_push($titles,$text[ $rdata ]);

        return join("/",$titles);
    }
    
    //*
    //* Title to exibit with path, name.
    //*

    function Text_Display_Body_Parse_File_Info($text,$fdata,$pdata)
    {
        $file=
            $this->MyMod_Data_Fields_File_FileName($fdata,$text);
        
        $lines=$this->MyFile_Read($file);
        
        $size=0;
        foreach ($lines as $line) { $size+=strlen($line); }
        
        $info=
            array
            (
                count($lines)." lines",
                $size." bytes",
                $this->MyFile_Date_Time(filemtime($file))
            );
        
        return join(", ",$info).".";
    }
    
    //*
    //* 
    //*

    function Text_Display_Body_Parse_File_Lines_Read($text,$fdata)
    {
        $lines=array();
        if (!empty($text[ $fdata ]))
        {
            $file=
                $this->MyMod_Data_Fields_File_FileName($fdata,$text);

            if (file_exists($file))
            {
                $lines=
                    $this->MyFile_Read($file);
            }
        }
        
        return $lines;
    }
    
    //*
    //* 
    //*

    function Text_Display_Body_Parse_File_Lines_PRE_CODE($text,$lines)
    {
        return
            $this->Html_Tags
            (
                "PRE",
                $this->Html_Tags
                (
                    "CODE",  
                    htmlentities
                    (
                        preg_replace
                        (
                            '/&#039;/',
                            " ",
                            join("",$lines)
                        )
                    ),
                    array
                    (
                        "CLASS" => $this->Text_Display_Code_CLASS_HighLight($text),
                    )
                ),
                array
                (
                    "CLASS" => "Text_Code",
                )
            );
    }

    
}

?>