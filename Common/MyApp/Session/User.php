<?php


trait MyApp_Session_User
{
    //*
    //* SID set:
    //*  - Call TestUserSID, verifying SID validity
    //*    - if valid: set logindata and sessiondata and return
    //*    - else: BaddGuys, exit!
    //* else:
    //* If logon requested or required:
    //* - If given, validate logondata:
    //*   - if valid:
    //*      - create SID and session
    //*      - update Session DB
    //*      - Retrieve logindata from session data
    //*   - else:
    //*      - call MyApp_Login_Form and exit
    //*

    function MyApp_Session_User_Init()
    {
        $this->GoHTTPS();
        if (!$this->MyApp_Session_User_Init_By_SID())
        {
            $this->MyApp_Session_User_Init_By_Auth();
        }
    }
    
    //*
    //*
    //*

    function MyApp_Session_User_Init_By_SID()
    {
        if (isset($_COOKIE[ "SID" ]))
        {
            $sid=$this->CGI_COOKIE("SID");
        
            if ($this->MyApp_Session_User_TestSID($sid))
            {
                $this->MyApp_Session_SID_2LoginData($sid);
                $this->MyApp_Session_SID_Update($sid);


               global $SessionInitialized;
               $SessionIntialized=1;
            }
            else
            {
                $this->MyApp_Session_SID_Delete($sid);
                $this->MyApp_Login_Form
                (
                    $this->MyLanguage_GetMessage("Expired")
                );
            }
            
            return TRUE;
        }

        return FALSE;
    }
    
    //*
    //* Try to authenticate, if requested by CGI: Action=Logon.
    //* Force uthentication, unless $this->PublicAllowed.
    //*

    function MyApp_Session_User_Init_By_Auth()
    {
        $authok=0;
        $action=$this->GetGETOrPOST("Action");

        if ($action=="Logon")
        {
            //Logon requested
            $authok=$this->MyApp_Session_Auth();

            $this->MyApp_Log_Entry("Autenticated");
        }
        elseif ($this->PublicAllowed)
        {
            return;
        }
        else
        {
            //Logon required
            $authok=$this->MyApp_Session_Auth();
        }

        
        if ($authok>0)
        {
            $sid=$this->MyApp_Session_SID_Create();
            
            $this->MyApp_Interface_Message_Add("SiD NEW".$sid);

        
            $this->MyApp_Session_SID_2LoginData($sid);

            global $SessionInitialized;
            $SessionIntialized=1;
        }
        elseif
            (
                $this->CGI_POST("Login")
                ||
                $this->CGI_POST("Password")
            )
        {
            $this->HtmlStatus=
                $this->MyLanguage_GetMessage("InvalidPassword");

            $this->RegisterBadLogon();
        }
    }


    //*
    //* Tests if SID privided by cookies is valid.
    //* Returns TRUE on success and FALSE on failure.
    //* On sucess SessionData hash is populated.
    //*

    function MyApp_Session_User_TestSID($sid)
    {
        if (preg_match('/^\d+$/',$sid) && $sid>0)
        {
            $this->MyApp_Session_SID_Read($sid);
  
            if (is_array($this->Session) && count($this->Session)>0)
            {
                if ($this->Session[ "SID" ]==$sid)
                {
                    $time=time();
                    if ($this->Session[ "Authenticated" ]==2)
                    {
                        if ($time-$this->Session[ "ATime" ]<=60*60)
                        {
                            if
                                (
                                    $this->Session[ "IP" ]
                                    ==
                                    $_SERVER[ "REMOTE_ADDR" ]
                                )
                            {
                                //Success

                                $this->SessionData=$this->Session;
                                return TRUE;
                            }
                            else
                            {
                                $this->BadGuy();
                                $this->DoDie("Unable to logon....");
                            }
                        }
                        else
                        {
                            $this->HtmlStatus=
                                $this->MyLanguage_GetMessage("Expired");
                            $this->SessionAddMsg("Logon expired");
                            $this->MyApp_Login_Form("Logon Expired",1,"");
                            $this->DoExit();
                        }
                    }
                    else
                    {
                        $this->SessionAddMsg("Not authenticated");
                        $this->MyApp_Login_Form("Not auth",1,"");
                        $this->DoExit();
                    }
                }
            }
            else
            {
                $this->SessionAddMsg("Invalid session: ".$this->Session);
            }
        }
        else
        {
            $this->SessionAddMsg("Invalid format: $sid");
        }

        return FALSE;
    }
}

?>