<?php

trait DB_Web_Services_Connect
{
    var $Tokens=array();
    
    //*
    //* Connects trying to generate token.
    //* 
    //* 

    function DB_Web_Services_ReConnect($ttl)
    {
        if (empty($this->_DB_Hash_[ "Link" ])) { return; }
        
        $time_elapsed=time()-$this->_DB_Hash_[ "Link" ][ "Generated" ];

        if ($time_elapsed>$ttl)
        {
            $this->_DB_Hash_=
                $this->DB_Web_Services_Connect
                (
                    $this->_DB_Hash_
                );
        }
        
    }
    
    //*
    //* Connects trying to generate token.
    //* 
    //* 

    function DB_Web_Services_Connect(&$dbhash)
    {
        $dbhash[ "Link" ]="cURL";

        $url=
            $this->DB_Web_Services_Options_Connect_URL();
        
        $result=
            $this->Curl_Run
            (
                $url,
                $this->DB_Web_Services_Connect_Args()
            );

        
        $dbhash[ "Link" ]=json_decode($result,TRUE);
        $dbhash[ "Link" ][ 'Generated' ]=time();
        
        if (!empty($dbhash[ "Link" ][ 'access_token' ]))
        {
            //Add to status messages
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
                $dbhash[ "Link" ][ 'access_token' ]
            );

            $this->DB_Web_Services_Reachable=True;
        }
        else
        {
            print "Warning! Unable to connect to Web Services: ".$url."\n\n";
            var_dump($this->DB_Web_Services_Connect_Options());
            var_dump($dbhash[ "Link" ]);
            exit();
            
            $this->DB_Web_Services_Reachable=False;
            
            $dbhash[ "Link" ]=NULL;
        }

        if ($this->MakeCGI_CLI_Is())
        {
            print "Connected: ".$dbhash[ "Link" ][ "access_token" ]."\n";
        }

        return $dbhash;
    }

    
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Connect_Options($echo=True)
    {
        if ($echo)
        {
            print
                $this->DBHash("Mode").": ".
                $this->DBHash("Key")." - ".
                $this->DBHash("Secret")."\n".
                'Authorization: Basic '.
                $this->DB_Web_Services_Options_Connect_Base64().
                "\n\n";
        }

        return
            array
            (
                CURLOPT_POST => True,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $this->DB_Web_Services_Options_Connect_URL(),
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 0,
                CURLOPT_TIMEOUT => 100,
                
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_POSTFIELDS =>
                join
                (
                    "&",
                    array
                    (
                        "grant_type=password",
                        "username=".$this->DBHash("User"),
                        "password=".html_entity_decode($this->DBHash("Password")),
                    )
                ),
                CURLOPT_VERBOSE => 0,
                CURLOPT_HTTPHEADER => array
                (
                    'Authorization: Basic '.
                    $this->DB_Web_Services_Options_Connect_Base64().
                    ''
                ),
            );
    }
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Connect_Args($echo=False)
    {
        return
            array
            (
                "-d"  =>
                '"'.join
                (
                    "&",
                    array
                    (
                        "grant_type=client_credentials"
                    )
                ).'"',
                "-X" => "POST",
                "-H" => 
                '"Authorization: Basic '.
                $this->DB_Web_Services_Options_Connect_Base64().'"',

                
                //" " => $this->DBHash("Host").'/token',
            );
    }
}

?>
