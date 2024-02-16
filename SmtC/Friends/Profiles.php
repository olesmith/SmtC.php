<?php

trait Friends_Profiles
{
    var $Profiles_Data=array();
    var $Profiles=array();
    
    //*
    //* Adds Profiles to ItemData
    //*

    function Profile_Datas_Add()
    {
        $profiles=$this->ApplicationObj()->GetProfiles();

        $profiledatadef=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Path().
                "/Friends/Data.Profiles.php"
            );

        $this->Profiles_Data=array();
        foreach ($this->ApplicationObj()->ValidProfiles as $profile)
        {
            if ($profile=="Public") { continue; }
            
            $profiledef=$profiles[ $profile ];
            
            $name=$this->LanguagesObj()->Language_Profile_Name_Singular($profile);
 
            $data="Profile_".$profile;
            $this->ItemData[ $data ]=$profiledatadef;

            foreach (preg_grep('/^Name/',array_keys($profiledef)) as $key)
            {
                $this->ItemData[ $data ][ $key ]=$profiledef[ $key ];
            }

            $this->Profiles_Data[ $data ]=True;
        }

        $this->Profiles_Data=array_keys($this->Profiles_Data);
        sort($this->Profiles_Data);
    }

    
    //*
    //* Detects $friendid profiles.
    //*

    function Friend_Profiles_Get($friendid)
    {
        if (is_array($friendid)) { $friendid=$friendid[ "ID" ]; }
        
        if (!isset($this->Profiles[ $friendid ]))
        {
            $friend=array("ID" => $friendid);
            $this->Sql_Select_Hash_Datas_Read($friend,$this->Profiles_Data);

            $this->Profiles[ $friendid ]=array();
            foreach ($this->Profiles_Data as $data)
            {
                if (intval($friend[ $data ])==2)
                {
                    array_push
                    (
                        $this->Profiles[ $friendid ],
                        preg_replace('/^Profile_/',"",$data)
                    );
                }
            }
        }

        return $this->Profiles[ $friendid ];
    }
    
    //*
    //* Detects max $friendid trust.
    //*

    function Friend_Profile_Trust($friendid)
    {
        $max_trust=0;
        foreach ($this->Friend_Profiles_Get($friendid) as $profile)
        {
            $max_trust=max($max_trust,$this->Profile_Trust($profile));
        }

        return $max_trust;
    }
    
    //*
    //* Detects max $friendid trust.
    //*

    function Friend_Profile_Highest($friendid)
    {
        $max_trust=0;
        $highest_profile="";
        foreach ($this->Friend_Profiles_Get($friendid) as $profile)
        {
            $trust=$this->Profile_Trust($profile);
            if ($trust>$max_trust)
            {
                $max_trust=$trust;
                $highest_profile=$profile;
            }
        }

        return $highest_profile;
    }
}

?>