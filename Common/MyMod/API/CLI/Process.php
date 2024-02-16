<?php

include_once("Process/Item.php");
include_once("Process/Page.php");
include_once("Process/Pages.php");

trait MyMod_API_CLI_Process
{
    use
        MyMod_API_CLI_Process_Item,
        MyMod_API_CLI_Process_Page,
        MyMod_API_CLI_Process_Pages;
    
    //*
    //* Process all pages.
    //*

    function API_CLI_Process($args,$query=array())
    {
        if ($this->API_CLI_Tables_Create())
        {
            echo
                "Tables created - exiting\n";
            exit();
        }
        
        $process_pages=
            $this->API_CLI_Process_Given_Items($args); 

        if (!$process_pages)
        {
            $this->API_CLI_Process_All($args,$query);
        }
    }

    //*
    //* Process all pages.
    //*

    function API_CLI_Process_All($args,$query=array())
    {
        $this->API_CLI_Stats();        
        $this->API_CLI_Stats_Count_Stats();

        $this->API_CLI_Process_Pages($args,$query);

        print
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
        
        $this->API_CLI_Stats();
        $this->API_CLI_Stats_Count_Stats();   
     }
    
    //*
    //* Process given args: api ids given on command line.
    //* Returns True, only if any items were processed.
    //*

    function API_CLI_Process_Given_Items($args)
    {
        $ids=array();
        for ($n=0;$n<count($args);$n++)
        {
            if (preg_match('/^Process$/i',$args[ $n ]))
            {
                for ($m=$n+1;$m<count($args);$m++)
                {
                    array_push($ids,$args[$m]);
                }
            }
        }

        $res=False;
        if (count($ids)>0)
        {
            foreach ($ids as $id)
            {
                $this->API_CLI_Process_Given_Item($args,$id);
            }

            $res=True;
        }

        return $res;
    }

    
    //*
    //* Process given API $id
    //* Returns True, only if any item found and processed.
    //*

    function API_CLI_Process_Given_Item($args,$id)
    {
        $rapi_items=array();
        foreach ($this->API_CLI_Pages_Files() as $page_file)
        {
            $json_text=join("\n",$this->MyFile_Read($page_file));

            $api_items=json_decode($json_text,True);

            $key=$this->SigaA_Args[ "Siga_List_Key" ];
            $id_key=$this->SigaA_Args[ "SigaA_Key" ];
            
            $api_items=$api_items[ $key ];

            $n=0;
            foreach ($api_items as $api_item)
            {
                $n++;
                if ($id==$api_item[ $id_key ])
                {
                    $this->API_Message
                    (
                        "API id ".$id." in ".$page_file. " (No ".$n.")"
                    );
                    
                    array_push($rapi_items,$api_item);
                }
            }
        }

        if (count($rapi_items)==0)
        {
            $this->API_Message("API id ".$id." not found");
        }
        elseif (count($rapi_items)==1)
        {
            $this->API_Message("API id ".$id." located uniquely");
        }
        else
        {
            $this->API_Message("API id ".$id." has ".count($rapi_items)." instances");
        }

        foreach ($rapi_items as $api_item)
        {
            $this->API_CLI_Process_Item($api_item);
        }
    }
}

?>