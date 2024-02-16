<?php

trait Texts_Children
{
    //*
    //*
    //*

    function Text_Children_Handle($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }
    
        $this->Htmls_Echo
        (
            array
            (
                $this->MyMod_Items_Dynamic
                (
                    0,
                    $this->Text_Children($text)
                )
            )
        );
    }

    //*
    //*
    //*

    function Text_Children_Has($text=array())
    {
        if (empty($text)) { return True; }

        $n=
            $this->Sql_Select_NHashes
            (
                array("Parent" => $text[ "ID" ])
            );
        
        return ($n>0);
    }


    
    //*
    //* 
    //*

    function  Text_NChildren($item)
    {
        return
            $this->Sql_Select_NHashes
            (
                array
                (
                    "Parent" => $item[ "ID" ],
                )
            );
    }
    
    //*
    //*
    //*

    function Text_Children($text,$where=array())
    {
        $children=
            $this->Sql_Select_Hashes
            (
                array_merge
                (
                    $where,
                    array
                    (
                        "Parent" => $text[ "ID" ],
                    )
                ),
                array(),
                "Sort,Name"
            );
        
        return $this->Text_Children_Sort($children);
    }

    //*
    //*
    //*

    function Text_Children_Sort($children)
    {
        $schildren=array();
        foreach ($children as $child)
        {
            $sort=$child[ "Sort" ];
            if (preg_match('/^\d+$/',$sort))
            {
                $sort=sprintf("%06d",$sort);
            }

            $sort.="_".$child[ "Name" ];
            $sort.="_".sprintf("%06d",$child[ "ID" ]);

            $schildren[ $sort ]=$child;
        }
        
        $sorts=array_keys($schildren);
        sort($sorts);

        $children=array();
        $n=0;
        foreach ($sorts as $sort)
        {
            //Start with n=1
            $n++;
            
            if ($schildren[ $sort ][ "Sort" ]!=$n)
            {
                $schildren[ $sort ][ "Sort" ]=$n;
                $this->Sql_Update_Item_Value_Set
                (
                    $schildren[ $sort ],
                    "Sort",$n
                );
            }
            
            array_push($children,$schildren[ $sort ]);
        }

        return $children;
    }
    
    //*
    //*
    //*

    function Text_Children_Apply_To_CheckBox($edit,$data,$text,$field,$plural)
    {
        if ($edit!=1) { return $field; }
        
        if (empty($text[ "ID" ]))  { return $field; }
        
        $n_children=
            $this->Sql_Select_NHashes
            (
                array
                (
                    "Parent" => $text[ "ID" ],
                )
            );

        if ($n_children==0)  { return $field; }
        
        return
            array
            (
                $field,
                $this->Htmls_CheckBox
                (
                    $this->Text_Children_CheckBox_CGI_Key($text,$data),
                    1,
                    $checked=False,$disabled=FALSE,
                    $options=array
                    (
                        "TITLE" => "Apply to Children",
                    )
                )
            );
    }
    
    //*
    //*
    //*

    function Text_Children_CheckBox_CGI_Key($text,$data)
    {
        return
            "Children_".$text[ "ID" ]."_".$data;
    }
    
    //*
    //*
    //*

    function Text_Children_CheckBox_CGI_Value($text,$data)
    {
        return
            $this->CGI_POSTint
            (
                $this->Text_Children_CheckBox_CGI_Key($text,$data)
            );
    }
    
    //*
    //*
    //*

    function Text_Children_Apply_To($text,$data,$newvalue,$prepostkey)
    {
        $text[ $data ]=$newvalue;
        
        $check=
            $this->Text_Children_CheckBox_CGI_Value($text,$data);
        
        if ($check==1)
        {
            $ids=$this->Text_Descendentes($text);

            if (!empty($ids))
            {
                $this->Sql_Update_Where
                (
                    array
                    (
                        $data => $text[ $data ]
                    ),
                    array
                    (
                        "ID" => $ids,
                    ),
                    array($data)
                );
            }
        }

        return $text;
    }
}

?>