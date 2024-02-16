<?php

trait MyMod_API_CLI_Process_Item_Create
{
    //*
    //* Update $api_item.
    //*

    function API_CLI_Process_Item_Create($api_item)
    {
        $item=
            array
            (
                $this->SigaZ_Args_Key() => $api_item[ $this->SigaA_Args_Key() ],
            );

        foreach (array_keys($this->ItemData) as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Default" ]))
            {
                $item[ $data ]=$this->ItemData[ $data ][ "Default" ];
            }
        }
        
        $this->API_CLI_Process_Item_Update($api_item,$item);

        $this->Sql_Insert_Item($item);

        return $item;
    }
 }

?>