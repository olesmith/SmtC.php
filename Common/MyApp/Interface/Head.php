<?php

include_once("Head/Styles.php");
include_once("Head/Scripts.php");
include_once("Head/Metas.php");
include_once("Head/Links.php");

trait MyApp_Interface_Head
{
    use
        MyApp_Interface_Head_Styles,
        MyApp_Interface_Head_Scripts,
        MyApp_Interface_Head_Metas,
        MyApp_Interface_Head_Links;

    //*
    //* Returns nothing - override.
    //*

    function MyApp_Interface_Banner()
    {
        return array();
    }
    
    
    
    //*
    //* Sends http header then prints application head part.
    //*

    function MyApp_Interface_Head()
    {
        if ($this->CGI_GET("Action")=="Logoff")
        {
            $this->MyApp_Logoff_Do();
        }
        if (!$this->MyApp_Interface_RAW_Is())
        {            
            $this->Htmls_Echo
            (
                array
                (
                    $this->MyApp_Interface_Header(),
                    $this->MyApp_Interface_Layout(),
                )
            );

            exit();

            $this->Htmls_Indent_Inc($this->Body_Increment);
        }
        elseif (empty($_GET[ "NoHTML" ]))
        {
            $style="";
            if (!empty($args[ "Margin" ]))
            {
                $style=
                    " CLASS='SUBSCR'";
            }

            $hash=$this->CGI_URI2Hash();
            $url="?".$this->CGI_Hash2URI($hash);

            unset($hash[ "Dest" ]);
            unset($hash[ "NoHorMenu" ]);
            
            $rurl="?".$this->CGI_Hash2URI($hash);

        

            $html=
                array
                (
                    $this->MyApp_Interface_No_Dest(),
                    "   <DIV".$style.">",
                );

            array_push
            (
                $html,
                $this->MyApp_Interface_CSS_Module(),
                $this->MyApp_Interface_Banner(),
                $this->MyApp_Interface_Reload_Icons_DIV()
            );
            

            
            foreach (array("NoHorMenu","Dest") as $data)
            {
                if (!empty($args[ $data ]))
                {
                    unset($args[ $data ]);
                }
            }

            $this->Htmls_Echo($html);
        }
    }

    
    //*
    //* Create clip board Icon URL.
    //*

    function MyApp_Interface_Clip_Board_URL($keys=array())
    {
        if (!is_array($keys)) { $keys=array($keys); }
        
        $url=$this->MyApp_Interface_Reload_URL();

        $keys=
            array_merge
            (
                array
                (
                    "Dest","PDest","RAW","NoHorMenu","No_Reload","Reload_Icons"
                ),
                $keys
            );
        
        foreach ($keys as $key)
        {
            if (isset($url[ $key ]))
            {
                unset($url[ $key ]);
            }
        }
        
        return
            $this->CGI_Script_Full_Path().
            "?".
            $this->CGI_Hash2URI($url);
    }
    
    
    //*
    //* 
    //*

    function MyApp_Interface_No_Dest()
    {
        $head=array();
        if (empty($_GET[ "Dest" ]))
        {
            $head=$this->MyApp_Interface_Header();
        }
        
        return $head;
    }
    
    //*
    //* Detects whether we are RAW.
    //*

    function MyApp_Interface_RAW_Is()
    {
        $res=False;
        if (isset($_GET[ "RAW" ]))
        {
            if (!empty($_GET[ "RAW" ])) { $res=True; }
        }
        
        return $res;
    }
    
    //*
    //* sub MyApp_Interface_HEAD_Tag, Parameter list:
    //*
    //* HEAD tag with contents.
    //*
    //*

    function MyApp_Interface_HEAD_Tag()
    {
        return
            array_merge
            (
                $this->Htmls_Comment_Section
                (
                    "HTML HEAD section",
                    $this->Htmls_Tag
                    (
                        "HEAD",
                        array
                        (
                            $this->MyApp_Interface_METAs(),
                            $this->MyApp_Interface_Title(),
                            $this->MyApp_Interface_LINKs(),
                            $this->MyApp_Interface_STYLEs(),
                            $this->MyApp_Interface_SCRIPTs()
                        )
                    )
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_HTML_Tag, Parameter list:
    //*
    //* HTML tag with contents.
    //*
    //*

    function MyApp_Interface_HTML_Tag()
    {
        return
            $this->Htmls_Tag_Start
            (
                "HTML",
                array
                (
                    $this->MyApp_Interface_HEAD_Tag(),
                )
            );
     }
    
    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Header()
    {
        //Printed promptly!
        $this->MyApp_Interface_Headers_Send();

        return
            array_merge
            (
                $this->MyApp_Interface_DocType(),
                $this->MyApp_Interface_HTML_Tag()
            );
    }
    
    
    //*
    //* sub MyApp_Interface_DocType, Parameter list:
    //*
    //* Sends 'before HTML tag' doc type.
    //*
    //*

    function MyApp_Interface_DocType()
    {
        return
            array
            (
                $this->MyApp_Interface_Head_DocType
            );
    }
    
    
    //*
    //* sub MyApp_Interface_, Parameter list:
    //*
    //* Returns interface header <TITLE>...</TITLE> section.
    //*
    //*

    function MyApp_Interface_Title()
    {
        return
            array
            (
                $this->HtmlTags("TITLE",$this->MyApp_Interface_HEAD_TITLE())
            );
    }
    
   

    //*
    //* sub MyApp_Interface_HEAD_Title, Parameter list:
    //*
    //* Returns title to include as HTML TITLE.
    //*
    //*

    function MyApp_Interface_HEAD_Title()
    {
        $id=$this->GetGET("ID");

        $vals=array($this->CGI_GET("Action"));
        if ($this->Module)
        {
            if ($id!="" && $id>0)
            {
                array_push($vals,$this->Module->ItemName);
            }
            else
            {
                array_push($vals,$this->Module->ItemsName);
            }
        }

        foreach ($this->ExtraPathVars as $id => $var)
        {
            if ($this->$var!="")
            {
                array_push($vals,$this->$var);
            }
        }

        $title=$this->MyApp_Title()."::";
        
        $action=$this->MyActions_Detect();
        if ($this->Module)
        {
            if (!empty($action) && isset($this->Module->Actions[ $action ]))
            {
                $action=$this->GetRealNameKey($this->Module->Actions[ $action ],"Name");

                $action=preg_replace('/#ItemsName/',$this->Module->ItemsName,$action);
                $action=preg_replace('/#ItemName/',$this->Module->ItemsName,$action);
                $id=$this->GetGET("ID");
                if ($id!="" && $id>0)
                {
                    $name=$this->Module->MyMod_Item_Name_Get($this->Module->ItemHash);
                    array_push($vals,$name);
                }
            }
        }
        else
        {
            array_push($vals,$action);
        }

        return 
            $title.
            join("::",$vals).
            "";
    }
}

?>