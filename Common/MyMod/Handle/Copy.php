<?php

trait MyMod_Handle_Copy
{
    //*
    //* function MyMod_Handle_Copy, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Copy()
    {
        $title=$this->GetRealNameKey($this->Actions[ "Copy" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Copy" ],"PName");

        $this->MyMod_Handle_Copy_Form($title,$ptitle);
    }
    
    //*
    //* Preprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Pre_Process(&$item)
    {
    }
    
    //*
    //* Postprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Post_Process(&$item)
    {
    }
    
    //*
    //* Creates form for copying an item. If $_POST[ "Update" ]==1,
    //* calls Copy.
    //*

    function MyMod_Handle_Copy_Form($title,$copiedtitle)
    {
        $this->Singular=TRUE;
        $this->NoFieldComments=TRUE;

        $item=$this->MyMod_Handle_Copy_New();

        $action="Copy";
        $msg="";
        if ($this->CGI_POSTint("Copy")==1)
        {
            $res=$this->MyMod_Handle_Copy_Do($item,$msg);
            if ($res)
            {
                $this->MyMod_Handle_Copy_Redirect($item);
            }
        }


        foreach ($this->AddDefaults as $data => $value)
        {
            if (empty($item[ $data ]))
            {
                $item[ $data ]=$value;
                $item[ $data."_Value" ]=$value;
            }
        }
        
        $this->MyMod_Handle_Copy_Post_Process($item);
        $this->AddDefaults=$item;

        
        //$this->MyMod_HorMenu_Echo(TRUE,$this->CGI_GET("ID"));

        
        $this->Htmls_Echo
        (
            $this->Htmls_Form
            (
                1,
                "Copy_Form",
                $action,
                array
                (
                    $this->CGI_GET("Dest"),
                    "---",
                    $this->CGI_GET("PDest"),
                    $this->H(2,$title),
                    $msg,
                    $this->H(3,$this->MyMod_Item_Name_Get($item)),
                    $this->MyMod_Handle_Add_Table
                    (
                        $this->MyMod_Data_Writeable(),
                        "Copy"
                    ),
                ),
                $args=array
                (
                    "JS_Static" => True,
                    "Hiddens" => array
                    (
                        "Copy" => 1,
                    ),
                    "Anchor" => "HorMenu",
                    "Buttons" => $this->Buttons
                    (
                        $this->MyLanguage_GetMessage("Copy_Button_Title").
                        " ".
                        $this->MyMod_ItemName()
                    ),
                ),
                $options=array
                (
                    "ID" => "Copy_Form",
                )
            )
        );
    }

    //*
    //* Copy ItemHash to copied $item.
    //*

    function MyMod_Handle_Copy_New($from_item=array())
    {
        if (empty($from_item)) { $from_item=$this->ItemHash; }
        
        $item=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (empty($this->ItemData[ $data ][ "NoAdd" ]))
            {
                $item[ $data ]=$from_item[ $data ];
            }
        }
        
        $this->MyMod_Handle_Copy_Pre_Process($item);
        
        $this->MyMod_Data_Add_Default_Init($item);

        return $item;
    }
    
    
    //*
    //* Relocates after finished copying.
    //*

    function MyMod_Handle_Copy_Redirect($item)
    {
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);

        //$src_id="ID_".time();
        
        $dest_id=$this->CGI_GET("PDest");

        $this->Htmls_Echo
        (
            array
            (
                //Show in html
                $this->Htmls_DIV
                (
                    $this->JS_Click_Above($dest_id,$item[ "ID" ]),
                    array
                    (
                        //"ID" => $src_id,
                    )
                ),

                //Run JS
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        $this->JS_Click_Above($dest_id,$item[ "ID" ])
                    )
                )
            )
        );
        
        exit();
    }

    
    //*
    //* Copy item to DB.
    //*


    function MyMod_Handle_Copy_Do(&$item,&$msg)
    {
        $mtime=time();
        $item=
            array_merge
            (
                $item,
                $this->MyMod_Item_POST_Read(),
                $this->MyMod_Handle_Add_Fixed(),
                array
                (
                    "ATime" => $mtime,
                    "MTime" => $mtime,
                    "CTime" => $mtime,
                )
            );

        foreach (array_keys($this->ItemData()) as $data)
        {
            if
                (
                    !empty($this->ItemData[ $data ][ "Default" ])
                    &&
                    empty($item[ $data ])
                )
            {
                $item[ $data ]=$this->ItemData[ $data ][ "Default" ];
            }

            if (!empty($item[ $data ]))
            {
                $item[ $data ]=$this->CGI_Trim_Value($item[ $data ]);
            }
        }

        if ($this->MyMod_Item_Unique_Is($item))
        {
            foreach (array_keys($item) as $id => $data)
            {
                if
                    (
                        empty($this->ItemData[ $data ])
                        ||
                        $this->ItemData[ $data ][ "Derived" ]
                    )
                {
                    unset($item[ $data ]);
                }
            }

            $this->CGI_Trim_Hash($item);

            if (isset($this->ItemData[ $this->CreatorField ]))
            {
                $item[ $this->CreatorField ]=$this->LoginData[ "ID" ];
            }

            $item=$this->SetItemTimes($item);
            if (!empty($item[ "ID" ])) { unset($item[ "ID" ]); }

            
            $res=$this->Sql_Insert_Item($item);

            $item=$this->MyMod_Item_Derived_Data_Read($item);
            $item=$this->MyMod_Item_PostProcess($item);
            $this->MyMod_Log_Entry("Item Copied");

            $this->ItemHash=$item;

            //var_dump($item);

            return TRUE;
        }
        else
        {
          
            $msg=
               $this->H
               (
                    4,
                    $this->ItemName.
                    " ".
                    $this->MyLanguage_GetMessage
                    (
                        array("not","Copied")
                    )
               );
                    
            $this->ItemHash=$item;
            return FALSE;
        }
    }
}

?>