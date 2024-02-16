<?php


trait MyApp_Session_SID_Delete
{
    //*
    //* Deletes $sid in sessions the table.
    //*

    function MyApp_Session_SID_Delete($sid)
    {
        $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
        $this->Sql_Delete_Items
        (
           array
           (
              "SID" => $sid,
           ),
           $this->MyApp_Session_Table_Get()
        );
    }
    
    //*
    //* Deletes all SID=$sid entries in sessions the table.
    //*

    function MyApp_Session_SID_Deletes_User($loginid="")
    {
        if (empty($loginid)) { $loginid=$this->LoginData[ "ID" ]; }
        if (empty($loginid)) { return; }

        //Delete all entries associated with
        //LoginID $loginid in session table
        $this->Sql_Delete_Items
        (
           array
           (
              "LoginID" => $loginid,
           ),
           $this->MyApp_Session_Table_Get()
        );
    }
}

?>