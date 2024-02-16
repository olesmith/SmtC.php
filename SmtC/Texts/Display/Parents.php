<?php

trait Texts_Display_Parents
{
    //*
    //*
    //*
    
    function MyMod_Module_Menu_Horisontal($id,$text=array())
    {
        $text=$this->ItemHash;

        return
            $this->Texts_Display_Parents_Menu($text);
    }
    
    //*
    //*
    //*
    
    function Texts_Display_Parents_Menu(&$text)
    {         
        $html=array("[");
        foreach ($this->Texts_Parents($text) as $parent)
        {
            array_push
            (
                $html,
                $this->Texts_Display_Parent_Menu_Cell
                (
                    $parent,$color='blue'
                ),
                "|"
            );
        }

        array_push
        (
            $html,
            $this->Texts_Display_Parent_Menu_Cell
            (
                $text,$color='black',False,"Name"
            ),
            "]",
            $this->BR()
        );

        return
            $this->Htmls_DIV
            (
                $html,
                array
                (
                    "ID" => $this->Texts_Display_Parents_Menu_ID($text)
                )
            );
    }
    //*
    //*
    //*
    
    function Texts_Display_Parents_Menu_ID($text)
    {
        return "Texts_Menu_".$text[ "ID" ];
    }
    
    //*
    //*
    //*
    
    function Texts_Display_Parent_Menu_Cell($parent,$color,$onclick=True,$key="Name")
    {
        return
            array
            (
                $this->Htmls_SPAN
                (
                    $parent[ $key ],
                    //$options=
                    $this->Texts_Display_Parent_Menu_Cell_Options
                    (
                        $parent,$onclick
                    ),
                    //$style=
                    array
                    (
                        "color" => $color,
                    )
                ),
            );
    }
    
    //*
    //*
    //*
    
    function Texts_Display_Parent_Menu_Cell_Options($parent,$onclick=True)
    {
        $options=
            array
            (
                "TITLE" => $parent[ "Title" ],  
            );

        if ($onclick)
        {
            $options[ "ONCLICK" ]=
                array
                (
                    $this->Texts_Display_Parent_Menu_Cell_JS($parent),
                );
        }
        
        return $options;
    }

    //*
    //*
    //*
    
    function Texts_Display_Parent_Menu_Cell_JS($parent)
    {
        return
            $this->JS_Load_URL_2_Element
            (
                $this->Texts_Display_Parent_Menu_Cell_URL($parent),
                $this->CGI_GET("Dest")
            );
    }
    
    
    //*
    //*
    //*
    
    function Texts_Display_Parent_Menu_Cell_URL($parent)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "ID"   => $parent[ "ID" ],
                    "Text" => $parent[ "ID" ],
                    "NoMenu" => 1,
                    "RAW" => 0,
                    "Dest" => "ModuleCell",
                )
            );
    }
}

?>