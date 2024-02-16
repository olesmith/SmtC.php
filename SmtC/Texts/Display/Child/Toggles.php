<?php

trait Texts_Display_Child_Toggles
{
    //*
    //*
    //*

    function Text_Display_Child_Toggles($text,$child)
    {
        $toggles=array();
        foreach
            (
                $this->Text_Display_Child_Toggle_Actions($text,$child)
                as $action => $def
            )
        {
            array_push
            (
                $toggles,
                $this->Text_Display_Child_Toggle($text,$child,$action,$def)
            );
        }

       
        return $toggles;
    }

    //*
    //* Toggle Actions for $child.
    //*
    
    function Text_Display_Child_Toggle_Actions($text,$child)
    {
        return
            array
            (
                "Display" => array
                (
                    "Title" => $child[ "Title" ],
                    "Icons" => array
                    (
                        $this->ApplicationObj()->Texts_Icon,
                        $this->ApplicationObj()->Texts_Alt_Icon,
                    ),
                ),
            );
    }
    
    //*
    //* Unique typed IDs.
    //*

    function Text_Display_Child_Toggle_Cell_ID($type,$text,$child,$action="")
    {
        $keys=array($type);
        
        if (!empty($action))
        {
            array_push($keys,$action);
        }

        array_push($keys,"T_".$text[ "ID" ],"C_".$child[ "ID" ]);
        
        return $keys;
    }
    
    
    //*
    //*
    //*

    function Text_Display_Child_Toggle($text,$child,$action,$def)
    {
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
                            "CLASS" => "fa-xs",
                            "Show" => $this->Text_Display_Child_Toggle_Cell_ID
                            (
                                "Show",$text,$child,$action
                            ),
                            "Hide" =>  $this->Text_Display_Child_Toggle_Cell_ID
                            (
                                "Hide",$text,$child,$action
                            ),
                            "Destination" => array
                            (
                                $this->Text_Display_Child_Toggle_Destination_ID
                                (
                                    $text,$child,$action
                                )
                            ),
                            "URL" => $this->Text_Display_Child_Toggle_Destination_URL
                            (
                                $text,$child,$action,$def
                            ),
                            "Opacities" => array
                            (
                                '1','0.5','0.75',
                            ),
                            
                            "Display" => 'block',
                        )
                    )
                ),
            );
    }
              
    //*
    //*
    //*

    function Text_Display_Child_Toggle_Destination_ID($text,$child,$action)
    {
        $dest_id=$this->CGI_GET("Dest");
        if ($this->Text_Is_Inline($child))
        {
            $dest_id=
                join
                (
                    "_",
                    $this->Text_Display_Child_Toggle_Cell_ID
                    (
                        "Cell",
                        $text,
                        $child
                    )
                );
        }

        return $dest_id;
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Toggle_Destination_URL($text,$child,$action,$def)
    {
        $url=
           array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "Action" => $action,
                    "Dest" => $this->Text_Display_Child_Toggle_Destination_ID
                    (
                        $text,$child,$action,$def
                    ),
                    "Text" => $child[ "ID" ],
                    "ID" => $child[ "ID" ],
                    "NoMenu" => 1,
                )
            );

        if ($this->Text_Is_Inline($child))
        {
            $url[ "NoMenu" ]=1;
        }

        return $url;
    }
}

?>