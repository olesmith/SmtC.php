<?php

include_once("CLI/Messages.php");

include_once("CLI/SQL.php");
include_once("CLI/Defaults.php");
include_once("CLI/Copy.php");

//Executed in SAdE
include_once("CLI/Mail.php");
include_once("CLI/Language.php");


trait MyApp_CLI
{
    use
        MyApp_CLI_Messages,
        MyApp_CLI_SQL,
        MyApp_CLI_Defaults,
        MyApp_CLI_Copy,
        MyApp_CLI_Mail,
        MyApp_CLI_Language;
    
    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI_Process($args)
    {
        $args=$_SERVER[ "argv" ];

        echo 
            $this->TimeStamp2Text(time()," ",False).", ".
            "MyApp_CLI_Process\n";
        
        $this->MyApp_CLI_SQL_Count_Tables($args);
        $this->MyApp_CLI_Defaults($args);
        //$this->MyApp_CLI_Messages($args);
        $this->MyApp_CLI_Copy($args);
        $this->MyApp_CLI_Compare($args);
        //$this->MyApp_CLI_Messages_Language($args);
        
        echo 
            $this->TimeStamp2Text(time()," ",False).", ".
            "MyApp_CLI_Process Finished\n";
        
    }
    
    //*
    //* Post processes items.
    //*

    function MyApp_CLI_POST($args)
    {
        if (!preg_grep('/^POST$/',$args))
        {
            echo "MyApp_CLI_POST omitted!\n";
            return;
        }

        $module=array_pop($args);
        $moduleobj=$module."Obj";
        $this->$moduleobj()->MyMod_CLI_POST($args);
    }
    
}
