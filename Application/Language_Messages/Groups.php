<?php

include_once("Groups/Defaults.php");
include_once("Groups/Names.php");
include_once("Groups/Titles.php");
include_once("Groups/Update.php");

class Language_Messages_Groups extends Language_Messages_Group
{
    use
        Language_Messages_Groups_Defaults,
        Language_Messages_Groups_Names,
        Language_Messages_Groups_Titles,
        Language_Messages_Groups_Update;
    
    //*
    //* 
    //*

    function Language_Group_Type_Get($singular)
    {
        $type=$this->Language_Group_Type;
        if ($singular) { $type=$this->Language_SGroup_Type; }

        return $type;
    }
    
    //*
    //* Handles edit of one message names and titles.
    //* One row for each language.
    //* 

    function Language_Message_Messages()
    {
        $edit=$this->Profile_Admin_Is();;

        $item=$this->ItemHash;
        
        $item=$this->MyMod_Item_Update_CGI($item);
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    $edit,
                    "Edit_Message_".$item[ "ID" ],
                    $action="",
                    $this->Language_Message_Html
                    (
                        $edit,
                        $item
                    ),
                    array
                    (
                        "Buttons" => $this->Buttons()
                    )
                )
            )
        );
        
    }
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Html($edit,$item)
    {
        return
            $this->Htmls_Table
            (
                $this->Language_Message_Titles($edit,$item),
                $this->Language_Message_Table($edit,$item)
            );
    }
    
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Table($edit,$item)
    {
        $table=array();
        foreach ($this->Language_Keys() as $lkey)
        {
            array_push
            (
                $table,
                $this->Language_Message_Row($edit,$item,$lkey)
            );
        }

        return $table;
    }
    
    //*
    //* 
    //* 

    function Language_Message_Titles($edit,$item)
    {        
        
        $titles=array("Language");
        foreach (array_keys($this->LanguageDataKeys) as $data)
        {
            array_push
            (
                $titles,
                $this->Language_Message_Title_Cell($edit,$item,$data)
            );
        }

        return $titles;
    }
    
    //*
    //* 
    //* 

    function Language_Message_Title_Cell($edit,$item,$data)
    {
        $ids=array();
        foreach ($this->Language_Keys() as $lang)
        {
            array_push
            (
                $ids,
                $this->Language_Message_Cell_ID($item,$data."_".$lang)
            );
        }

        $js=
            array
            (
                $this->JS_Input_Value_Set_Elements_ByID
                (
                    $ids
                ),
            );
        
        return
            array
            (
                $data,
                    
                $this->Htmls_SPAN
                (
                    $this->MyMod_Interface_Icon("fas fa-trash",array(),4),
                    array
                    (
                        "ONCLICK" => $js,
                        "TITLE" => $js,
                    ),
                    array
                    (
                        'color' => 'blue',
                    )
                )
            );
    }

    
    //*
    //* 
    //* 

    function Language_Message_Row($edit,$item,$lkey)
    {
        $row=
            array
            (
                $this->Language_Message_Language_Cell
                (
                    $edit,$item,$lkey
                )
            );
        
        foreach (array_keys($this->LanguageDataKeys) as $key)
        {
            $redit=$edit;
            if ($key=="MTime") { $redit=0; }

            $data=$key."_".$lkey;
            
            array_push
            (
                $row,
                $this->Language_Message_Cell($redit,$item,$data)
            );
        }

        return $row;
    }
    
    //*
    //* 
    //* 

    function Language_Message_Language_Cell($edit,$item,$lkey)
    {
        $ids=array();
        foreach (array_keys($this->LanguageDataKeys) as $data)
        {
           array_push
            (
                $ids,
                $this->Language_Message_Cell_ID($item,$data."_".$lkey)
            );
        }

        $js=
            array
            (
                $this->JS_Input_Value_Set_Elements_ByID
                (
                    $ids
                ),
            );
        
        return
            array
            (
                $this->B($lkey),
                    
                $this->Htmls_SPAN
                (
                    $this->MyMod_Interface_Icon("fas fa-trash",array(),4),
                    array
                    (
                        "ONCLICK" => $js,
                        "TITLE" => $js,
                    ),
                    array
                    (
                        'color' => 'blue',
                    )
                ),
            );
    }
    //*
    //*
    //* 

    function Language_Message_Cell($edit,$item,$data)
    {
        return
            array
            (
                $this->Language_Message_Cell_Icons($item,$data),
                $this->MyMod_Data_Field($edit,$item,$data)
            );
    }
    
    //*
    //*
    //* 

    function Language_Message_Cell_Icons($item,$data)
    {
        return
            array
            (
                $this->Language_Message_Cell_Icon_Zero($item,$data),
                $this->Language_Message_Cell_Icon_Spread($item,$data)
            );
    }

    //*
    //*
    //* 

    function Language_Message_Cell_ID($item,$data)
    {
        return
            join
            (
                "_",
                array
                (
                    $this->ModuleName,
                    $data,
                    $item[ "ID" ]
                )
            );
    }
    
    //*
    //*
    //* 

    function Language_Message_Cell_Spread_IDs($item,$data)
    {
        $src_id=
            $this->Language_Message_Cell_ID($item,$data);

        
        $ids=array();
        foreach ($this->Language_Keys() as $lang)
        {
            foreach (array("Name","Title") as $rdata)
            {
                $dest_id=
                    $this->Language_Message_Cell_ID($item,$rdata."_".$lang);

                if ($dest_id!=$src_id)
                {
                    array_push
                    (
                        $ids,
                        $dest_id
                    );
                }
            }
        }
        
        return $ids;
    }

    
    //*
    //*
    //* 

    function Language_Message_Cell_Icon_Zero($item,$data)
    {
        $js=
            array
            (
                $this->JS_Input_Value_Set_Element_ByID
                (
                    $this->Language_Message_Cell_ID($item,$data)
                ),
            );
        
        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Interface_Icon("fas fa-trash",array(),4),
                array
                (
                    "ONCLICK" => $js,
                    "TITLE" => $js,
                ),
                array
                (
                    'color' => 'blue',
                )
            );
    }
    
    //*
    //* 
    //* 

    function Language_Message_Cell_Icon_Spread($item,$data)
    {
        $js=
            array
            (
                $this->JS_Input_Copy_To_Elements_ByID_If_Empty
                (
                    $this->Language_Message_Cell_ID($item,$data),
                    $this->Language_Message_Cell_Spread_IDs($item,$data)
                )
            );
        
        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Interface_Icon("fas fa-sign-in-alt",array(),4),
                array
                (
                    "ONCLICK" => $js,
                    "TITLE" => $js,
                ),
                array
                (
                    'color' => 'blue',
                )
            );
    }
}
?>