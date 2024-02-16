<?php

trait App_Start
{
    //*
    //* 
    //*

    function MyApp_Handle_Start($echo=True)
    {
        parent::MyApp_Handle_Start($echo);

        $this->Htmls_Echo
        (
            $this->MyApp_Handle_Start_Generate()
        );
    }

    //*
    //* 
    //*

    function MyApp_Handle_Start_Generate($echo=True)
    {
        $html=
            array
            (
                $this->Htmls_H(1,"SmtC"),
                $this->Htmls_H(2,"Show me the Code"),
            );

        if ($this->Profile_Friend_Is())
        {
            array_push
            (
                $html,
                $this->MyApp_Handle_Start_Friend()
            );
        }
        else
        {
            array_push
            (
                $html,
                $this->MyApp_Handle_Start_Non_Friend()
            );
        }
        
        return $html;
    }
    
    //*
    //* 
    //*

    function MyApp_Handle_Start_Non_Friend()
    {
        $url=$this->CGI_URI2Hash();
        
        $dest_id="ModuleCell";
        $url=
            array
            (
                
                "App"        => "SmtC",
                "ModuleName" => "Friends",
                "Action"     => "Search",
                "RAW"        => 1,
                "Dest"       > $dest_id="ModuleCell",
            );
        
        if (!empty($id=$this->CGI_GETint("Friend")))
        {
            $url[ "ModuleName" ]="Friends";
            $url[ "Action" ]="Tops";
            $url[ "Friend" ]=$id;
        }
        
        return
            array
            (
                $this->Htmls_SCRIPT
                (
                    $this->JS_Load_Once
                    (
                        $url,
                        $dest_id
                    )
                ),
            );
    }
   
    //*
    //* 
    //*

    function MyApp_Handle_Start_Friend()
    {
        $url=$this->CGI_URI2Hash();
        
        if (!empty($id=$this->CGI_GETint("Text")))
        {
            $url[ "ModuleName" ]="Texts";
            $url[ "Action" ]="Display";
            $url[ "Text" ]=$id;
        }
        else
        {
            $url[ "ModuleName" ]="Friends";
            $url[ "Action" ]="Tops";        
            $url[ "Friend" ]=$this->LoginData("ID");            
        }
        
        //$dest_id="ModuleCell";        
        return
            array
            (
                $this->Htmls_SCRIPT
                (
                    $this->JS_Load_Once
                    (
                        array_merge
                        (
                            $url,
                            array
                            (
                                "RAW"        => 1,
                                "Dest"       > $dest_id="ModuleCell",
                            )
                        ),
                        $dest_id
                    )
                ),
            );
    }
}

?>