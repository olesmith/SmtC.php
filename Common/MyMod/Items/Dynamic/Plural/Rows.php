<?php

trait MyMod_Items_Dynamic_Plural_Rows
{
    //*
    //* Plural row, below items table. For instance addrow.
    //* Create rows with plural dynamic actions, addind Area destination row.
    //*
    //* 20240212: Put back prints, SAdE Class Students/Discs.
    //*

    function MyMod_Items_Dynamic_Plural_Rows($items,$group,$extrarows)
    {
        /* $rows= */
        /*     array */
        /*     ( */
        /*         $this->MyMod_Items_Dynamic_Plural_Menu($items,$group), */
        /*         //$this->MyMod_Items_Dynamic_Destination_Plural_Rows($group), */
        /*     ); */
        
        /* if (count($extrarows)>0) */
        /* { */
        /*     $rows=array_merge($rows,$extrarows); */
        /* } */
        
        return
            array_merge
            (
                array
                (
                    $this->MyMod_Items_Dynamic_Plural_Menu($items,$group)
                ),
                //$this->MyMod_Items_Dynamic_Destination_Plural_Rows($group),
                $extrarows
            );
    }
}

?>