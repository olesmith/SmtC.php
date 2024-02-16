<?php

include_once("SID/Create.php");
include_once("SID/Update.php");
include_once("SID/Delete.php");

trait MyApp_Session_SID
{
    use
        MyApp_Session_SID_Create,
        MyApp_Session_SID_Update,
        MyApp_Session_SID_Delete;
    
    //*
    //*
    //*
    
    function MyApp_Session_Msg($msg)
    {
        $this->MyApp_Interface_Message_Add
        (
            "Session Msg: ".$msg."; "
        );

        if (!empty($this->Session[ "ID" ]))
        {
            $this->MyApp_Interface_Message_Add
            (
                $this->Sql_Select_Hash_Value
                (
                    $this->Session[ "ID" ],
                    "Profile",$idvar="ID",
                    $noecho=FALSE,
                    $this->MyApp_Session_Table_Get()
                ),
                $this->Session[ "Profile" ]
            );
        }
    }
    
    //*
    //* Reads $sid as session SID.
    //*

    function MyApp_Session_SID_Read($sid)
    {
        $this->Session=
            $this->Sql_Select_Hash
            (
                array
                (
                    "SID" => $sid
                ),
                array(),
                TRUE,
                $this->MyApp_Session_Table_Get()
            );

        $this->__Profile__=$this->Session[ "Profile" ];
    }

    //*
    //* Reads $sid as session SID.
    //*

    function MyApp_Session_SID_2LoginData($sid)
    {
        $this->MyApp_Login_SetData
        (
            $this->MyApp_Login_Retrieve_LoginData
            (
                $this->Session[ "Login" ],
                $this->Session[ "SQL_Table" ]
            )
        );
    }

}

?>