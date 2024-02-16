<?php

include_once("Common/MyApp/CLI.php");

trait App_CLI
{
    use
        MyApp_CLI;
    
    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI_Process($args)
    {
        print "SmtC/App/MyApp_CLI_Process\n";
        
        $args=$_SERVER[ "argv" ];
        $this->MyApp_CLI_Language_Process($args);

        $this->SmtC_CLI_Import($args);
    }

    //*
    //* 
    //*

    function SmtC_CLI_Import($args)
    {
        $exec="SmtC_CLI_Import";
        if
            (
                count($args)<4
                ||
                $args[2]!=$exec
            )
        {
            print $exec." parentid|file/path\n";
        }

        
        $file_or_path=$args[3];

        $this->TextsObj()->Text_Import($file_or_path);
    }
}

?>