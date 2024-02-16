<?php

trait MyApp_Logging
{
    //*
    //* Logs object accessor.
    //*

    function LogsObject($updatestructure=FALSE)
    {
        return $this->LogsObj($updatestructure);
    }

    //*
    //* Call LogsObject Log_Entry.
    //*

    function MyApp_Log_Entry($msgs,$level=5)
    {
        $this->LogsObject()->Log_Entry($msgs,$level);
    }

    
    /* //\* */
    /* //\* Logs object accessor. */
    /* //\* */

    /* function LogsObj($updatestructure=FALSE) */
    /* { */
    /*     return $this->MyMod_SubModule_Load("Logs",$updatestructure); */
    /* } */
    
    //*
    //* Logs object accessor.
    //*
    //*
    //* Initializes loggin, if on.
    //* If Log_Path is not defined or empty in index.php,
    //* initilize Logs module DB table.
    //*

    function MyApp_Logging_Init()
    {
        if ($this->Logging)
        {
            if
                (
                    !property_exists($this,"Log_Path")
                    ||
                    empty($this->Log_Path)
                )
            {                
                $this->MyMod_SubModule_Load("Logs",TRUE,TRUE);
            }

            $module=$this->CGI_GET("ModuleName");
            if (True)//empty($module))
            {
                $this->MyApp_Log_Entry
                (
                    "Init: ".$_SERVER[ "QUERY_STRING" ]
                );
            }
        }
    }
}

?>