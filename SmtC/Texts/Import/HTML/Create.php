<?php

trait Texts_Import_HTML_Create
{
    //*
    //* 
    //*

    function Text_Import_HTML_Create_Subdir($text,$path,$subdir,$files)
    {
        var_dump($subdir,$files);
        
        $child=
            array_merge
            (
                $text,
                $files,
                array
                (
                    "Src"       => $subdir,
                    "Type"      => $this->Text_Type_No("Code"),
                    "Code_Type" => 1,
                    "Parent"    =>  $text[ "ID" ],
                )
            );
        
        unset($child[ "ID" ]);
        $child[ "Body" ]="";
        if (!empty($child[ "Contents" ]))
        {
            $child[ "Body" ]=$child[ "Contents" ];
            unset($child[ "Contents" ]);
        }

        $this->Sql_Insert_Item($child);

        return $child;
    }
    
}

?>