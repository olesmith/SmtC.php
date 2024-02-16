<?php


trait MyApp_Interface_LeftMenu_Profile
{
    //*
    //* Prints menu of images, for user to select profile.
    //*

    function MyApp_Interface_LeftMenu_Profiles()
    {
        if ($this->LoginType=="Public") { return array(); }

        $links=array();

        foreach ($this->MyApp_CGIVars_Compulsory_Vars() as $var => $value)
        {
            $args[ $var ]=$value;
        }

        $trust=$this->MyApp_Profile_Trust();
        foreach ($this->AllowedProfiles() as $id => $profile)
        {
            array_push
            (
                $links,
                $this->MyApp_Interface_LeftMenu_Profile($profile)
            );
        }

        return $links;
    }
    //*
    //* Prints menu of images, for user to select profile.
    //*

    function MyApp_Interface_LeftMenu_Profile($profile)
    {
        $trust=$this->MyApp_Profile_Trust();

        $pname=$this->MyApp_Profile_Name($profile);

        //var_dump($profile);
        if ($profile!=$this->Profile())
        {
            $args=array();
            if ($this->MyApp_Profile_Trust($profile)>=$trust)
            {
                //Good guess, that we have privilege to access current actions
                $args=$this->CGI_URI2Hash();
            }
                
        foreach ($this->URL_CommonArgs as $var => $value)
        {
            if (empty($args[ $var ]))
            {
                $args[ $var ]=$value;
            }
        }

        //var_dump($this->URL_CommonArgs,$args);

            $args[ "Profile" ]=$profile;
            $args[ "Action" ]="Start";
            unset($args[ "Login" ]);
            unset($args[ "ModuleName" ]);
            unset($args[ "LastAction" ]);
                
            if ($profile=="Admin")
            {
                $args[ "Admin" ]=1;
            }
            elseif ($this->LoginType=="Admin")
            {
                $args[ "Admin" ]=0;
            }

            
            $link=
                $this->Htmls_Href
                (
                    "?".$this->CGI_Hash2Query($args),
                    $pname,
                    $this->MyLanguage_GetMessage("Profile_Change").
                    " ".
                    $pname,
                    "leftmenulinks",
                    $args=array(),
                    $otions=
                    array
                    (
                        "STYLE" => array
                        (
                            "font-size" => '75%',
                        )
                    )
                );
            }
            else
            {
                $link=
                    $this->Htmls_SPAN
                    (
                        "&nbsp;- ".$pname,
                        array(),
                        array("font-size" => '75%')
                    );
        }

        return $link;
    }
}

?>