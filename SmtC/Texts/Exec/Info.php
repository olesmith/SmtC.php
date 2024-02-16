<?php

trait Texts_Exec_Info
{
    //*
    //* Generate Execution info.
    //*

    function Texts_Exec_Info($text,$res)
    {
        return
            $this->Htmls_DIV
            (
                $this->Texts_Exec_Info_Html($text,$res),
                array
                (
                    "CLASS" => "Text_Exec_Info",
                )
            );
    }
    
    //*
    //* Execute info html.
    //*

    function Texts_Exec_Info_Html($text,$res)
    {
        return
            array
            (
                $this->Htmls_Table
                (
                    "",
                    $this->Texts_Exec_Info_Table($text,$res),
                    array
                    (
                        "CLASS" => "Text_Exec_Info",
                    ),
                    array
                    (
                        "CLASS" => "Text_Exec_Info",
                    ),
                    array
                    (
                        "CLASS" => "Text_Exec_Info",
                    )
                ),
            );
    }
    
    //*
    //* Execute info table (matrix).
    //*

    function Texts_Exec_Info_Table($text,$res)
    {
        return
            array
            (
                array
                (
                    "Status:",
                    $res
                ),
                array
                (
                    "Return code:",
                    $this->MyMod_Data_Field
                    (
                        0,$text,
                        "File_Run_Res"
                    ),
                ),
                array
                (
                    "Execute File:",

                    $file=$this->Texts_Exec_File_Name($text),
                    $this->TimeStamp
                    (
                        $this->MyFiles_MTime($file)
                    ),
                ),
                array
                (
                    "Output File:",

                    $file=$this->Texts_Exec_Output_File_Name($text),
                    $this->TimeStamp
                    (
                        $this->MyFiles_MTime($file)
                    ),
                ),
                array
                (
                    $this->Texts_Exec_Execute_Command($text)
                )
            );
    }
}

?>