<?php


trait MyMod_Items_Dynamic_Cell_Options
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Options($group,$item,$action,$def,$load,$hide_button)
    {
        $moduleobj=$def[ "Module" ]."Obj";

        //$this->MyMod_Item_Dynamic_Cell_JS_Add($item,$action,$def);
        
        $options=
            array
            (
                "ID"    => $this->MyMod_Item_Dynamic_Cell_ID
                (
                    $item,$action,$def
                ),
                "TYPE"  => 'button',
                "CLASS"  => $this->MyMod_Item_Dynamic_Cell_Classes
                (
                    $item,$action,$def,
                    $hide_button
                ),
                
                "TITLE" =>
                $this->$moduleobj()->MyActions_Entry_Title
                (
                    $def[ "Action" ]
                ).
                "\n\n\nURL: ".
                $this->MyMod_Item_Dynamic_Cell_Url
                (
                    $group,$item,$action,$def
                ).
                "\n\nCell ID: ".
                $this->MyMod_Item_Dynamic_Destination_Cell_ID
                (
                    $item,$group
                ).
                "\n\nClasses: ".
                join
                (
                    " ",
                    $this->MyMod_Item_Dynamic_Cell_Classes
                    (
                        $item,$action,$def,
                        $hide_button
                    )
                ).
                "",
            );
        
        if ($hide_button)///???
        {
            $options[ "STYLE" ]="display: none;";
        }
        
        $options[ "ONCLICK" ]=
            $this->MyMod_Item_Dynamic_Cell_JS_OnClick
            (
                $group,$item,$action,$def,$load,$hide_button
            );

        //var_dump($options);
        
        return $options;
    }
}

?>