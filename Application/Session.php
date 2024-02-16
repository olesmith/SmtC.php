<?php

class Session extends Login
{
    var $SessionsTable="Sessions";
    var $MayCreateSessionTable=FALSE;
    var $MaxLoginAttempts=10;
    var $BadLogonRegistered=0;
    var $NoInitSession=0;
    var $SessionData=array();
    var $SessionMessages="Session.php";
    #var $CookieTTL=3600;

    var $Authenticated=FALSE;



    //*
    //* function Session, Parameter list: 
    //*
    //* Constructur
    //*
    
    function SessionAddMsg($msg)
    {
        if (TRUE)
        {
            $this->AddMsg($msg);
        }
    }



    /* //\* */
    /* //\* function GetSessionsTable, Parameter list:  */
    /* //\* */
    /* //\* Returns name of Sessions table */
    /* //\* */

    /* function GetSessionsTable() */
    /* { */
    /*     return $this->MyApp_Session_Table_Get(); */
    /* } */



    //*
    //* function RegisterBadLogon, Parameter list: 
    //*
    //* Registers bad logon attempt.
    //*

    function RegisterBadLogon()
    {
        if ($this->BadLogonRegistered!=0) { return; }

        $login=strtolower($this->CGI_POST("Login"));

        $time=time();

        //All sessions with attempted Login OR IP address
        //$where="Login='".$login."' OR IP='".$_SERVER[ "REMOTE_ADDR" ]."'";
        $where=
            $this->Sql_Table_Column_Name_Qualify("Login").
            "=".
            $this->Sql_Table_Column_Value_Qualify($login);
        
        $sessions=$this->SelectHashesFromTable($this->MyApp_Session_Table_Get(),$where);

        if (count($sessions)>0)
        {
            foreach ($sessions as $id => $session)
            {
                $session[ "Login" ]=$login;
                $session[ "IP" ]=$_SERVER[ "REMOTE_ADDR" ];
                $session[ "ATime" ]=$time;
                $session[ "LastAuthenticationAttempt" ]=$time;
                $session[ "Authenticated" ]=1; //1, is not auth, enum!
                $session[ "LastAuthenticationSuccess" ]=-1;
                $session[ "NAuthenticationAttempts" ]++;

                $this->Sql_Update_Item
                (
                   $session,$where,
                   array(),
                   $this->MyApp_Session_Table_Get()
                );
                
                $this->SessionAddMsg("Removing bad session: ".$session[ "Login" ]);
            }
        }
        else
        {
            $login_id=" 0";
            if (!empty($this->LoginData[ "ID" ]))
            {
                $login_id=$this->LoginData[ "ID" ];
            }
            $login_name="-";
            if (!empty($this->LoginData[ "Name" ]))
            {
                $login_name=$this->LoginData[ "Name" ];
            }
            
            $session=
                array
                (
                    "SID"       => -1,
                    "LoginID"   => $login_id,
                    "Login"     => $login,
                    "LoginName" => $login_name,
                    "CTime"     => $time,
                    "ATime"     => $time,
                    "IP"        => $_SERVER[ "REMOTE_ADDR" ],
                    "Authenticated"  => 1, //1, is not auth, enum!
                    "LastAuthenticationAttempt"  => $time,
                    "LastAuthenticationSuccess"  => -1,
                    "NAuthenticationAttempts"  => 1,
                );

            $this->Sql_Insert_Item
            (
                $session,
                $this->MyApp_Session_Table_Get()
            );
        }

        $this->BadLogonRegistered=1;
     }

    //*
    //* function GoHTTPS, Parameter list: 
    //*
    //* Redirects to HTTPS.
    //*

    function GoHTTPS()
    {
        if (!isset($_SERVER[ "HTTPS" ]))
        {
            if (!empty($this->DBHash[ "HTTPS" ]))
            {
                $this->CGI_Redirect
                (
                    "https://".$this->ServerName()."/".
                    $this->CGI_Script_Path()."/".
                    $this->CGI_Script_Name().
                    $this->CGI_Script_Path_Info()."?".
                    $this->CGI_Query_String()
                );

                exit();
            }
        }
    }



}

?>