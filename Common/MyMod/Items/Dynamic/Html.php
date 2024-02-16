<?php

trait MyMod_Items_Dynamic_Html
{
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Html($edit,$items,$group="",$extrarows=array(),$options=array(),$notitle=True,$form=False)
    {
        $this->ItemData();
        $this->Actions();
        $this->ItemDataGroups();
        
        if (empty($group)) { $group=$this->MyMod_Group_Default; }

        $items=
            $this->MyMod_Items_Dynamic_Items_Allowed($edit,$items);

        if ($this->CGI_POSTint("Update")==1)
        {
            $items=$this->MyMod_Items_Update($items);
        }

        $this->Group=$group;
        $this->Items=$items;

        $this->MyMod_Items_Dynamic_Html_Defs_Init($edit,$group);

        
        $scripts=
            $this->Htmls_Menues_Dynamic_Scripts_Entries($debug=False);

        $table=
            $this->MyMod_Items_Dynamic_Table
            (
                $edit,$items,$group
            );

        $title=array();
        $titles=array();
        if (!$notitle)
        {
            $title=
                array
                (
                    $this->H
                    (
                        2,
                        $this->MyMod_Items_Dynamic_Html_Title
                        (
                            $edit,$items,$group
                        )
                    ),
                );

            $titles=
                $this->MyMod_Items_Dynamic_Paging_Titles($items);
        }

        

        if (!empty($method=$this->ItemDataGroups($group,"Pre_Text_Method")))
        {
            $titles=
                array
                (
                    $this->$method($edit,$items,$group),
                );
        }
        
        $html=array();

        $items_table=
            $this->Htmls_DIV
            (
                array
                (
                    $titles,
                    array
                    (
                        $this->MyMod_Items_Dynamic_Paging_Title($items),
                    ),

                    $this->Htmls_Table
                    (
                        "",
                        array_merge
                        (
                            $title,

                            $this->MyMod_Items_Dynamic_Plural_Rows
                            (
                                $items,
                                $group,
                                $extrarows
                            ),

                            $this->MyMod_Items_Dynamic_Html_Titles
                            (
                                $edit,$items,$group
                            ),
                            $table
                        ),
                        array
                        (
                            "STYLE" => array
                            (
                                "overflow" => 'scroll',
                            ),
                        )
                    ),
                ),
                array
                (                        
                    "CLASS" => "Page_".$this->MyMod_Paging_No,
                    "STYLE" => $this->MyMod_Items_Dynamic_Html_DIV_STYLE(),
                )
            );

        if ($edit!=1) { $form=False; }

        $items_table=
            $this->Htmls_Form
            (
                $form,
                join
                (
                    "_",
                    array
                    (
                        $this->ModuleName,
                        "EditList",
                        $this->CGI_GETint("Page"),
                    )
                ),

                "",
                
                $contents=
                $items_table,

                $args=
                array
                (
                    "Buttons" => $this->Buttons(),
                    "Hiddens" => array
                    (
                        "Update" => 1,
                    ),
                )
            );
                
        if ($this->MyMod_Paging_N>1)
        {
            $pagesmenu=array();
            if (empty($this->CGI_GETint("NoPageMenu")))
            {
                $this->MyMod_Paging_NItems=count($items);
                
                $pagesmenu=
                    $this->MyMod_Items_Dynamic_Paging
                    (
                        $items,$items_table
                    );
            }
            else { $pagesmenu=$items_table; }

            $html=
                array_merge
                (
                    $html,
                    array
                    (
                        array
                        (
                            $pagesmenu,
                        ),
                    )
                );
        }
        else { $html=$items_table; }

        return
            array
            (
                array($html),//array to force line break!
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        $this->MyMod_Items_Dynamic_Loads_JS
                        (
                            $edit,$items,$group
                        ),
                    )
                ),
            );
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Html_DIV_STYLE()
    {
        $style=array();
        if ($this->MyMod_Mobile_Is())
        {
            $style[ "overflow-x"  ]='visible';
        }

        return $style;
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Items_Allowed($edit,$items)
    {
        $action="Show";
        if ($edit==1) { $action="Edit"; }
        
        $ritems=array();
        foreach ($items as $item)
        {
            if ($this->MyAction_Allowed("Show",$item))
            {
                array_push($ritems,$item);
            }
        }

        return $ritems;
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Html_Titles($edit,$items,$group)
    {
        return
            $this->MyMod_Item_Dynamic_Title_Rows
            (
                $group,
                $items,
                $this->MyMod_Items_Dynamic_Html_Title
                (
                    $edit,$items,$group
                )
            );
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Html_Title($edit,$items,$group)
    {
        $title="";
        if (count($items)==0)
        {
            $title=
                $this->MyLanguage_GetMessage("Without").
                " ".
                $this->MyMod_ItemsName();
        }
        else
        {
            $title=
                count($items).
                " ".
                $this->MyMod_ItemsName();
        }

        return $title;
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Html_Defs_Init($edit,$group)
    {        
        $this->Defs=$this->ItemDataGroups($group,"Dynamic");

        if (empty($this->Defs))
        {
            var_dump($this->ModuleName.", Dynamic Group ".$group." Dynamic key not found");
            exit();
        }
        
        foreach (array_keys($this->Defs) as $action)
        {
            if (empty($this->Defs[ $action ][ "Action" ]))
            {
                $this->Defs[ $action ][ "Action" ]=$action;
            }
            if (empty($this->Defs[ $action ][ "Module" ]))
            {
                $this->Defs[ $action ][ "Module" ]=$this->ModuleName;
            }
        }

        $this->ItemDataGroups[ $group ][ "Dynamic" ]=$this->Defs;

        if (empty($this->ItemDataGroups[ $group ][ "BG_Colors" ]))
        {
            $this->ItemDataGroups[ $group ][ "BG_Colors" ]=
                $this->MyMod_Items_Dynamic_Table_Colors;
        }

        if (!empty($this->ItemDataGroups[ $group ][ "Sort_Method" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "Sort_Method" ];
            $items=$this->$method($items);
        }
      
    }
}

?>