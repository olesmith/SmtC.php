<?php



trait MyApp_Handle_Sessions
{
    //*
    //* Show list of logged on user sessions.
    //*

    function MyApp_Handle_Sessions()
    {
        $sqltable=$this->MyApp_Session_Table_Get();
        
        $sessions=
            $this->Sql_Select_Hashes
            (
                array(),
                array(),
                "",
                "",
                $sqltable
            );

        $session=array_pop($sessions);
        array_push($sessions,$session);
        $keys=array_keys($session);

        $delete=$this->CGI_GET("Session");

        $args=$this->CGI_URI2Hash();
        
        $table=array();
        foreach ($sessions as $session)
        {
            $href="";
            if (!empty($delete) && $session[ "ID" ]==$delete)
            {
                $res=$this->Sql_Delete_Item($delete,"ID",$sqltable);
                $href="Removed";
            }
            else
            {
                $args[ "Session" ]=$session[ "ID" ];
                $href=
                    $this->Href
                    (
                       "?".$this->CGI_Hash2URI($args),
                       "Remove",
                       "Remove Session/Login"
                    );
            }
            
            $row=array($href);
            foreach ($keys as $key)
            {
                array_push($row,$session[ $key ]);
            }

            array_push($table,$row);
        }

        $this->MyApp_Interface_Head();
        array_unshift($keys,"");
        
        $this->Htmls_Echo
        (
            array
            (
                $this->H
                (
                    1,
                    "Active User Sessions"
                ),
                $this->Htmls_Table
                (
                    $keys,
                    $table
                )
            )
        );
    }
}

?>