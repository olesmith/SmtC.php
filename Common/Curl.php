<?php

trait Curl
{
    var $Curl_Obj=NULL;
    var $Curl_Bin="/usr/bin/curl";
    
    //*
    //* Prepare and send query.
    //* 
    //* 

    function Curl_Error($curl,$options)
    {
        print
            "cURL Error:\n".
            curl_error($curl).
            "\n";
        
    }
    
    //*
    //* Run full curl command.
    //* 

    function Curl_Do($query,$options,$echo_returncode=FALSE)
    {
        $curl=curl_init();
        
        $this->Curl_Options_Set($curl,$options);

        //var_dump($options);
        if( ! $result = curl_exec($curl))
        {
            echo
                "Return code : ".
                curl_getinfo($curl, CURLINFO_HTTP_CODE).
                "\nError msg: ".
                curl_error($curl).
                "\n"; 
        }

        curl_close($curl);
        
        return $result;
    }
    
    function Curl_Options_Set($curl,$options)
    {
        curl_setopt_array($curl,$options);
    }
    
    function Curl_Exec($url,$options)
    {
        $curl=curl_init();
        curl_setopt_array
        (
            $curl,
            $options
        );

        $result=curl_exec($curl);

        curl_close($curl);

        return $result;
    }
    
    function Curl_Exec_Decode($url,$options)
    {
        return
            json_decode
            (
                $this->Curl_Exec($url,$options),
                true
            );
    }
    
    function Curl_DownLoad($url,$file)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        
        $result = curl_exec($ch);
        curl_close($ch);

        $this->MyFile_Write($file,$result);
        system("/bin/chown www-data:www-data ".$file);
    }
    
    function Curl_Run($url,$options,$echo=False)
    {
        $commands=
            array
            (
                "/usr/bin/curl",
            );

        foreach ($options as $flag => $value)
        {
            array_push
            (
                $commands,
                $flag." ".$value
            );
        }

        $out_file="/tmp/curl.".time().".".getmypid().".out";
        $err_file="/tmp/curl.".time().".".getmypid().".err";
        
        array_push
        (
            $commands,
            $url,
            ">".$out_file,
            "2>".$err_file
            
        );

        $command=join(" ",$commands);

        if ($echo)
        {
            print "\n\n\n".$command."\n\n\n";
        }

        system($command);

        $json=join($this->MyFile_Read($out_file));

        unlink($out_file);
        unlink($err_file);

        return $json;
    }
    
}
?>