<?php

include_once("Common/MyApp/MyLogs.php");


class Logs extends ModulesCommon
{
    use
        MyLogs;



    //*
    //*
    //* Constructor.
    //*

    function __construct($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->NItemsPerPage=25;

        /* array_push */
        /* ( */
        /*     $this->LogGETVars,   */
        /*     "Unit","School","Period","Class", */
        /*     "Disc","Student","Teacher" */
        /* ); */
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides ModuleLogs::SqlTableName.
    //* Prepends Unit to name.
    //*

    function SqlTableName($table="")
    {
        $table=parent::SqlTableName($table);
        
        $unitid=$this->Unit("ID");
        if (!empty($unitid)) { $table=$unitid."__".$table; }

        return $table;
    }

    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }


    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Item post processor. Called after read of each item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/^Logs/',$module))
        {
            return $item;
        }

        return $item;
    }
}

?>