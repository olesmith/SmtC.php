<?php



trait MyApp_Interface_CSS_Module
{
    //*
    //* Module specific CSS.
    //*

    function MyApp_Interface_CSS_Module()
    {
        $css=array();
        
        $module=$this->CGI_GET("ModuleName");
        $action=$this->CGI_GET("Action");
        if (!empty($module))
        {
            $files=
                $this->MyApp_Interface_CSS_Module_Files_Existent
                (
                    $module,$action
                );

            foreach
                (
                    $this->MyApp_Interface_CSS_Module_Files_Existent
                    (
                        $module,$action
                    )
                    as $file
                )
            {
                $file_css=$this->MyFile_Read($file);
                if (preg_grep('/^\S/',$file_css))
                {
                    array_push
                    (
                        $css,
                        $this->Htmls_Tag("STYLE",$file_css)
                    );
                }
            }
        }
        
        return $css;
    }
    
    //*
    //* $module specific files for $action existence.
    //*

    function MyApp_Interface_CSS_Module_Files_Existent($module,$action)
    {
        $files=array();
        foreach
            (
                $this->MyApp_Interface_CSS_Module_Files($module,$action)
                as $file
            )
        {
            if (file_exists($file))
            {
                array_push($files,$file);
            }
        }

        return $files;
    }
    
    //*
    //* $module specific files for $action.
    //*

    function MyApp_Interface_CSS_Module_Files($module,$action)
    {
        return
            array_merge
            (
                $this->MyApp_Interface_CSS_Module_File($module),
                $this->MyApp_Interface_CSS_Module_Action_Files
                (
                    $module,$action
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_CSS_Module_Action_Files($module,$action)
    {
        if (empty($action)) { return array(); }
        
        return
            array
            (
                join
                (
                    "/",
                    array
                    (
                        $this->MyApp_Interface_CSS_Path(),
                        $action.".css"
                    )
                ),
                join
                (
                    "/",
                    array
                    (
                        $this->MyApp_Interface_CSS_Path(),
                        $module,
                        $action.".css"
                    )
                )
            );
    }
    
    //*
    //* Returns nothing - override.
    //*

    function MyApp_Interface_CSS_Module_File($module)
    {
        return
            array
            (
                join
                (
                    "/",
                    array
                    (
                        $this->MyApp_Interface_CSS_Path(),
                        $module.".css"
                    )
                ),
            );
    }
}

?>