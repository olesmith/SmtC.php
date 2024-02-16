<?php


trait MyMod_Items_Post
{
    //*
    //* function MyMod_Items_PostProcess, Parameter list: $ids=array()
    //*
    //* Calls post processor on each $items - or in not given, ItemHashes.
    //*

    function MyMod_Items_PostProcess($items=array(),$force=False)
    {
        $transfer=False;
        if (empty($items)) { $items=$this->ItemHashes; $transfer=True;}

        foreach (array_keys($items) as $id)
        {
            $items[$id]=$this->SetItemTime("ATime",$items[$id]);
            $items[$id]=$this->MyMod_Item_PostProcess($items[$id],$force);
        }

        if ($transfer)
        {
            $this->ItemHashes=$items;
        }
        
        return $items;
    }
}

?>