<?php

trait MyMod_API_CLI_Process_Item_Update
{
    //*
    //* Update $api_item.
    //*

    function API_CLI_Process_Item_Update($api_item,&$item)
    {
        $updatedatas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Key" ]))
            {
                $value=
                    $this->API_CLI_Process_Item_Update_Data
                    (
                        $api_item,
                        $item,
                        $data
                    );
                if
                    (
                        !empty($value)
                        &&
                        (
                            empty($item[ $data ])
                            ||
                            $item[ $data ]!=$value
                        )
                    )
                {
                    //print $data.": ".$value."\n";
                    $item[ $data ]=$value;
                    array_push($updatedatas,$data);
                }
            }
        }

        return $updatedatas;
    }
    
    //*
    //* Update $api_item $data.
    //*

    function API_CLI_Process_Item_Update_Data($api_item,&$item,$data)
    {
        $value="";
        if (!empty($this->ItemData[ $data ][ "Key" ]))
        {
            foreach ($this->ItemData[ $data ][ "Key" ] as $key)
            {
                if
                    (
                        isset($api_item[ $key ])
                        &&
                        is_string($api_item[ $key ])
                    )
                {
                    $value=$api_item[ $key ];
            
                    if (!empty($this->MyMod_Data_Field_Is_Module($data)))
                    {                        
                        $value=
                            $this->API_CLI_Process_Item_Update_Data_Module
                            (
                                $api_item,$item,
                                $data,$value
                            );
                    }
                    else
                    {
                        $value=
                            preg_replace
                            (
                                '/\'/',"&#39;",
                                $this->Text2Html($value)
                            );                        
                    }

                    break;
                }
                #else {print "KEY UNDEF\n"; }
            }
        }

        return $value;
    }
    
    //*
    //* Get module from $data, read subitem and return .
    //*

    function API_CLI_Process_Item_Update_Data_Module($api_item,&$item,$data,$rvalue)
    {
        $module_obj=
            $this->MyMod_Data_Fields_Module_2Object($data);


        $where=
            array
            (
                $module_obj->SigaZ_Args_Key() => $rvalue,
            );

        $subitem=
            $module_obj->Sql_Select_Hash
            (
                array
                (
                    $module_obj->SigaZ_Args_Key() => $rvalue,
                ),
                array("ID")
            );
        
        $value=" 0";
        if (!empty($subitem) && !empty($subitem[ "ID" ]))
        {
            $value=$subitem[ "ID" ];
        }

        return $value;
    }
}

?>