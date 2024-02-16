<?php

trait Texts_Parent
{
    //*
    //*
    //*

    function Text_Parent_Has($text=array())
    {
        if (empty($text)) { return True; }

        $res=False;
        if (!empty($text[ "Parent" ]))
        {
            $res=True;
        }
        
        return $res;
    }
    //*
    //* 
    //*

    function Text_Parent_Select($data,$text,$edit=0,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $texts=$this->Texts_Parents($text);
        if (count($texts)>0)
        {
            $parent=$texts[ count($texts)-1 ];
            $children=
                $this->Text_Children($parent);

            $texts=array_merge($texts,$children);
        }

        //var_dump(count($texts));
        return
            $this->Texts_Select($rdata,$text,$texts);
    }
    
    //*
    //*
    //*
    
    function Texts_Parents(&$text)
    {
        $rtext=$text;
        
        $parent_ids=array();
        while (!empty($rtext[ "Parent" ]))
        {
            array_push
            (
                $parent_ids,
                $rtext[ "Parent" ]
            );
            
            $rtext=
                $this->Sql_Select_Hash
                (
                    array("ID" => $rtext[ "Parent" ]),
                    array("ID","Parent")
                );
        }

        $text[ "Parents" ]=array();
        if (count($parent_ids)>0)
        {
            $text[ "Parents" ]=
                $this->Sql_Select_Hashes
                (
                    array("ID" => $parent_ids),
                    array("ID","Parent","Name","Title","File")
                );
        }
        
        $text[ "Level" ]=count($parent_ids);

        return $text[ "Parents" ];
    }

    
    //*
    //* Scans up through ancestors (parents) searching for a defined file.
    //*

    function Text_Parents_First_File($text)
    {
        $file=$this->Texts_Exec_File_Name($text);
        if (!file_exists($file))
        {
            $parents=$this->Texts_Parents($text);
            $parents=array_reverse($parents);
            
            for ($n=0;$n<count($parents);$n++)
            {
                $file=$this->Texts_Exec_File_Name($parents[$n]);
                if (file_exists($file))
                {
                    break;
                }
            }
        }
        
        return $file;
    }
 }

?>