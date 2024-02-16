<?php


trait MyApp_Interface_CSS_OnLine
{
    var $MyApp_Interface_CSS_Debug=False;
    
    //*
    //* ReturnsCSS online LINK tags.
    //*

    function MyApp_Interface_CSS_OnLine()
    {
        $csshtml=array("<!-- Online CSS Start -->");
        foreach ($this->MyApp_Interface_CSS_OnLine_Files_Get() as $cssfile)
        {
            array_push
            (
                $csshtml,
                $this->MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
            );
        }
        
        array_push($csshtml,"<!-- Online CSS End -->");
        
        return $csshtml;
    }

    //*
    //* Returns list of (static) file, to be included INLINE.
    //*

    function MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
    {
        return
            $this->HtmlTag
            (
               "LINK",
               "",
               array
               (
                  "REL" => 'stylesheet',
                  "HREF" => $this->MyApp_Interface_CSS_OnLine_CSS_HREF
                  (
                      $cssfile
                  ),
               )
            ).
            "";
    }

    

    //*
    //* Add temps on CSS file names, to event caching
    //*

    function MyApp_Interface_CSS_OnLine_CSS_HREF($cssfile)
    {

        if
            (
                !empty($this->ApplicationObj()->DBHash[ "Debug_Html" ])
                ||
                $_SERVER[ "SERVER_ADDR" ]=="127.0.0.1"
            )
        {
            $cssfile.="?T=".time();
        }
        
        return $cssfile;
    }
    
        
    //*
    //* Reads css files from disk and returns code for online insertion.
    //*

    function MyApp_Interface_CSS_OnLine_Files_Get()
    {
        $cssfiles=array();
        foreach ($this->MyApp_Interface_Head_CSS_OnLine as $cssfile)
        {
            array_push($cssfiles,$cssfile);
        }
        
        $action=$this->CGI_GET("Action");
        $modulename=$this->CGI_GET("ModuleName");

        $css_path=$this->MyApp_Interface_CSS_Path();
        $css_uri=$this->MyApp_Interface_CSS_Uri();
        
        foreach (array_keys($cssfiles) as $cfid)
        {
            $cssfiles[ $cfid ]=$css_uri."/".$cssfiles[ $cfid ];
        }
        
        $files=array();
        $uris=array();
        
        if (!empty($action))
        {
            $action_file=$action.".css";
            array_push($files,join("/",array($css_path,$action_file)));
            array_push($uris,join("/",array($css_uri,$action_file)));
        }
        
        if (!empty($modulename))
        {
             $module_file=$modulename.".css";
             array_push($files,join("/",array($css_path,$module_file)));
             array_push($uris,join("/",array($css_uri,$module_file)));
                    
             if (!empty($action))
             {
                $action_file=$modulename."/".$action.".css";
                array_push($files,join("/",array($css_path,$action_file)));
                array_push($uris,join("/",array($css_uri,$action_file)));
            }
        }
        
        for ($n=0;$n<count($files);$n++)
        {
            $this->MyFile_Touch($files[ $n ]);
            array_push($cssfiles,$uris[ $n ]);
        }

        if ($this->Module)
        {
            $cssfiles=
                array_merge
                (
                    $cssfiles,
                    $this->Module->MyMod_CSS_OnLine($css_uri)
                );
        }

        if ($this->MyApp_Interface_Mobile_Is())
        {
            array_push
            (
                $cssfiles,
                $css_uri."/"."Mobile.css"
            );
        }


        $rcssfiles=array();
        foreach ($cssfiles as $cssfile)
        {
            $file=
                join
                (
                    "/",
                    array
                    (
                        $this->MyApp_Interface_CSS_Root(),
                        $cssfile
                    )
                );

            if (file_exists($file))
            {
                array_push($rcssfiles,$cssfile);
            }
            elseif ($this->MyApp_Interface_CSS_Debug)
            {
                var_dump("Nonexistent CSS: ". $cssfile." (".$file.")");
            }
        }

        return $rcssfiles;
    }
}

?>