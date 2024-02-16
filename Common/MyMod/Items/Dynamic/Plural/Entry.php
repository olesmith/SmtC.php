<?php

trait MyMod_Items_Dynamic_Plural_Entry
{
    //*
    //* Create plural row.
    //*

    function MyMod_Items_Dynamic_Plural_Entry($items,$group,$action,$def)
    {
        return
            array
            (
                //"Tag" => "SPAN",
                "Hide" => False,
                
                "ID" => join("_",array($group,$action)),
                
                "Icon" => $this->MyMod_Item_Dynamic_Entry_Icon($def),

                "Title" => "title",
                
                "Onclick" => $this->MyMod_Items_Dynamic_Plural_Entry_JS
                (
                    $items,$group,$action,$def
                ),
                
                "Destination" =>
                $this->MyMod_Items_Dynamic_Plural_Destination_ID
                (
                    $items,$group,$action,$def
                ),
            );
    }

    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Plural_Entry_JS($items,$group,$action,$def)
    {
        return
            array
            (
                "//Load URL to destination element.",
                $this->JS_Load_URL_2_Element
                (
                    $this->MyMod_Items_Dynamic_Plural_Entry_Url
                    (
                        $items,$group,$action,$def
                    ),
                    $this->MyMod_Items_Dynamic_Plural_Destination_ID
                    (
                        $items,$group,$action,$def
                    ),
                    "",
                    0//debug-level
                ),
            );
    }

    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Plural_Entry_Url($items,$group,$action,$def)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                array_merge
                (
                    array
                    (
                        "ModuleName" => $def[ "Module" ],
                        "Action"     => $def[ "Action" ],
                        "RAW"        => 1,
                        "NoHorMenu"  => 1,
                        "NoSearch"   => 1,
                        "Dest"       =>
                        $this->MyMod_Items_Dynamic_Plural_Destination_ID
                        (
                            $items,$group,$action,$def
                        ),
                    ),
                    $this->MyMod_Item_Dynamic_Entry_Args(array(),$action,$def)
                )
            );
    }   
}

?>