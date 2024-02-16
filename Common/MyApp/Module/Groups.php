<?php

trait MyApp_Module_Groups
{
    //*
    //* Returns list of  $module group actions.
    //*

    function MyApp_Module_Group_Actions($moduleobj)
    {
        $module=$moduleobj->ModuleName;
        
        $actions=array();
        if (!empty($this->Module2Groups[ $module ]))
        {
            $group=$this->Module2Groups[ $module ];
            if (!empty($this->ModuleGroups2Actions[ $group ]))
            {
                $actions=$this->ModuleGroups2Actions[ $group ][ "Actions" ];
            }

        }

        return $actions;
    }
    
    //*
    //* Returns list of  $module group allowed actions.
    //*

    function MyApp_Module_Group_Actions_Allowed($moduleobj)
    {
        return $this->MyApp_Module_Group_Actions($moduleobj);
    }
    
    //*
    //* Generates hor  menu with  $module actions.
    //*

    function MyApp_Module_Group_Menu_Horisontal($moduleobj)
    {
        $actions=$this->MyApp_Module_Group_Actions_Allowed($moduleobj);

        $menu=array();
        if (count($actions)>0)
        {
            $menu=$this->MyMod_HorMenu_Actions($actions);
        }

        return $menu;
    }
}

?>