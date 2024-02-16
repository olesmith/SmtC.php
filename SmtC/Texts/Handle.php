<?php

trait Texts_Handle
{
    
    //*
    //* 
    //*

    function Texts_Handle_Child_Create_Parent_Where($item)
    {
        return
            array
            (
                "Parent" => $item[ "ID" ],
            );
    }
    //*
    //* 
    //*

    function Texts_Handle_Child_Create_Parent_N($item)
    {
        return
            $this->Sql_Select_NHashes
            (
                $this->Texts_Handle_Child_Create_Parent_Where($item)
            );
    }

    //*
    //* 
    //*

    function MyMod_Handle_Select($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }


        $parents=$this->Texts_Parents($text);
        $parent_id=$this->CGI_GETint("Parent");
        $parent_found=False;
        
        $texts=array();
        foreach ($parents as $parent)
        {
            array_push($texts,$parent);

            if ($parent[ "ID" ]==$parent_id)
            {
                $texts=
                    array_merge
                    (
                        $texts,
                        $this->Text_Children($parent)
                    );
                $parent_found=True;
            }
        }

        if (!$parent_found)
        {
            $parent=
                $this->Sql_Select_Hash
                (
                    array("ID" => $parent_id)
                );

            array_push($texts,$parent);
            
            $texts=
                array_merge
                (
                    $texts,
                    $this->Text_Children($parent)
                );

        }
        
        $this->Htmls_Echo
        (
            $this->Texts_Select("Parent",$text,$texts,$parent_id)
        );
    }

}

?>