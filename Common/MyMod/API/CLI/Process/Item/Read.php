<?php

trait MyMod_API_CLI_Process_Item_Read
{
    //*
    //* Reads $api_id from API.
    //*

    function API_CLI_Process_Item_Read_Or_Create($api_id,$datas)
    {
        $item=
            $this->Sql_Select_Hash
            (
                array
                (
                    "Sigaa_ID" => $api_id,
                ),
                $datas
            );

        if (empty($item))
        {
            echo
                $this->ModuleName."#Retrieve APÌ: ".$api_id;

            $api_item=
                $this->API_CLI_Process_Item_Read_API($api_id);

            //var_dump($api_item);

            if
                (
                    !empty($api_item)
                )
            {
                print "Success\n";
                $item=
                    $this->API_CLI_Process_Item
                    (
                        $api_item
                    );
            }
            else
            {
                print "Fail\n";
            }
        }

        return $item;
    }

    
    //*
    //* Reads $api_id from API.
    //*

    function API_CLI_Process_Item_Read_API($api_id)
    {
       return
           $this->SigaA_Read_Item($api_id);
    }
}

?>