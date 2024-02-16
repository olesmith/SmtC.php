<?php

trait Texts_Import_HTML_Process
{
    //*
    //* 
    //*

    function Text_Import_HTML_Process_Subdir($text,$path,$subdir,$files,$level)
    {
        $subdir=preg_replace('/\/+/',"/",$subdir);
        
        $child=
            $this->Sql_Select_Hash
            (
                array("Src" => $subdir)
            );

        if (empty($child))
        {
            print "Create $subdir\n";
            $this->Text_Import_HTML_Create_Subdir
            (
                $text,$path,$subdir,$files
            );
        }
        else
        {
            print "Exists $subdir\n";

            $this->Text_Import_HTML_Update_Path($child,$subdir);

            $this->Text_Import_HTML_Subdirs($child,$subdir,$level+1);
            
        }
    }
}

?>