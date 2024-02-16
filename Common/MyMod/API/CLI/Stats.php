<?php


trait MyMod_API_CLI_Stats
{
    //*
    //* 
    //*

    function API_CLI_Stats()
    {
        echo
            "API_CLI_Status: ".
            $this->ModuleName().
            " ".
            $this->SqlTableName().
            ": ".
            
            "";

        if ($this->Sql_Table_Exists())
        {
            echo "Exists\n";
        }
        else
        {
           echo "Unexistent - exiting\n";
           exit();
        }

        echo
            "\t".
            $this->Sql_Select_NHashes().

            "\t".
            $this->Sql_Select_NHashes
            (
                array("Distributed" => 1)
            ).
            "/".
            $this->Sql_Select_NHashes
            (
                array("Distributed" => 2)
            ).

            
            "\n";
        

        foreach ($this->__API_Stat_Modules__ as $module)
        {
            $this->$module()->API_CLI_Stats();
        }
    }
    
    //*
    //* 
    //*

    function API_CLI_Stats_Count_Stats()
    {

        $this->API_CLI_Stats_Counters_Titles();
        $this->API_CLI_Stats_Counters();
        foreach ($this->__API_Stat_Modules__ as $module)
        {
            $this->$module()->API_CLI_Stats_Count_Stats();
        }
    }
    
    //*
    //* 
    //*

    function API_CLI_Stats_Counters_Titles()
    {
        echo
            $this->SqlTableName().
            ", IDs in ".
            $this->Sql_Select_Calc
            (
                array(),
                "ID",
                "MIN"
            ).
            "-".
            $this->Sql_Select_Calc
            (
                array(),
                "ID",
                "MAX"
            ).
            "\n".
            join
            (
                "\t",
                array
                (
                    "Empty",
                    "Invalid",
                    "Created",
                    "Updated",
                    "Deleted",
                    "Processed",
                )
            ).
            "\n";
    }
    //*
    //* 
    //*

    function API_CLI_Stats_Counters()
    {
        echo
            join
            (
                "\t",
                array
                (
                    $this->__API_Empty_API_ID__,
                    $this->__API_Invalid__,
                    $this->__API_Created__,
                    $this->__API_Updated__,
                    $this->__API_Deleted__,
                    $this->__API_Processed__,
                )
            ).
            "\n";
     }
    
    //*
    //* 
    //*

    function API_CLI_Tables_Create()
    {
        $created=False;
        if (!$this->Sql_Table_Exists())
        {
            print "Creating SQL table:".$this->SqlTableName()."\n";
            $this->Sql_Table_Structure_Update();

            if ($this->Sql_Table_Exists())
            {
                $created=True;
            }
        }

        foreach ($this->__API_Stat_Modules__ as $module)
        {            
            $created=
                $this->$module()->API_CLI_Tables_Create()
                ||
                $created;
        }
        
        return $created;
    }
}

?>