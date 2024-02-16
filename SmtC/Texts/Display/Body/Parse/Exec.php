<?php

trait Texts_Display_Body_Parse_Exec
{
    //*
    //* Try to execute file contents - via chroot.
    //*

    function Text_Display_Body_Parse_Exec($text)
    {
        $data="File";
        if
            (
                empty($text[ $data ])
                ||
                !preg_match('/File_'.$text[ "ID" ].'/',$text[ $data ])
            )
        {
            return array();
        }

        if
            (
                $this->Text_Is_Python($text)
                &&
                !empty($text[ $data ])
                &&
                $this->MyMod_Data_Fields_File_Exists($data,$text)
            )
        {
            return
                array
                (
                    $this->Texts_Exec_Output_DIV
                    (
                        $text
                    ),
                );
        }

        return "---";
    }

    

}

?>