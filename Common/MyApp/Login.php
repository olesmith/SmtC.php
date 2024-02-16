<?php

include_once("Login/Headers.php");
include_once("Login/Table.php");
include_once("Login/Html.php");
include_once("Login/Form.php");
include_once("Login/Retrieve.php");
include_once("Login/Password.php");

trait MyApp_Login
{
    use
        MyApp_Login_Headers,
        MyApp_Login_Table,
        MyApp_Login_Html,
        MyApp_Login_Form,
        MyApp_Login_Retrieve,
        MyApp_Login_Password;
    
    //*
    //* Initializes login subsystem.
    //*

    function MyApp_Login_Init()
    {
        $this->LoginType="Public";
        $this->__Profile__="Public";
        if ($this->Authentication)
        {
            $this->AuthHash();

            $this->MyApp_Login_Detect();
            $this->MyApp_Profile_Detect();

            if (method_exists($this,"MyApp_Login_Post"))
            {
                $this->MyApp_Login_Post();
            }
        }
    }

    //*
    //* Sets LoginData to $logindata. Also sets LoginData, LoginID and Login
    //*

    function MyApp_Login_SetData($logindata)
    {
        if (is_array($logindata) && count($logindata)>0)
        {
            $this->LoginData=$logindata;
           
            $this->MyApp_Login_Detect();
            
            $this->MyApp_Profile_Allowed_Detect();

            $this->MyApp_Profile_From_Login_Data();

            $this->MyApp_Profile_Detect();
        }
    }

    //*
    //* Update User Language.
    //*

    function MyApp_Login_Set_User_Language()
    {
        if (method_exists($this,"FriendsObj"))
        {
            $this->FriendsObj()->ItemData();
            if (!empty($this->FriendsObj()->ItemData[ "Language" ]))
            {
                $clang=$this->CGI_GET("Lang");

                if (!empty($clang))
                {
                     if ($this->LoginData[ "Language" ]!=$clang)
                     {
                         if (!empty($this->Languages[ $clang ]))
                         {
                             $this->LoginData[ "Language" ]=$clang;
                             $this->FriendsObj()->Sql_Update_Item_Value_Set
                             (
                                $this->LoginData("ID"),
                                "Language",
                                $clang
                             );
                         }
                     }
                }
                     
                //Take user language settings.
                if (!empty($this->LoginData[ "Language" ]))
                {
                    $this->MyLanguage_Set($this->LoginData[ "Language" ]);
                }
           }
        }
    }


    //*
    //* Detects login type (Public, Person, Admin), return
    //* values are 2,1 and 0 resp.
    //*

    function MyApp_Login_Detect()
    {
        $this->LoginType="Public";
        $res=2;

        if ($this->LoginData)
        {
            $action=$this->GetCGIVarValue("Action");
            $admin=$this->GetCGIVarValue("Admin");
        
            $this->LoginID=$this->LoginData[ "ID" ];
            $this->Login=$this->LoginData[ $this->AuthHash[ "LoginField" ] ];
            if ($action=="Admin" || $admin==1)
            {
                if ($this->MyApp_Profile_MayBecomeAdmin())
                {
                    $this->LoginType="Admin";
                    $res=0;
                }
            }
            elseif ($this->LoginID>0)
            {
                $this->LoginType="Person";
                $res=1;       
            }

            $this->MyApp_Login_Set_User_Language();
        }
        
        return $res;
    }
    
    //*
    //* Detects if default domain is set in AuthHash.
    //*

    function MyApp_Login_Default_Domain()
    {
        $domain=$this->AuthHash("Default_Domain");
        if (empty($domain))
        {
            $domain=False;
        }

        return $domain;
    }

    //*
    //* Does logoff, that is, resets the SID cookie and other cookies,
    //* writes a messgae containing link to login and exits.
    //*

    function MyApp_Logoff_Do()
    {
        $this->LoginType="Public";
        $this->MyApp_Log_Entry("Logged off");
        
        $this->CookieTTL=time()-60*60; //in the past to disable

        $unit=$this->GetCGIVarValue("Unit");

        $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
        $this->MakeCGI_Cookie_Set("Admin","",time()-$this->CookieTTL);
        $this->MakeCGI_Cookie_Set("ModuleName","",time()-$this->CookieTTL);

        /* $this->MyApp_Profile_Cookie_Send($profile="",-$this->CookieTTL); */
        
       //Delete entry en session table
        if (isset($this->SessionData[ "SID" ]))
        {
            $this->MyApp_Session_SID_Delete($this->SessionData[ "SID" ]);
        }

        $this->MakeCGI_Cookies_Reset();

        $this->LoginType="Public";
        $this->__Profile__="Public";

        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);
        $query=$this->CGI_Hash2Query($args);

        $this->CGI_CommonArgs_Add($args);
        $args[ "Action" ]="Start";

        $this->MyApp_CGI_Reload_Try($args);

        //Shouldn't get here!!
        exit();
    }

}

?>