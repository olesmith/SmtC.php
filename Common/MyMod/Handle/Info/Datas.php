<?php

trait MyMod_Handle_Info_Datas
{
    //*
    //* Datas (from DB table) to include in Info table.
    //*

    function MyMod_Handle_Info_Message_Datas($type)
    {
        return array("MTime");
    }
    
   //*
    //* Datas (from setup files) to include in Info table.
    //*

    function MyMod_Handle_Info_File_Datas($type)
    {
        return array("AccessMethod","EditAccessMethod");
    }

    var $__MyMod_Handle_Info_Profile_Datas__=array();
    
    //*
    //* Profiles data, including Person. Accessor for $__MyMod_Handle_Info_Profile_Datas__.
    //*

    function MyMod_Handle_Info_Profile_Datas()
    {
        if (empty($this->__MyMod_Handle_Info_Profile_Datas__))
        {
            $this->__MyMod_Handle_Info_Profile_Datas__=
                $this->MyMod_Handle_Info_Profile_Datas_Detect();
        }

        
        return $this->__MyMod_Handle_Info_Profile_Datas__;
    }
    
    //*
    //* Profiles data, including Person.
    //* Orders by 
    //*

    function MyMod_Handle_Info_Profile_Datas_Detect()
    {
        $rprofiles=array();
        foreach
            (
                preg_grep
                (
                    '/^(Public|Person|Admin)$/',
                    $this->ApplicationObj()->ValidProfiles,
                    PREG_GREP_INVERT
                )
                as $profile
            )
        {
            $key=
                sprintf("%06d",$this->Profile_Trust($profile)).
                "_".
                $profile;
            
            $rprofiles[ $key ]=$profile;
        }

        $keys=array_keys($rprofiles);
        sort($keys);
        
        $profiles=array();
        foreach ($keys as $key)
        {
            array_push
            (
                $profiles,
                preg_replace('/^\d+_/',"",$key)
            );
        }
        
        return
            array_merge
            (
                array
                (
                    "No",
                    "Message_Type",
                    "Message_Key",
                    //"Message",
                ),
                array("Public","Person"),
                $profiles,
                array("Admin"),
                array("Languages_Cell_Info")
            );
    }
}

?>