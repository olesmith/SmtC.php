<?php

trait Texts_Display_Icons
{    
    //*
    //* Triggers Text module reload icons.
    //*
    //* Overloads MyMod_Interface_Reload_Icons().
    //*
    //* Returns empty list, unless GET "Reload_Icons" is 1.
    //*

    function MyMod_Interface_Reload_Icons()
    {
        if ($this->CGI_GETint("Reload_Icons")!=1)
        {
            return array();
        }
        
        $text=$this->ItemHash;

        return
            $this->Text_Display_Icons_Toggle_Icons($text);
    }

    //*
    //* ID of the destination div.
    //*

    function Text_Display_Icons_Destination_ID($text)
    {
        return array("Destination","T_".$text[ "ID" ]);
    }
    //*
    //*
    //*
    
    function Text_Display_Icons_Toggles($text)
    {
        return
            array
            (
                $this->Text_Display_Icons_Toggle_Icons($text),
                $this->Text_Display_Icons_Toggles_Title($text),
            );
    }
    
    //*
    //*
    //*
    
    function Text_Display_Icons_Toggles_Title($text)
    {
        return
            $this->Htmls_DIV
            (
                $text[ "Name" ].":",
                array
                (
                    "CLASS" => "Toggles_Title",
                )
            );
    }
    
    
    //*
    //*
    //*

    function Text_Display_Icons_Toggle_Icons($text)
    {
        //if (!empty($_GET[ "No_Reload" ])) { return array(); }
        
        $toggles=array();
        foreach
            (
                $this->Text_Display_Icons_Toggle_Actions($text)
                as $action => $def
            )
        {
            if ($this->MyAction_Allowed($action,$text))
            {
                array_push
                (
                    $toggles,
                    $this->Text_Display_Icons_Toggle($text,$action,$def)
                );
            }
        }

        return $toggles;
    }
    
    //*
    //*
    //*
    
    function Text_Display_Icons_Toggle_Actions($text)
    {
        if (empty($this->CGI_GETint("Reload_Icons")))
        {
            return array();
        }
        
        return
            array
            (
                "Edit" => array
                (
                    "Icons" => array
                    (
                        "fas fa-edit","fas fa-edit"
                    ),
                ),
                /* "Children" => array */
                /* ( */
                /*     "Icons" => array */
                /*     ( */
                /*         $this->ApplicationObj()->Children_Icon, */
                /*         $this->ApplicationObj()->Children_Icon, */
                /*     ), */
                /* ), */
            );
    }
    
 
    //*
    //*
    //*

    function Text_Display_Icons_Toggle($text,$action,$def)
    {
        $dest_id=
            $this->Text_Display_Icons_Destination_ID
            (
                $text
            );
        
        $dest_id=$this->Text_Display_Html_DIV_ID($text);

        //array($this->ApplicationObj()->MyApp_Interface_Reload_Destination());
        return
            array
            (
                $this->Hmls_Display_Toggles
                (
                    array_merge
                    (
                        $def,
                        array
                        (
                            "Class" => "fa-xs",
                            "Show" => $this->Text_Display_Icons_Toggle_Cell_ID
                            (
                                "Show",$text,$action
                            ),
                            "Hide" =>  $this->Text_Display_Icons_Toggle_Cell_ID
                            (
                                "Hide",$text,$action
                            ),
                            "Destination" => $dest_id,
                            "URL" => array_merge
                            (
                                $this->CGI_URI2Hash(),
                                array
                                (
                                    "Action" => $action,
                                    "No_Reload" => join("_",$dest_id),
                                    "Reload_Icons" => 1,
                                    "Dest" => join("_",$dest_id),
                                    "ID" => $text[ "ID" ],
                                )
                            ),
                            "Opacities" => array
                            (
                                '1','0.5','0.75',
                            ),
                            "Display" => 'block',
                        )
                    ),
                    array
                    (
                        "TITLE" => array
                        (
                            $this->MyActions_Entry_Title($action,$text).",",
                            $text[ "Title" ],
                        )
                    )
                ),
            );
    }
    
    //*
    //* Unique typed IDs.
    //*

    function Text_Display_Icons_Toggle_Cell_ID($type,$text,$action="")
    {
        $keys=array($type);
        
        if (!empty($action))
        {
            array_push($keys,$action);
        }

        array_push($keys,"T_".$text[ "ID" ]);
        
        return $keys;
    }
    

    /* //\* */
    /* //\* */
    /* //\* */
    
    /* function Text_Display_Icons_DIV($text) */
    /* { */
    /*     return */
    /*         $this->Htmls_DIV */
    /*         ( */
    /*             array */
    /*             ( */
    /*                 $this->Text_Display_Icons_Toggles($text), */
    /*             ), */
    /*             array */
    /*             ( */
    /*             ), */
    /*             array */
    /*             ( */
    /*                 "text-align" => 'left', */
    /*             ) */
    /*         ); */
    /* } */
    
    /* //\* */
    /* //\* */
    /* //\* */

    /* function MyMod_Interface_Reload_URL000($url) */
    /* { */
    /*     $dest="Destination_T_".$this->CGI_GETint("Text"); */
        
    /*     //var_dump($dest); */
        
    /*     return */
    /*         array_merge */
    /*         ( */
    /*             $url, */
    /*             array */
    /*             ( */
    /*                 "Dest" => $dest, */
    /*                 //"No_Reload" => 1, */
    /*             ) */
    /*         ); */
    /* } */
}

?>