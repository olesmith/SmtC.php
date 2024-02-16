<?php

//include_once("Head/Links.php");

trait MyApp_Interface_Reloads
{    
    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Reload_Icons_DIV()
    {
        if (!empty($_GET[ "No_Reload" ])) { return array(); }
        
        return
            $this->Htmls_DIV
            (
                $this->MyApp_Interface_Reload_Icons(),
                array
                (
                    "CLASS" => array
                    (
                        "Reload_DIV",
                        $this->CGI_GET("Dest"),
                    ),
                    "TITLE" =>
                    array
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Reload","Title"
                        ).".\n\n",
                        $this->CGI_Hash2URI
                        (
                            $this->MyApp_Interface_Reload_URL()
                        ),
                        $this->CGI_GET("Dest"),
                    ),
                    "STYLE" => array
                    (
                        'font-size'  => 'smaller',
                        'text-align' => 'left',
                        'color'      => 'black',
                        'display' => 'block',
                    ),
                )
            );
    }
    
    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Reload_Icons()
    {
        return
            $this->Htmls_DIV
            (
                $this->MyApp_Interface_Reload_Icon_SPANs(),
                array
                (
                    "ID" => "Reload_".$this->MyApp_Interface_Reload_Destination(),
                )
            );
    }

    //*
    //* Create reload Icon url.
    //*
    //* If function MyMod_Interface_Reload_Icons exists for module, it is called.
    //*

    function MyApp_Interface_Reload_Icon_SPANs()
    {
        $icon_spans=array();
        foreach ($this->MyApp_Interface_Reload_Icon_SPAN_Defs() as $icon_def)
        {
            array_push
            (
                $icon_spans,
                $this->MyApp_Interface_Reload_Icon_SPAN($icon_def)
            );
        }

        if (!empty($this->ModuleName))
        {
            $modulename=$this->ModuleName;
            
            if ($modulename=="App")
            {
                $modulename="Application";
                
            }
            $moduleobj=$modulename."Obj";
            
            if (method_exists($this,$moduleobj))
            {
                $module=$this->$moduleobj();

                if (method_exists($module,"MyMod_Interface_Reload_Icons"))
                {
                    $icon_spans=
                        array_merge
                        (
                            $icon_spans,
                            $module->MyMod_Interface_Reload_Icons()
                        );
                }
            }
        }

        return $icon_spans;
    }
    
    //*
    //* Create reload Icon url
    //*

    function MyApp_Interface_Reload_Icon_SPAN($icon_def)
    {
        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Interface_Icon
                (
                    $icon_def[ "Icon" ],
                    array(),'fa-xs'
                ),
                array
                (
                    "CLASS" =>$icon_def[ "CLASS" ] ,
                    
                    "ONCLICK" =>
                    array
                    (
                        "Color_Element(this,'#999999');",
                        $icon_def[ "Onclick" ]
                    ),   
                )
            );
    }
    
    //*
    //* Create reload Icon url
    //*

    function MyApp_Interface_Reload_Icon_SPAN_Defs()
    {
        return
            array
            (
                array
                (
                    "Icon" => "fas fa-sync",
                    "CLASS" => "Reload",
                    "Onclick" => array
                    (
                        "Color_Element(this,'#999999');",
                        $this->JS_Reload_URL_2_Element
                        (
                            $this->MyApp_Interface_Reload_URL(),
                            $this->MyApp_Interface_Reload_Destination(),
                            ""
                        ),
                        $this->JS_Clip_Board_Copy_URL
                        (
                            $this->MyApp_Interface_Clip_Board_URL("Reload_Icons")
                        ),
                    ),

                ),

                
                array
                (
                    "Icon" => "fas fa-screwdriver",
                    "CLASS" => "Top",
                    "Onclick" => array
                    (
                        $this->JS_Load_URL_2_Window
                        (
                            $this->MyApp_Interface_Clip_Board_URL()
                        ),
                    ),
                     
                ),
            );
    }
    
    //*
    //* Create reload Icon url
    //*

    function MyApp_Interface_Reload_URL()
    {
        $url=$this->CGI_URI2Hash();

        if
            (
                $this->CGI_GET("Action")=="Search"
                &&
                $this->CGI_POSTint("DoSearch")==1
            )
        {
            $nitemspp=
                $this->CGI_POST($this->ModuleName."_NItemsPerPage");
            
            if (!empty($nitemspp))
            {
                $url[ "NItemsPerPage" ]=$nitemspp;
            }

            $module=$this->CGI_GET("ModuleName");
            if (!empty($module))
            {
                $moduleobj=$module."Obj";

                $hiddens=
                    array_merge
                    (
                        $this->$moduleobj()->MyMod_Search_Hiddens_Hash(),
                        $this->$moduleobj()->MyMod_Search_Options_Sort_Hiddens_Hash()
                    );

                foreach ($hiddens as $hidden => $value)
                {
                    $hidden=preg_replace('/^'.$module.'_/',"",$hidden);
                    $hidden=preg_replace('/_Search$/',"",$hidden);
                    $url[ $hidden ]=$value;
                }
            }
        }
        
        return $url;
    }
    
    
    //*
    //* Destination ID to reload to.
    //*

    function MyApp_Interface_Reload_Destination()
    {
        $url=$this->CGI_URI2Hash();
        
        $module=$this->CGI_GET("ModuleName");
        if ($module=="Texts")
        {
            
            $module=$module."Obj";
            $moduleobj=$this->$module();
            
            if (method_exists($moduleobj,"MyMod_Interface_Reload_Destination"))
            {
                return $moduleobj->MyMod_Interface_Reload_Destination();
            }
        }

        
        $dest="ModuleCell";
        if (!empty($url[ "Dest" ]))
        {
            $dest=$url[ "Dest" ];
        }

        return $dest;
    }
    

}

?>