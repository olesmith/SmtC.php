<?php

include_once("MyLogs/CGI.php");
include_once("MyLogs/Sql.php");
include_once("MyLogs/Cells.php");
include_once("MyLogs/Rows.php");
include_once("MyLogs/Tables.php");


include_once("MyLogs/Years.php");
include_once("MyLogs/Months.php");
include_once("MyLogs/Dates.php");
include_once("MyLogs/Menu.php");


include_once("MyLogs/Hosts.php");
include_once("MyLogs/Logins.php");


include_once("MyLogs/Info.php");
include_once("MyLogs/Handle.php");

global $Exec_ID;
$Exec_ID=getmypid()."_".time();

trait MyLogs
{
    use
        MyLogs_CGI,
        MyLogs_Sql,
        MyLogs_Cells,
        MyLogs_Rows,
        MyLogs_Tables,
        
        MyLogs_Years,
        MyLogs_Months,
        MyLogs_Dates,
        
        MyLogs_Menu,
        MyLogs_Hosts,
        MyLogs_Logins,
        MyLogs_Info,
        MyLogs_Handle;
    
    var $Tables=array();
    
    var $Years=array();
    var $Months=array();
    var $Dates=array();
    
    var $Logs_Search_Vars=
        array
        (
            "IP","Profile","Login","ModuleName","Action",
        );
    /* var $LogGETVars= */
    /*     array */
    /*     ( */
    /*         "ModuleName","Action","RAW", */
    /*     ); */
    /* var $LogPOSTVars= */
    /*     array */
    /*     ( */
    /*         "Edit","Update","Transfer","Save" */
    /*     ); */

