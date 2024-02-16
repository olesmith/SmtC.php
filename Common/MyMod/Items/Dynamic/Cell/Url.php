<?php


trait MyMod_Items_Dynamic_Cell_Url
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Url($group,$item,$action,$def)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                array_merge
                (
                    $this->MyMod_Item_Dynamic_Cell_Args($item,$action,$def),
                    array
                    (
                        "ModuleName" => $def[ "Module" ],
                        "Action"     => $def[ "Action" ],
                        "Dest"       => $this->MyMod_Item_Dynamic_Destination_Cell_ID($item,$group),
                    )
                )
            );
    }   
}

?>