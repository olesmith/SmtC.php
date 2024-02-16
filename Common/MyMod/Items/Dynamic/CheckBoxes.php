<?php


trait MyMod_Items_Dynamic_CheckBoxes
{
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_CheckBox($group,$item=array(),$options=array(),$style=array())
    {
        if (empty($item[ "ID" ]))
        {
            return
                $this->Htmls_SPAN
                (
                    //$contents=
                    array
                    (
                        $this->MyMod_Interface_Icon("fas fa-plus"),
                    ),
                    //$options=
                    array
                    (
                        "ID" => $this->MyMod_Item_Dynamic_CheckBox_ID
                        (
                            $group,$item
                        ),
                        
                        "ONCLICK" => $this->MyMod_Item_Dynamic_CheckBox_OnChange($group),
                        "CLASS" => "Show",
                    ),
                    array
                    (
                        "color" => "orange",
                    )
                );
        }
        
        return 
            $this->Htmls_CheckBox
            (
                $this->MyMod_Item_Dynamic_CheckBox_ID
                (
                    $group,$item
                ),
                $value=1,
                $this->MyMod_Item_Dynamic_CheckBox_Checked
                (
                    $group,$item
                ),
                $this->MyMod_Item_Dynamic_CheckBox_Disabled
                (
                    $group,$item
                ),

                
                $this->MyMod_Item_Dynamic_CheckBox_Options
                (
                    $group,$options,$style,$item
                )
            );
            
    }

    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_Options($group,$options,$style,$item=array())
    {
        return
            array_merge
            (
                array
                (
                    "ID" => $this->MyMod_Item_Dynamic_CheckBox_ID
                    (
                        $group,$item
                    ),
                    "CLASS" => $this->MyMod_Item_Dynamic_CheckBox_Classes
                    (
                        $group,$item
                    ),
                    /* "TITLE" => $this->MyMod_Item_Dynamic_CheckBox_Classes */
                    /* ( */
                    /*     $group,$item */
                    /* ), */
                    "ONCHANGE" => $this->MyMod_Item_Dynamic_CheckBox_OnChange
                    (
                        $group,$item
                    ),
                    "STYLE" => $this->MyMod_Item_Dynamic_CheckBox_STYLE
                    (
                        $group,$style,$item
                    ),
                ),
                $options
            );
    }
    
    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_STYLE($group,$style,$item=array())
    {
        if (empty($style[ "display" ]))
        {
            $def=$this->ItemDataGroups($group,"Dynamic");
            if (empty($item))// && !empty($def[ "Check_Boxes" ]))
            {
                $style[ "display" ]='inline';
            }
            else
            {
                $style[ "display" ]='none';
            }
        }
        
        return $style;
    }

    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_OnChange($group,$item=array())
    {
        $js=array();
        if (empty($item[ "ID" ]))
        {
            //Top (titles) checkbox
            $js=
                array
                (
                    $this->JS_CheckBox_Group_Set_All
                    (
                        $this->MyMod_Item_Dynamic_CheckBox_ID($group,$item),
                        join
                        (
                            " ",
                            $this->MyMod_Item_Dynamic_CheckBox_Classes($group)
                        ),
                        'initial'
                    ),
                    $this->JS_Toggle_Element_By_ID
                    (
                        $this->MyMod_Item_Dynamic_Title_Menu_Row_ID($group),
                        "table-row"
                    ),
                    $this->JS_Opacity_Toggle
                    (
                        0.7
                    ),
                );
        }
        else  //if (False)
        {
            $js=
                array
                (
                    $this->JS_Toggle_Element_By_ID
                    (
                        $this->MyMod_Item_Dynamic_Title_Menu_Row_ID($group),
                        "table-row"
                    ),
                );
        }

        return $js;
    }

    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_ID($group,$item=array())
    {
        $dest=$this->CGI_GET("Dest");
        $ids=preg_split('/_+/',$dest);
        
        array_push($ids,"P".$this->MyMod_Paging_No);
        

        if (!empty($item[ "ID" ]))
        {
            array_push($ids,$item[ "ID" ]);
            
        }
        return join("_",$ids);
    }
    
    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_Classes($group,$item=array())
    {
        $dest=$this->CGI_GET("Dest");
        $classes=preg_split('/_+/',$dest);
        
        array_push($classes,"P".$this->MyMod_Paging_No);
        

        if (!empty($item[ "ID" ]))
        {
            array_push($classes,$item[ "ID" ]);
            
        }
        return $classes;
    }
    
    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_Titles($group,$item=array())
    {
        $name=$this->MyMod_ItemName();

        if ($item[ "ID" ])
        {
            $name=
                $this->MyLanguage_GetMessage("All").
                " ".
                $this->MyMod_ItemName();
        }
        
        return
            join
            (
                " ",
                array
                (
                    $this->MyLanguage_GetMessage("Select"),
                    $name
                )
            );
    }
    
    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_Disabled($group,$item=array())
    {
        return False;
    }
    //*
    //*
    //*

    function MyMod_Item_Dynamic_CheckBox_Checked($group,$item=array())
    {
        return False;
    }
}

?>