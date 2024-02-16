<?php

include_once("CLI/IDs.php");
include_once("CLI/Page.php");
include_once("CLI/Process.php");
include_once("CLI/Delete.php");
include_once("CLI/Stats.php");

trait MyMod_API_CLI
{
    //Alter to control level of logging.
    var $__API_Level__=1;
    var $__API_Processed__=0;
    var $__API_Empty_API_ID__=0;
    var $__API_Invalid__=0;
    var $__API_Created__=0;
    var $__API_Updated__=0;
    var $__API_Deleted__=0;
    var $__API_Stat_Modules__=array();
    
    use
        MyMod_API_CLI_IDs,
        MyMod_API_CLI_Page,
        MyMod_API_CLI_Process,
        MyMod_API_CLI_Delete,
        MyMod_API_CLI_Stats;

    //*
    //* Message API info.
    //*

    function API_Message($messages,$debug=0)
    {
        if (!is_array($messages)) { $messages=array($messages); }

        $message=preg_replace('/\'/','"',join("\n",$messages));
        
        $message=
            array
            (
                "Module" => $this->ModuleName,
                "Message" => $message,
                "Debug" => $debug,
            );
        
        $this->APIsObj()->Sql_Insert_Item($message);

        if ($debug>=$this->__API_Level__)
        {
            echo
                "API#".
                $this->ModuleName.
                ": ".join("\n",$messages).
                "\n";
        }
    }
    
    
}

?>