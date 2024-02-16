<?php

trait Texts_Display_Child_Item
{  
    //*
    //* Displays $child.
    //*
    //* If $children are given, their destination ids are closes on click.
    //*

    function Text_Display_Child_Item($text,$child,$children=array())
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Text_Display_Child_Item_Title
                    (
                        $text,$child,$children
                    ),
                    array
                    (
                        "CLASS" => "Text_List",
                    )
                ),
                $this->Text_Display_Child_Item_DIV
                (
                    $text,$child
                ),
            );
    }
    
    
    //*
    //* Create clickable (open/close) title of $child Text.
    //*

    function Text_Display_Child_Item_Title($text,$child,$children)
    {
        $dest_ids=
            $this->Text_Display_Children_Destination_IDs($text,$children);
        
        $dest_id=
            $this->Text_Display_Child_Item_Destination_ID($text,$child);
        
        $show_id="Show"."_".$dest_id;
        $hide_id="Hide"."_".$dest_id;
        
        return
            array
            (
                $this->Htmls_SPAN
                (
                    array
                    (
                        $this->Text_Display_Child_Item_Icon($text,$child,False),
                        $child[ "Name" ],
                    ),
                    array
                    (
                        "ID"      => $show_id,
                        "TITLE"   => $child[ "Title" ],
                        "ONCLICK" => array
                        (
                            $this->JS_Hide_Elements_By_ID
                            (
                                $dest_ids
                            ),
                            $this->JS_Show_Element_By_ID
                            (
                                $hide_id,
                                $display="initial"
                            ),
                            $this->JS_Hide_Element_By_ID
                            (
                                $show_id
                            ),
                            $this->JS_Show_Element_By_ID
                            (
                                $dest_id
                            ),
                            $this->Text_Display_Child_Item_JS_Load($text,$child),
                        )
                    )
                ),
                $this->Htmls_SPAN
                (
                    array
                    (
                        $this->Text_Display_Child_Item_Icon($text,$child,True),
                        $child[ "Name" ],
                    ),
                    array
                    (
                        "ID"      => $hide_id,
                        "TITLE"   => $child[ "Title" ],
                        "ONCLICK" => array
                        (
                            $this->JS_Show_Element_By_ID
                            (
                                $show_id,
                                $display="initial"
                            ),
                            $this->JS_Hide_Elements_By_ID
                            (
                                array($hide_id,$dest_id)
                            ),
                        ),
                    ),
                    array
                    (
                        "opacity" => '0.5',
                        "display" => 'none',
                    )
                ),
            );
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Item_Icon($text,$child,$hide)
    {
        $icon="fas fa-plus";
        if ($hide) { $icon="fas fa-minus"; }

        return $this->MyMod_Interface_Icon($icon,array(),3);
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Item_DIV($text,$child)
    {
        return
            $this->Htmls_DIV
            (
                "",
                array
                (
                    "TITLE" => $child[ "Title" ],
                    "ID"    => $this->Text_Display_Child_Item_Destination_ID
                    (
                        $text,$child
                    ),
                ),
                array
                (
                    "display" => 'block',
                )
            );
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Item_JS_Load($text,$child)
    {
        return
            $this->JS_Load_URL_2_Element_Do
            (
                $this->Text_Display_Child_Item_Destination_ID($text,$child),
                $this->Text_Display_Child_Item_URL($text,$child)
            );
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Item_ID($text,$child)
    {
        return $this->CGI_GET("Dest");;            
    }
    
    //*
    //*
    //*

    function Text_Display_Child_Item_Destination_ID($text,$child)
    {
        return "Texts_Root_Field_".$child[ "ID" ];        
    }
    
    
    //*
    //*
    //*

    function Text_Display_Child_Item_URL($text,$child)
    {
        //var_dump($this->CGI_URI2Hash());
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "Text" => $child[ "ID" ],
                    "Action" => "Display",
                    "NoMenu" => 1,
                    "Reload_Icons" => 1,

                    "PDest" => $this->CGI_GET("PDest"),
                    "Dest"  => $this->Text_Display_Child_Item_Destination_ID($text,$child),
                    //"No_Reload" => 1,
                )
            );
    }
    
 }

?>