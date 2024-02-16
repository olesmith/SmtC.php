<?php

include_once("Import/HTML.php");
include_once("Import/Code.php");

trait Texts_Import
{
    use
        Texts_Import_HTML,
        Texts_Import_Code;

        
    //*
    //* $text_id: key or Src
    //*

    function Text_Import($text_id)
    {
        $text=
            $this->Sql_Select_Hash
            (
                array("ID" => $text_id)
            );

        if (empty($text))
        {
            
            $text=
                $this->Sql_Select_Hash
                (
                    array("Src" => $text_id)
                );
        }

        print "Parent ".$text_id.": ";
        if (empty($text))
        {
            print "Text item not found\n";

            return;
        }

        print $text[ "Title" ]."\n";
        

        print "Src Path ".$text_id." ";
        if (!file_exists($text_id))
        {
            print "Non existent\n";
        }

        if (is_dir($text_id))
        {
            print "Directory\n";

            $this->Text_Import_Path($text,$text_id);
        }
        elseif (is_file($text_id))
        {
            print "File - ignored for now\n";
        }
        
        else
        {
            print "Unknown or Non existent\n";
        }
    }
    
    //*
    //* 
    //*

    function Text_Import_Path($text,$path)
    {
        $updatedatas=array();
        
        $files=
            $this->Text_Import_HTML_Read_Files($text);

        if (!empty($files))
        {
            $this->Text_Import_Update_Path($text,$path,$files);
            $this->Text_Import_HTML_Subdirs($text,$path);
        }

        $this->Text_Import_Code_Files_Process();
    }
    
    //*
    //* 
    //*

    function Text_Import_Update_Path($text,$path,$files=array())
    {
        //if (empty
        if (count($files)>0)
        {
            $this->Text_Import_HTML_Update_Path($text,$path,$files);
        }
    }
}

?>