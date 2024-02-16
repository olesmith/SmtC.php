<?php

//include_once("Paging/Destinations.php");


trait MyMod_Items_Dynamic_Search
{
    //use
    //    MyMod_Items_Dynamic_Paging_Destinations;
    
    //*
    //* Search Table, if On in $group.
    //*

    function MyMod_Items_Dynamic_Search()
    {
        return
            array
            (
                "Search",
            );
    }
}

?>