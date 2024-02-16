<?php


trait MyApp_Session_SID_Update
{
    //*
    //* Updates session entry.
    //*

    function MyApp_Session_SID_Update($sid)
    {
        if ($this->CGI_GET("Action")=="Download") { return; }
        
        //$this->MyApp_Session_SID_User_Deletes($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $time=time();
        $this->Session[ "Authenticated" ]=2;
        $this->Session[ "LastAuthenticationAttempt" ]=$time;
        $this->Session[ "LastAuthenticationSuccess" ]=$time;
        $this->Session[ "NAuthenticationAttempts" ]=0;
        $this->Session[ "ATime" ]=$time;
        $this->Session[ "MTime" ]=$time;

        $profile=$this->MyApp_Profiles_CGI_Get();
        if ($this->Session[ "Profile" ]!=$profile)
        {
            $this->Session[ "Profile" ]=$profile;
        }

        $this->Sql_Update_Item_Values_Set
        (
           array
           (
              "Authenticated",
              "LastAuthenticationAttempt","LastAuthenticationSuccess",
              "NAuthenticationAttempts","ATime","Profile"
           ),
           $this->Session,
           $this->MyApp_Session_Table_Get()
        );

        $this->MakeCGI_Cookie_Set("SID",$sid,$time+$this->CookieTTL);
    }
}

?>