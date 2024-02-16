<?php


function first($list) { return $list[0]; }

trait MyApp_Interface_Head_Scripts
{
    //*
    //* Returns interface header script section
    //*
    //*

    function MyApp_Interface_SCRIPTs()
    {
        return
            array_merge
            (
                $this->MyApp_Interface_SCRIPTs_InLine(),
                $this->MyApp_Interface_SCRIPTs_OnLine(),
                $this->MyApp_Interface_SCRIPT_Sections(),
                $this->MyApp_Interface_SCRIPTs_Module()
            );
    }
    
    //*
    //* Returns interface header scripts tags.
    //*

    function MyApp_Interface_SCRIPT_Sections()
    {
        $scripts=array();
        foreach ($this->MyApp_Interface_Head_Scripts as $script)
        {
            array_push($scripts,$script);
        }

        return $scripts;
        
    }
    
    //*
    //* Returns interface header scripts inline section
    //*

    function MyApp_Interface_SCRIPTs_OnLine()
    {
        $scripts=array();
        foreach ($this->MyApp_Interface_Head_Scripts_OnLine as $file)
        {
            array_push
            (
                $scripts,
                $this->HtmlTags
                (
                    "SCRIPT",
                    "",
                    array
                    (
                        "SRC" => $file."?Random=".time(),
                    )
                )
            );
        }

        return $scripts;
    }
        
    //*
    //* Returns interface header scripts online section
    //*
    
    function MyApp_Interface_SCRIPTs_InLine()
    {
        $scripts=array();
        foreach ($this->MyApp_Interface_Head_Scripts_InLine as $file)
        {
            $scripts=array_merge
            (
                $scripts,
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                        $this->MyFiles_Read_Lines(array($file))
                    )
                )
            );
        }
        
        return $scripts;
    }
    
    //*
    //* Calls module object for it's SCRIPT contributions.
    //*

    function MyApp_Interface_SCRIPTs_Module()
    {
        $scripts=array();
        if (!empty($this->Module))
        {
            $scripts=
                $this->Module->MyMod_SCRIPTs();
        }
        
        return $scripts;
    }
}

?>