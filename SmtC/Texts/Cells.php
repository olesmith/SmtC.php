<?php

trait Texts_Cells
{
    //*
    //* 
    //*

    function  Text_Cell_NChildren($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return
                array
                (
                    //"Nº",
                    $this->MyActions_Entry_Title("Children")
                );
        }
        
        $descendents=
            $this->Text_Descendent_IDs($item);
        
        return
            $this->Text_NChildren($item).
            "/".
            count($descendents);
    }
    
    //*
    //* 
    //*

    function  Text_Cell_File($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return
                array
                (
                    "Original Name",
                );
        }

        $cell="-";
        if (!empty($item[ "File_OrigName" ]))
        {
            $cell=$item[ "File_OrigName" ];
        }
        
        return $cell;
    }
}

?>