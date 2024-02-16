<?php

trait MyMod_Items_Dynamic_Plural_Destination
{
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Plural_Destination($items,$group,$action,$def)
    {
        return
            array
            (
                "Tag" => "DIV",
                "Display" => 'initial',
                "Hide"     => True,
                
                "ID"       => $this->MyMod_Items_Dynamic_Plural_Destination_ID
                (
                    $items,$group,$action,$def
                ),
                    
                
                "Title"     => "title",
                "Name"     =>  "name",
                
                "Contents" => "contents",
            );                
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Plural_Destination_ID($items,$group,$action,$def)
    {
        $dest=$this->ModuleName;
        if (!empty($_GET[ "Dest" ]))
        {
            $dest=$this->CGI_GET("Dest");
        }
        
        return join("_",array($dest,"Plural",$action));
    }
    
}

?>