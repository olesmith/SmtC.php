<?php

trait System
{
    //*
    //* Run $commands
    //*

    function System_Run($command,$echo=False)
    {
        if (is_array($command))
        {
            $command=join(" ",$command);
        }


        $dtime=time();
        $res=system($command);
        $dtime=time()-$dtime;
        
        if ($echo) { echo $command.": ".$res.", ".$dtime."s\n"; }
        
        return intval($res);
    }
}

?>