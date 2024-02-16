<?php


trait MyApp_Handle_Logon
{
    //*
    //* The Start Handler. Should display some basic info.
    //* If LastAction is in CGI_URI2Hash, do Login and reload with this action.
    //* Otherwise relaod with action Start.
    //*

    function MyApp_Handle_Logon()
    {
        if (!$this->MyApp_Logon_May())
        {
            return array();
        }
        
        if ($this->LoginType=="Public")
        {
            if ($this->CGI_GETOrPOSTint("Logon")==1)
            {
                $this->MyApp_Session_Init();

                if ($this->Authenticated)
                {
                    $args=$this->CGI_URI2Hash();

                    //Default action
                    $args[ "Action" ]="Start";

                    foreach (array("RAW","Dest") as $data)
                    {
                        if (!empty($args[ $data ]))
                        {
                            unset($args[ $data ]);
                        }
                    }
                    
                    //LastAction GET arg appended in Login_Form.
                    if (!empty($args[ "LastAction" ]))
                    {
                        if ($args[ "LastAction" ]!="Logon")
                        {
                            $args[ "Action" ]=$args[ "LastAction" ];
                            unset($args[ "LastAction" ]);
                        }
                        
                        unset($args[ "Login" ]);
                    }

                    $this->CGI_Redirect($args);
                    $this->DoExit();
                }
            }

            $this->MyApp_Login_Form();
        }
        else
        {
            $this->MyApp_Handle_Start();
        }
    }

    //*
    //* Carries out logoff, ie: Calls DoLogoff and exits.
    //*

    function MyApp_Handle_Logoff()
    {
        $this->MyApp_Logoff_Do();
        $this->DoExit();
    }
    
    //*
    //* Handles password change.
    //*

    function MyApp_Handle_Password_Change()
    {
        $this->MyApp_Login_Password_Change_Form();
        exit();
    }
}

?>