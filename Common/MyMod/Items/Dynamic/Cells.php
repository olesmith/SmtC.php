<?php


trait MyMod_Items_Dynamic_Cells
{
    //*
    //* Generate the $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Cells($item,$group)
    {
        $row=array();

        foreach ($this->ItemDataGroups($group,"Dynamic") as $action => $cell)
        {
            array_push
            (
                $row,
                $this->MyMod_Item_Dynamic_Cell($group,$item,$action,$cell)
            );
        }

        return $row;
    }

    
    //*
    //* Finds suitable position, in where to put $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Cells_Position($group)
    {
        $pos=0;
        foreach ($this->MyMod_Items_Group_Data($group) as $data)
        {
            if (empty($this->ItemData[ $data ]))
            {
                $pos++;
            }
            else { break; }
        }

        return $pos;
    }
    
    //*
    //* Number of dynamic cells.
    //*

    function MyMod_Item_Dynamic_Cells_N($group)
    {
       return
           count($this->ItemDataGroups($group,"Dynamic"));
    }    
}

?>