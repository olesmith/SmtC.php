<?php


trait MyMod_Items_Dynamic_Cell_Icon
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Icon($item,$action,$def,$hide_button)
    {
        $icon="";
        if (!empty($def[ "Icon" ]))
        {
            $icon=$def[ "Icon" ];
        }
        else
        {
            $module = $def[ "Module" ];
            $raction = $def[ "Action" ];
        
            $moduleobj=$module."Obj";
            $icon=
                $this->$moduleobj()->Actions($raction,"Icon");          
        }
        
        $options=array();
        if ($hide_button)
        {
            $options[ "COLOR" ]="blue";
        }

        //var_dump();
        if (is_string($icon))
        {
            $icon=
                $this->MyMod_Interface_Icon
                (
                    $icon,
                    $options
                );            
        }
        elseif (is_array($icon))
        {
            $icon=
                $this->MyMod_Interface_Icons
                (
                    $icon,
                    1,
                    $options
                );            
        }

        return $icon;
    }
}

?>