<?php


trait MyApp_Session_SID_Create
{
    //*
    //* Registers new $sid session.
    //*

    function MyApp_Session_SID_Create()
    {
        $this->MyApp_Session_SID_Deletes_User($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $sid=rand().rand().rand();
        $time=time();
        $this->Session=
            array
            (
                "SID"                        => $sid,
                "LoginID"                    => $this->LoginData[ "ID" ],
                "Login"                      => $this->LoginData[ "Login" ],
                "LoginName"                  => $this->LoginData[ "Name" ],
                "SQL_Table"                  => $this->LoginData[ "SQL" ],
                "CTime"                      => $time,
                "ATime"                      => $time,
                "MTime"                      => $time,
                "IP"                         => $_SERVER[ "REMOTE_ADDR" ],
                "Profile"                    => $this->MyApp_Profile_Default(),
                "Authenticated"              => 2,
                "LastAuthenticationAttempt"  => $time,
                "LastAuthenticationSuccess"  => $time,
                "NAuthenticationAttempts"    => 0,
            );

        $this->Sql_Insert_Item
        (
            $this->Session,
            $this->MyApp_Session_Table_Get()
        );
        
        $this->MakeCGI_Cookie_Set
        (
            "SID",
            $sid,
            $time+$this->CookieTTL
        );

        return $sid;
    }
}

?>