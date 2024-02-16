<?php

trait MyMod_API_CLI_Process_Item_Is
{
    //* 
    //* 
    //*

    function API_CLI_Process_Item_Is(&$api_item)
    {
        $this->SigaA_Trim($api_item);

        $item=
            $this->Sql_Select_Hash
            (
                $this->API_CLI_Process_Item_Unique_Where($api_item)
            );

        $res=empty($item);
        
        $is_sigaz=False;
        if (!empty($item))
        {
            $is_sigaz=True;
            $api_item[ $this->__Item_Key__ ]=$item;
            $api_item[ "Status" ]="Exists in DB";     
        }
        else
        {
            $api_item[ "Status" ]="Not in DB";     
        }
        
        return $is_sigaz;
    }
    
    //* 
    //* 
    //*

    function API_CLI_Process_Item_Read(&$api_item)
    {
        return
            $this->Sql_Select_Hash
            (
                $this->API_CLI_Process_Item_Unique_Where($api_item)
            );
    }
    //* 
    //* Test consitency of $api_item prior to creation.
    //*

    function API_CLI_Process_Item_Test(&$api_item)
    {
        return True;
    }
}

?>