<?php

trait Texts_Import_Code
{
    var $__Import_Code_Files__=array();
    
    //*
    //* 
    //*

    function Text_Import_Code_File_Add($file)
    {
        $file=$this->MyFile_Name_Trim($file);

        if (!isset($this->__Import_Code_Files__[ $file ]))
        {
            $this->__Import_Code_Files__[ $file ]=0;
        }
        
        $this->__Import_Code_Files__[ $file ]++;
    }
    
    //*
    //* 
    //*

    function Text_Import_Code_Files_Process()
    {
        $files=array_keys($this->__Import_Code_Files__);
        sort($files);

        foreach ($files as $file)
        {
            $this->Text_Import_Code_File_Process($file);
        }
    }

    //*
    //* 
    //*

    function Text_Import_Code_File_Process($file)
    {
        print "\t".$file.", ".$this->__Import_Code_Files__[ $file ].": ";

        if (!file_exists($file))
        {
            print "file nonexistent\n";

            return False;
        }

        $code_text=
            $this->Text_Import_Code_File_Read($file);
        
        if (empty($code_text))
        {
            print "Create";

            $this->Text_Import_Code_File_Create($file);
        }
        else
        {
            print "Update";
            $this->Text_Import_Code_File_Update($code_text,$file);
        }

        print "\n";
    }

    //*
    //* 
    //*

    function Text_Import_Code_File_Read($file)
    {
        return
            $this->Sql_Select_Hash
            (
                array("Src" => $file)
            );        
    }
    
    //*
    //* 
    //*

    function Text_Import_Code_File_Create($file)
    {
         $text=
             array
             (
                 "Src"   => $file,
                 "Sort"  => basename($file),
                 "Name"  => basename($file),
                 "Title" => basename($file),

                 "Body" => $this->Text_Import_Code_File_Code($file),
                 "Type" => $this->Text_Type_No("Code"),
                 
                 "Code_Type" => $this->Text_Import_Code_File_Lang($file)
             );

         $this->Sql_Insert_Item($text);
    }

    //*
    //* 
    //*

    function Text_Import_Code_File_Update($code_text,$file)
    {
         $code_text=
             array_merge
             (
                 $code_text,
                 array
                 (
                     "Body"      => $this->Text_Import_Code_File_Code($file),
                     "Code_Type" => $this->Text_Import_Code_File_Lang($file)
                 )
             );

            
         $this->Sql_Update_Item_Values_Set
         (
             array("Body","Code_Type"),
             $code_text
         );
    }

    
    //*
    //* 
    //*

    function Text_Import_Code_File_Lang($file)
    {
         $lang=" 0";
         if (preg_match('/\.html/',$file))
         {
             $lang=1;
         }
         elseif (preg_match('/\.tex/',$file))
         {
             $lang=2;
         }
         elseif (preg_match('/\.py/',$file))
         {
             $lang=3;
         }
         else
         {
             print "Unknow language: $file\n";
         }
         
         return $lang;
    }
    //*
    //* 
    //*

    function Text_Import_Code_File_Code($file)
    {
         $code=
             join
             (
                 "",
                 $this->MyFile_Read($file)
             );
         $code=preg_replace('/\'/',"\"",$code);

         return $code;
    }
}
?>