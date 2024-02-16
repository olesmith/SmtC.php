<?php


trait MyApp_Interface_Mobile_Menu_Profiles
{    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Profiles()
    {
        if ($this->Profile_Public_Is())
        {
            return array();
        }

        $current_profile=$this->Profile();

        
        return
            array
            (
                $this->Htmls_SPAN
                (
                    $this->MyApp_Profile_Name($current_profile),
                    array
                    (
                        "CLASS" => 'App_Menu_SPANs Profile_Link',
                        "ONCLICK" => array
                        (
                            $this->JS_Toggle_Elements_By_Class
                            (
                                "Profile_Links"
                            ),
                        )
                    )
                    
                ),
                
                $this->MyApp_Interface_Mobile_Menu_Profile_Links()
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Profile_Links()
    {
        $get=$this->CGI_URI2Hash();
        $current_profile=$this->Profile();
        
        $html=array();
        foreach ($this->MyApp_Profile_User_Profiles() as $profile)
        {
            if ($profile!=$current_profile)
            {
                $get[ "Profile" ]=$profile;
                $get[ "Action" ]="Start";
                $get[ "ModuleName" ]="Application";
                
                array_push
                (
                    $html,
                    $this->MyApp_Interface_Mobile_Menu_Profile_Link
                    (
                        $profile
                    ),
                    "|"
                );
            }
        }

        if (count($html)>1)
        {
            array_pop($html);
        }

        
        return
            $this->Htmls_DIV
            (
                array
                (
                    "[",
                    $html,
                    "]"
                ),
                array
                (
                    "CLASS" => 'App_Menu_SPANs Profile_Links',
                ),
                array
                (
                    "display" => 'none',
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Profile_Link($profile)
    {
        $get[ "Profile" ]=$profile;
        $get[ "Action" ]="Start";
        $get[ "ModuleName" ]="Application";

        return
            $this->Htmls_A
            (
                "?".
                $this->CGI_Hash2URI
                (
                    $this->MyApp_Interface_Mobile_Menu_Profile_URL
                    (
                        $profile
                    )
                ),
                $this->MyApp_Profile_Name($profile),
                $title="",
                array
                (
                    "CLASS" => 'App_Menu_SPANs Profile_Links',
                    "STYLE" => array
                    (
                        "display" => 'none',
                    )
                )
            );
    }
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Menu_Profile_URL($profile)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "Profile" => $profile,
                    "Action" => "Start",
                    "ModuleName" => "Application",
                )
            );
    }
 }

?>