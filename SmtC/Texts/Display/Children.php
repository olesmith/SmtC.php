<?php

trait Texts_Display_Children
{
    //*
    //* Displayed as subitems.
    //*

    function Text_Display_Children_Mode_Items($text)
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Htmls_DIV
                    (
                        $this->Text_Display_Children_Mode_Items_Html
                        (
                            $text,
                            $this->Text_Display_Children_Read($text,$mode=1)
                        ),
                        //$options=
                        array
                        (
                            "CLASS" => "Text_List",
                            "STYLE" => $this->Text_Display_List_Style($text),
                        ),
                        //$lioptions=
                        array
                        (
                            "CLASS" => "Text_List",
                        ),
                        $this->Text_Display_List_Type($text)
                    )
                ),
                $this->Text_Display_Children_Mode_Items_URL($text)
            );
        
    }

    //*
    //* Generate list hmtl
    //*

    function Text_Display_Children_Mode_Items_Html($text,$children)
    {
        $html=array();
        foreach ($children as $child)
        {
            array_push
            (
                $html,
                $this->Text_Display_Child($text,$child,$children)
            );
        }

        return $html;
    }
    
    //*
    //* 
    //*

    function Text_Display_Children_Mode_Items_URL($text)
    {
        $html=array();
        if (!empty($text[ "URL" ]))
        {
            if (preg_match('/\.pdf\b/i',$text[ "URL" ]))
            {
                $height=$width="400px";
                //if (!empty(
                array_push
                (
                    $html,
                    $this->Htmls_A
                    (
                        $text[ "URL" ],
                        //$alttext=
                        $text[ "Name" ].": ".$text[ "URL" ],
                        $text[ "Title" ].": ".$text[ "URL" ],
                        array
                        (
                            "CLASS" => "Text_Child_URL",
                        )
                    )
                );
            }
        }

        return
            $this->Htmls_DIV
            (
                $html,
                array
                (
                    "CLASS" => "Text_Child_URL",
                )
            );
    }
    
    //*
    //* Displayed as list (enumerate,itemize).
    //*

    function Text_Display_Children_Mode_List($text)
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Htmls_List
                    (
                        $this->Text_Display_Children_Mode_List_Html
                        (
                            $text,
                            $this->Text_Display_Children_Read($text,$mode=2)
                        ),
                        //$options=
                        array
                        (
                            "CLASS" => "Text_List",
                            "STYLE" => $this->Text_Display_List_Style($text),
                        ),
                        //$lioptions=
                        array
                        (
                            "CLASS" => "Text_List",
                        ),
                        $this->Text_Display_List_Type($text)
                    )
                ),
            );
    }
    
    //*
    //* Generate list hmtl
    //*

    function Text_Display_Children_Mode_List_Html($text,$children)
    {
        $html=array();
        foreach ($children as $child)
        {
            array_push
            (
                $html,
                $this->Text_Display_Child($text,$child,$children)
            );
        }

        return $html;
    }
    
    //*
    //* Read children
    //*

    function Text_Display_Children_Read($text,$mode)
    {
        $children=
            $this->Text_Children($text,array("Mode" => $mode));

        $rchildren=array();
        foreach ($children as $child)
        {
            if ($this->CheckShowAccess($child))
            {
                array_push($rchildren,$child);
            }
        }
        
        return $rchildren;
    }

    //*
    //*
    //*

    function Text_Display_Children_Destination_IDs($text,$children)
    {
        $dest_ids=array();
        foreach ($children as $child)
        {
            array_push
            (
                $dest_ids,
                $this->Text_Display_Child_Item_Destination_ID($text,$child)
            );
        }
        
        return $dest_ids;  
    }

}

?>