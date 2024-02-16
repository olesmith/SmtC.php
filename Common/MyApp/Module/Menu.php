<?php

trait MyApp_Module_Menu
{   
    //*
    //* Generates hor  menu with  $module actions.
    //*

    function MyApp_Module_Menu_Horisontal()
    {
        $module=$this->ModuleName."Obj";
        $moduleobj=$this->$module();
        
        $menu=array();
        if (method_exists($moduleobj,"MyMod_Module_Menu_Horisontal"))
        {
            var_dump($module);
            $menu=$moduleobj->MyMod_Module_Menu_Horisontal();
        }

        return $menu;
    }
}

?>