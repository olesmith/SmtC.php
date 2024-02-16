<?php


trait DB_Web_Services_Options
{ 
    var $Curl_Queries=array();

    //*
    //* 
    //* 

    function DB_Web_Services_Options_Connect_URL()
    {
        return $this->DBHash("Token_URL");
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_Options_Connect_Base64()
    {
        //20231128: change endpoints
        //$key="pZXw1RHG6tuiXAvPodd3KvEa";
        //$secret="aAQWZvqfnfCgxpIu3WMfZYJeGE8a";
        
        return
            base64_encode
            (
                join
                (
                    ":",
                    array
                    (
                        $this->DBHash("Key"),
                        $this->DBHash("Secret"),
                    )
                )
            );
    }
    
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Options0000($url,$echo=False,$method=0,$bearer=True)
    {
        if ($echo=True)
        {
            print
                $this->DBHash("Mode").": ".
                $this->DBHash("Key")." - ".
                $this->DBHash("Secret")."\n".
                'Authorization: Basic '.
                $this->DB_Web_Services_Options_Connect_Base64().
                "\n\n";
        }

        if ($method==0)
        {
            $options=
                array
                (
                    CURLOPT_POST => True,
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_FRESH_CONNECT => 1,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_FORBID_REUSE => 0,
                    CURLOPT_TIMEOUT => 100,
                
                    CURLOPT_VERBOSE => True,
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
                            "password=".$this->DBHash("Password"),
                        )
                    ),
                    CURLOPT_VERBOSE => 0,

                    CURLOPT_HTTPHEADER => array
                    (
                        'Authorization: Bearer '.
                        $this->DB_Web_Services_Options_Connect_Base64()
                    ),

                );
        }
        elseif ($method==1) //GET
        {
            $options=
                array
                (
                    CURLOPT_POST => False,
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $url,
                    /* $url. */
                    /* "?". */
                    /* join */
                    /* ( */
                    /*     "&", */
                    /*     array */
                    /*     ( */
                    /*         "grant_type=password", */
                    /*         "username=".$this->DBHash("User"), */
                    /*         "password=".$this->DBHash("Password"), */
                    /*     ) */
                    /* ). */
                    /* "", */
                                        
                    CURLOPT_FRESH_CONNECT => 1,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_FORBID_REUSE => 0,
                    CURLOPT_TIMEOUT => 100,
                
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array
                    (
                        'Authorization: Bearer '.
                        $this->DB_Web_Services_Options_Connect_Base64()
                    ),

                    CURLOPT_VERBOSE => 1,
                );
        }

        /* if ($bearer) */
        /* { */
        /*     $options= */
        /*         array_merge */
        /*         ( */
        /*             $options, */
        /*             array */
        /*             ( */
        /*                 CURLOPT_HTTPHEADER => array */
        /*                 ( */
        /*                     'Authorization: Basic '. */
        /*                     $this->DB_Web_Services_Options_Connect_Base64() */
        /*                 ), */
        /*             ) */
        /*         ); */
        /* } */

        return $options;
    }
    
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Options_Assoc_Args($url,$limit=-1,$page=1,$method="POST")
    {
        $link=$this->DBHash("Link");

        $url.="&"."pagina=".$page;

        $url.="&"."itens_por_pagina=".$limit;

        return
            array
            (
                "-k" => "",
                /* "-d"  => */
                /* '"'.join */
                /* ( */
                /*     "&", */
                /*     array */
                /*     ( */
                /*         //"grant_type=client_credentials", */
                /*         "pagina=".$page, */
                /*         "itens_por_pagina=".$limit, */
                /*     ) */
                /* ).'"', */
                "-X" => 'GET "'.$url.'"',
                "-H" => 
                '"'.
                "accept: application/json;".
                '"',
                "-H " => 
                '"'.
                "Authorization: Bearer ".$link[ 'access_token' ].
                '"'
            );        
    }

    
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Options_Assoc_List($query=array(),$limit=-1,$page=1,$method="POST")
    {
        $link=$this->DBHash("Link");
        array_push
        (
            $this->Curl_Queries,
            "Page: ".$page,
            $this->DB_Web_Services_Curl_Url($query,$limit,$page)
        );

        //print "DB_Web_Services_Options_Assoc_List\n\n";

        if ($method=="GET")
        {
            return
                array
                (
                    CURLOPT_POST => 0,
                    //CURLOPT_POSTFIELDS => http_build_query($query),
                
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $this->DB_Web_Services_Curl_Url($query,$limit,$page),
                
                    CURLOPT_FRESH_CONNECT => 1,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_FORBID_REUSE => 0,
                    CURLOPT_TIMEOUT => 100,
                
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_VERBOSE => 0,
                    CURLOPT_HTTPHEADER => array
                    (
                        "accept: application/json",
                        "Authorization: Bearer ".$link[ 'access_token' ]
                    ),
                );
        }
        
        return
            array
            (
                CURLOPT_POST => 0,
                //CURLOPT_POSTFIELDS => http_build_query($query),
                
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $this->DB_Web_Services_Curl_Url($query,$limit,$page),
                
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 0,
                CURLOPT_TIMEOUT => 100,
                
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_VERBOSE => 0,
                CURLOPT_HTTPHEADER => array
                (
                    "accept: application/json",
                    "Authorization: Bearer ".$link[ 'access_token' ]
                ),
            );
    }

}

?>