    var $CascadingSearchVars=array
    (
       "Debug" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array(),
          "Default" => "",
       ),
       "Month" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array("Date","Login","Profile","Login","ModuleName"),
          "Where" => array(),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "MonthTitle",
       ),
       "Date" => array
       (
          "RemoveVars" => array("Month"),
          "AddVars" => array(),
          "Where" => array(),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "DateTitle",
       ),
       "Period" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Reverse" => TRUE,
          "Method" => "PeriodTitle",
       ),
       "Profile" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Reverse" => TRUE,
       ),
       "Login" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("Month","Date"),
          "Default" => "",
          "Method" => "LoginTitle",
       ),
       "ModuleName" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array("Action"),
          "Where" => array("ModuleName","Date"),
          "Default" => "",
       ),
       "Action" => array
       (
          "RemoveVars" => array(),
          "AddVars" => array(),
          "Where" => array("ModuleName","Date"),
          "Default" => "",
       ),
    );

    //*
    //* Path to logfile.
    //*

    function Log_Path()
    {
        $path=
            join
            (
                "/",
                $this->Log_Paths()
            );

        $this->Dir_Create_AllPaths($path);

        return $path;
    }
    
    //*
    //* Path to logfile.
    //*

    function Log_Paths()
    {
        $date=$this->MyTime_Date2Hash();
        
        $paths=
            array
            (
                $this->ApplicationObj()->Log_Path,
            );

        if (method_exists($this,"Unit"))
        {
            array_push
            (
                $paths,
                $this->Unit("ID")
            );
        }

        array_push
        (
            $paths,
            $date[ "Year" ],
            $date[ "Month" ]
        );        

        return $paths;
    }
    
    
    //*
    //* Path to logfile.
    //*

    function Log_File()
    {
        $date=$this->MyTime_Date2Hash();

        return
            $this->Log_Path().
            "/".
            join
            (
                "-",
                array
                (
                    $date[ "Year" ],
                    $date[ "Month" ],
                    $date[ "Day" ],
                )
            ).
            ".log";
    }

    //*
    //* Log entry $msg to log file.
    //*

    function Log_Entry($msgs,$level=5)
    {
        if (is_array($msgs)) { $msgs=join("\n",$msgs); }
        
        global $Exec_ID;
        $this->MyFile_Append
        (
            $this->Log_File(),
            join
            (
                "\t",
                array
                (
                    $this->TimeStamp(),
                    $_SERVER['REMOTE_ADDR'],
                    $Exec_ID,
                    $level,
                    $this->ApplicationObj()->Profile(),
                    $this->ApplicationObj()->LoginData("ID"),
                    $this->ApplicationObj()->LoginData("Email"),
                    
                    $msgs,
                )
            )
            
            /* "\n\t". */
            /* $this->CallStack_Callers_Infos("\n\t"). */
        );
        
        return;
    }
  


    //*
    //* Returns hierarcical Search where.
    //*

    function CreateCascatingSearchWhere($data)
    {
        $where=array();
        foreach ($this->CascadingSearchVars[ $data ][ "Where" ] as $key)
        {
            $value=$this->MyMod_Search_CGI_Value($key);
            if (!empty($value))
            {
                $where[ $key ]=$value;
            }
        }

        return $where;
    }

    //*
    //* Creates hhirarcical Searchfield.
    //*

    function CreateCascatingSearchField($data,$rdata="",$rvalue="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $values=$this->MySqlUniqueColValues
        (
           "",
           $data,
           $this->CreateCascatingSearchWhere($data),
           "",
           $data
        );

        if (!empty($this->CascadingSearchVars[ $data ][ "Reverse" ]))
        {
            $values=array_reverse($values);
        }

        $rvalues=array();
        if (!empty($this->CascadingSearchVars[ $data ][ "Method" ]))
        {
            $method=$this->CascadingSearchVars[ $data ][ "Method" ];
            foreach ($values as $id => $value)
            {
                if (empty($value))
                {
                    unset($values[ $id ]);
                    continue;
                }

                $rvalues[ $id ]=$this->$method($value);
                if (empty($rvalues[ $id ]))
                {
                    unset($values[ $id ]);
                    unset($rvalues[ $id ]);
                    continue;
                }
            }
        }
        else
        {
            $rvalues=$values;
        }

        array_unshift($values,0);
        array_unshift($rvalues,"");


        //Take default, if detectable
        $cgivalue=$this->MyMod_Search_CGI_Value($data);
        if (empty($cgivalue) && !empty($this->CascadingSearchVars[ $data ][ "Default" ]))
        {
            $cgivalue=$this->CascadingSearchVars[ $data ][ "Default" ];
        }

        //If value given, add vars and remove vars.
        if (!empty($cgivalue))
        {
            foreach ($this->CascadingSearchVars[ $data ][ "RemoveVars" ] as $var)
            {
                $this->MyMod_Search_Var_Remove($var);
            }

            foreach ($this->CascadingSearchVars[ $data ][ "AddVars" ] as $var)
            {
                $this->MyMod_Search_Var_Add($var);
            }
        }

        //If value given, add Date as SearchVar.
        if (!empty($cgivalue))
        {
        }

        return $this->MakeSelectField
        (
           $this->MyMod_Search_CGI_Name($rdata),
           $values,
           $rvalues,
           $cgivalue
        );
    }
 
    //*
    //* Creates Debug Searchfield.
    //*

    function DebugSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }
    
    //*
    //* Returns period title.
    //*

    function PeriodTitle($value)
    {
        return $this->ApplicationObj->PeriodsObject->MySqlItemValue("","ID",$value,"Title",TRUE);
    }

    //*
    //* Creates School Searchfield.
    //*

    function PeriodSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    
    //*
    //* Returns Month title.
    //*

    function MonthTitle($value)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$value,$matches))
        {
            $year=$matches[1];
            $value=$matches[2];

            $value=$value."/".$year;
        }

        return $value;
    }

    //*
    //* Creates Month Searchfield.
    //*

    function MonthSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Returns Date title.
    //*

    function DateTitle($value)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$value,$matches))
        {
            $value=
                $matches[3]."/".
                $matches[2]."/".
                $matches[1];
        }
 
        return $value;
    }

    //*
    //* Creates Date Searchfield.
    //*

    function LogDateSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Creates Date, Month or Yeat search where.
    //*

    function LogDateSearchWhere()
    {
        $date=$this->MyMod_Search_CGI_Value("Date");
        $month=$this->MyMod_Search_CGI_Value("Month");
        if (!empty($date))
        {
            return array("Date" => $date);
        }
        elseif (!empty($month))
        {
            return array("Month" => $month);
        }
        else
        {
            return array("Month" => $this->MyTime_Current_Year().$this->MyTime_Current_Month());
        }
    }

    //*
    //* Creates Profile Searchfield.
    //*

    function ProfileSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Returns Login title.
    //*

    function LoginTitle($value)
    {
        if (!empty($value))
        {
            $value=
                $this->ApplicationObj->UsersObject->MySqlItemValue("","ID",$value,"Name",TRUE).
                " (".$value.")";
        }
 
        return $value;
    }

    //*
    //* Creates Login Searchfield.
    //*

    function LoginSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Creates Module Searchfield.
    //*

    function ModuleSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }

    //*
    //* Creates Action Searchfield.
    //*

    function ActionSearchField($data,$rdata="",$rval="")
    {
        return $this->CreateCascatingSearchField($data,$data,$rval);
    }


}

?>