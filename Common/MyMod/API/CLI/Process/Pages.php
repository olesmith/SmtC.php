<?php

trait MyMod_API_CLI_Process_Pages
{
    //*
    //* Process all pages.
    //*

    function API_CLI_Process_Pages($args,$query=array())
    {
        $pages=
            $this->API_CLI_Process_Pages_Get($args,$query);
        $pages=$this->API_CLI_Pages();

        if (count($pages)<1)
        {
            echo
                "No ".$this->ModuleName." API Pages read\n";
            exit();
        }

        $first=$pages[0];
        $last=$pages[ count($pages)-1 ];

        print
            $this->SqlTableName().
            ": ".
            $this->Sql_Select_NHashes().
            " items\n".
            "Process pages ".$first."-".$last."\n".
            join
            (
                "\t",
                array
                (
                    "Page",
                    "Empty",
                    "Invalid",
                    "Created",
                    "Updated",
                    "Deleted",
                    "Processed",
                )
            ).
            "\n";
        
        $api_ids=array();
        foreach ($pages as $page)
        {
            $api_ids[ $page ]=
                $this->API_CLI_Process_Page
                (
                    $args,$page
                );

            print
                join
                (
                    "\t",
                    array
                    (
                        $page,
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

        $this->API_CLI_Process_IDs_Write($api_ids);
    }
    
    //*
    //* Detect pages from $args.
    //*

    function API_CLI_Process_Pages_Get($args,$query=array())
    {
        $first=1;
        $last=$this->API_CLI_Process_Pages_N_Get();

        
        $args=join(" ",$args);
        $args=preg_replace('/.*(Read|Process)\s*/',"",$args);
        $rargs=preg_split('/\s+/',$args);

        if (!empty($args) && count($rargs)>0)
        {
            $pages=preg_split('/-/',$rargs[0]);
            if (count($pages)>1)
            {
                sort($pages,SORT_NUMERIC);
                $first=$pages[0];
                $last=$pages[1];
            }
            else
            {
                $first=$pages[0];
                $last=$pages[0];
            }
        }
        
        return array($first,$last);
    }
    //*
    //* Detect Number of Pages read.
    //*

    function API_CLI_Process_Pages_N_Get($query=array())
    {
        return
            $this->SigaA()->DB_Web_Services_NPages_Get($query);
    }
    
}

?>