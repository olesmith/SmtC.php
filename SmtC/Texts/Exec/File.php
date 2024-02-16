<?php

trait Texts_Exec_File
{    
    //*
    //* Prepare file in chrooted copy
    //*

    function Texts_Exec_File_Prepare($text)
    {
        $res=False;
        if ($this->Texts_Exec_Path_Absolute_Create($text))
        {
            $src_file=
                $this->MyMod_Data_Fields_File_FileName("File",$text);
            
            $res=True;

            $dest_file=
                $this->Texts_Exec_File_Name($text);

            if (file_exists($src_file))
            {
                $src_time=$this->MyFiles_MTime($src_file);
                $dest_time=$this->MyFiles_MTime($dest_file);

                if ($dest_time<$src_time)
                {
                    $this->System_Run
                    (
                        array
                        (
                            //"echo",
                            "/bin/cp",
                            $src_file,
                            $dest_file
                        ),
                        $echo=True
                    );
                }
                else
                {
                    //var_dump($dest_file.": ".$dest_time." --> ".$src_time);
                }
            }
                
            $res=file_exists($dest_file);
        }

        return $res;     
    }
    
    //*
    //* file name with change root
    //*

    function Texts_Exec_File_Name($text)
    {
        $text=
            $this->Sql_Select_Hash
            (
                array("ID" => $text[ "ID" ])
            );
        
        $file="";
        if (!empty($text[ "File_OrigName" ]))
        {
            $file=
                join
                (
                    "/",
                    array
                    (
                        $this->Texts_Exec_Path_Absolute($text,"Path"),
                        $text[ "File_OrigName" ]
                    )
                );
        }

        return $file;
    }
}

?>