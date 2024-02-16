<?php

trait Texts_Exec_Output
{
    //*
    //* Content of file with output.
    //*

    function Texts_Exec_Output_DIV($text)
    {
        $res=
            $this->Texts_Exec_Execute
            (
                $text
            );
                
        $html=
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->Htmls_DIV
                        (
                            "Output:",
                            array
                            (
                                "CLASS" => "Text_Exec_Output_Title",
                            )
                        ),
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
                                        join
                                        (
                                            "",
                                            $this->Texts_Exec_Output_Read
                                            (
                                                $text
                                            )
                                        )
                                    )
                                ),
                                array
                                (
                                    "CLASS" => "language-python",
                                )
                            )
                        ),
                    ),
                    array
                    (
                        "CLASS" => "Text_Exec_Output",
                    )
                ),
                $this->Texts_Exec_Info($text,$res),

                
            );

        return
            $this->Htmls_Tag
            (
                "CENTER",
                $html
            );
    }
    
    //*
    //* Content of file with output.
    //*

    function Texts_Exec_Output_Return_Code($text)
    {
        $res=-1;
        if (isset($text[ "File_Run_Res" ]))
        {
            $res=$text[ "File_Run_Res" ];
        }
        
        return intval($res);
            join
            (
                " ",
                $this->Texts_Exec_Execute_Command
                (
                    $text
                )
            ).
            ": ".
            intval($res);
    }
    
    //*
    //* Content of file with output.
    //*

    function Texts_Exec_Output_Read($text)
    {
        $output=array("-");

        $file=
            $this->Texts_Exec_Output_File_Name
            (
                $text
            );
        
        if (file_exists($file))
        {
            $output=$this->MyFile_Read($file);
        }

        return $output;
    }

    
    //*
    //* Name of file to pipe to.
    //*

    function Texts_Exec_Output_File_Name($text)
    {
        return
            preg_replace
            (
                '/\.[a-z]+$/',
                ".smtc",
                $this->Texts_Exec_File_Name($text)
            );
    }
}

?>