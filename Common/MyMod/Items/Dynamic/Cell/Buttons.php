<?php


trait MyMod_Items_Dynamic_Cell_Buttons
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Buttons($group,$item,$action,$def,$load)
    {
        return
            array
            (
                $this->MyMod_Item_Dynamic_Cell_Button
                (
                    $group,$item,$action,$def,
                    $load,
                    False
                ),
                $this->MyMod_Item_Dynamic_Cell_Button
                (
                    $group,$item,$action,$def,
                    $load,
                    True
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Button($group,$item,$action,$def,$load,$hide_button)
    {
        return
            $this->Htmls_Tag
            (
                "BUTTON",
                $this->MyMod_Item_Dynamic_Cell_Icon
                (
                    $item,$action,$def,
                    $hide_button
                ),
                $this->MyMod_Item_Dynamic_Cell_Options
                (
                    $group,$item,$action,$def,
                    $load,
                    $hide_button
                )
            );
    }
}

?>