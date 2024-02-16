<?php

trait MyMod_API_CLI_Page
{
    var $API_CLI_Path="/usr/local/SigaZ/CLI";    
    var $API_CLI_Page_Path_Extra="";

    //*
    //* Read one $page. If page file non existent, calls API to retrieve.
    //*

    function API_CLI_Page_Read($page,$query=array(),$ntries=5,$sleep=5,$fromfile=True)
    {
        $file=$this->API_CLI_Page_File_Name($page);
        $sigaa_items=array();

        if ($fromfile && file_exists($file))
        {
            $sigaa_items=$this->SigaA_CLI_File_Page_Read($file);
        }
        
        if (empty($sigaa_items))
        {
            $sigaa_items=
                $this->SigaA_CLI_Page_Items_Read
                (
                    $page,
                    $query,
                    $ntries,$sleep
                );
        }        

        return $sigaa_items;
    }

    //*
    //* Returns name of $page file.
    //*

    function API_CLI_Page_File_Name($page)
    {
        $file=
            join
            (
                "/",
                array
                (
                    $this->API_CLI_File_Path(),
                    sprintf("%04d",$page).".txt"
                )
            );

        $this->Dir_Create_AllPaths(dirname($file));
        return $file;
    }
    
    //*
    //* Detec page files.
    //*

    function API_CLI_Pages()
    {
       $pages=array();
       foreach
           (
               $this->API_CLI_Pages_Files()
               as $file
           )
       {
           $file=basename($file);
           $file=preg_replace('/\.txt$/',"",$file);
           
           array_push
           (
               $pages,$file
           );
       }

       sort($pages);
       return $pages;
    }
    //*
    //* Detec page files.
    //*

    function API_CLI_Pages_Files()
    {
       $files=
            $this->Dir_Files
            (
                $this->API_CLI_File_Path(),
                '\d\d\d\d\.txt$'
            );
       
       sort($files);
       
       return $files;
    }

    //*
    //* Path to module API CLI files.
    //*

    function API_CLI_File_Path()
    {
        return
            join
            (
                "/",
                array
                (
                    $this->API_CLI_Path,
                    $this->ModuleName,
                    $this->SigaA()->DBHash("Mode"),
                    $this->API_CLI_Page_Path_Extra,
                )
            );
    }
    
    
     //*
    //* 
    //*

    function API_CLI_OutFile()
    {
        $timeinfo=$this->MyTime_Info();
        return
            join
            (
                "/",
                array
                (
                    $this->SigaA_CLI_File_OutPath(),
                    join
                    (
                        ".",
                        array
                        (
                            $timeinfo[ "Year" ],$timeinfo[ "Month" ],$timeinfo[ "MDay" ]
                        )
                    ).
                    "-".
                    join
                    (
                        ".",
                        array
                        (
                            $timeinfo[ "Hour" ],$timeinfo[ "Min" ]
                        )
                    ).
                    ".json",
                )
            );
    }
}

?>