<?php

include_once("Cell/JS.php");
include_once("Cell/Icon.php");
include_once("Cell/Args.php");
include_once("Cell/Url.php");
include_once("Cell/Buttons.php");
include_once("Cell/Classes.php");
include_once("Cell/Options.php");

trait MyMod_Items_Dynamic_Cell
{
    use
        MyMod_Items_Dynamic_Cell_JS,
        MyMod_Items_Dynamic_Cell_Icon,
        MyMod_Items_Dynamic_Cell_Args,
        MyMod_Items_Dynamic_Cell_Url,
        MyMod_Items_Dynamic_Cell_Buttons,
        MyMod_Items_Dynamic_Cell_Classes,
        MyMod_Items_Dynamic_Cell_Options;
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell($group,$item,$action,$def,$load=False)
    {
        $class  = $def[ "Module" ];
        $module = $def[ "Module" ];
        $raction = $def[ "Action" ];
        //$icon   = $def[ "Icon" ];
        $gets   = $def[ "GETs" ];
        
        $moduleobj=$module."Obj";
        $res=
            $this->$moduleobj()->MyAction_Allowed($raction,$item);

        //Return empty, if not allowed by $module $action
        if (!$res) { return array(); }
                
        return
            $this->MyMod_Item_Dynamic_Cell_Buttons
            (
                $group,$item,$action,$def,$load
            );

    }
    
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_ID($item,$action,$def)
    {
        $id="";
        if (!empty($item[ "ID" ])) { $id=$item[ "ID" ]."_"; }
        
        return
            $this->ModuleName.
            "_".
            $id.
            $def[ "Action" ].
            "";
    }
    
    
}

?>