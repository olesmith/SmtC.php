<?php

include_once("Item/Is.php");
include_once("Item/Read.php");
include_once("Item/Unique.php");
include_once("Item/Create.php");
include_once("Item/Update.php");

include_once("Common/JSON.php");


trait MyMod_API_CLI_Process_Item
{
    var $__Item_Key__="SigaZ";
    use
        MyMod_API_CLI_Process_Item_Is,
        MyMod_API_CLI_Process_Item_Read,
        MyMod_API_CLI_Process_Item_Unique,
        MyMod_API_CLI_Process_Item_Create,
        MyMod_API_CLI_Process_Item_Update;

    
    //*
    //* Process one $api_item.
    //*

    function API_CLI_Process_Item($api_item)
    {
        $api_key=$this->SigaA_Args_Key();
        
        if (empty($api_item[ $api_key ]))
        {
            //$this->API_Message("API id ".$api_id." ".$api_key." unset",2);
            $this->__API_Empty_API_ID__++;
            
            return array();
            
        }

        $api_id=$api_item[ $api_key ];

        //Module specific pre processor
        $this->API_CLI_Process_Item_Pre($api_item);

        $created=False;
        
        $item=array();
        if ($this->API_CLI_Process_Item_Is($api_item))
        {
            $item=
                $this->API_CLI_Process_Item_Read($api_item);
            
            $this->API_Message
            (
                "API id ".$api_id." unique in DB: ID='".$item[ "ID" ]."'",
                0
            );
        }
        else
        {
            if ($this->API_CLI_Process_Item_Test($api_item))
            {
                $created=True;
                
                $item=
                    $this->API_CLI_Process_Item_Create($api_item);

                $this->API_Message("API id ".$api_id." created",1);
            
                $this->__API_Created__++;
            }
            else
            {
                $this->API_Message("API id ".$api_id." invalid",5);
                
                $this->__API_Invalid__++;
            }
        }

        
        if (!empty($item))
        {
            $this->__API_Processed__++;
            
            $updatedatas=
                $this->API_CLI_Process_Item_Update($api_item,$item);

            $rupdatedatas=$updatedatas;
            
            unset($api_item[ "SigaZ" ]);
            $json=json_encode($api_item,JSON_PRETTY_PRINT);

            $data="Sigaa_Text";
            if (empty($item[ $data ]) || $item[ $data ]!=$json)
            {
                $item[ $data ]=$json;
                array_push($rupdatedatas,$data);
            }

            if (count($rupdatedatas)>0)
            {
                $this->__API_Updated__++;
                $this->Sql_Update_Item_Values_Set($updatedatas,$item);
            }

            if (count($updatedatas)>0)
            {
                $texts=array("API id ".$api_id." updated");
                foreach ($updatedatas as $data)
                {
                    array_push
                    (
                        $texts,
                        "\t".
                        $data.": ".
                        $item[ $data ]
                    );
                }
                
                $this->API_Message
                (
                    $texts,                    
                    1
                );
            }

            //Module specific post processor
            $this->API_CLI_Process_Item_Post($api_item,$item);
        }
        else
        {
            $this->__API_Empty__++;
            $this->API_Message("API id ".$api_id." empty",1);
        }

        return $item;
        
    }

    
    //*
    //* Preprocess $api_item: Calls API_CLI_Pre_Process_Item, if defined.
    //*

    function API_CLI_Process_Item_Pre(&$api_item)
    {
        $method="API_CLI_Pre_Process_Item";
        if (method_exists($this,$method))
        {            
            $this->$method($update=True,$api_item);
        }
    }
    
    //*
    //* Postprocess $api_item: Calls API_CLI_Post_Process_Item, if defined.
    //*

    function API_CLI_Process_Item_Post(&$api_item,&$item)
    {
        $method="API_CLI_Post_Process_Item";
        if (method_exists($this,$method))
        {            
            $this->$method($api_item,$item);
        }
    }
    
}

?>
