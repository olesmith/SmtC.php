<?php


trait MyMod_Items_Dynamic_Cell_Classes
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Classes($item,$action,$def,$hide_button)
    {        
        $pre="_Show_";
        if ($hide_button) { $pre="_Hide_"; }
        
        $classes=array($pre,$this->ModuleName,$action);

        if (!empty($item[ "ID" ]))
        {
            array_push($classes,$item[ "ID" ]);
        }
        
        return $classes;
    }
}

?>