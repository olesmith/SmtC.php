<?php

include_once("HTML/Read.php");
include_once("HTML/Create.php");
include_once("HTML/Update.php");
include_once("HTML/Process.php");

trait Texts_Import_HTML
{
    use
        Texts_Import_HTML_Read,
        Texts_Import_HTML_Create,
        Texts_Import_HTML_Update,
        Texts_Import_HTML_Process;
    
    //*
    //* 
    //*

    function Text_Import_HTML_Subdirs($text,$path,$level=1)
    {
        foreach
            (
                $this->Dir_Subdirs($path)
                as $subdir
            )
        {
            $subtext=array("Src" => $subdir);
            
            $files=
                $this->Text_Import_HTML_Read_Files($subtext);

            if (!empty($files))
            {
                $this->Text_Import_HTML_Process_Subdir
                (
                    $text,$path,$subdir,$files,$level
                );
            }
        }
        
    }
    
}

?>