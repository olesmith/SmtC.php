<?php

trait Texts_Descendents
{
    //*
    //* 
    //*

    function Text_Descendents_Read($id,$where,$datas,$select_func="")
    {
        $desc_ids=$this->Text_Descendent_IDs($id);

        if (count($desc_ids)==0) { return array(); }

        $where[ "ID" ]=$desc_ids;

        $texts=
            $this->Sql_Select_Hashes
            (
                $where,
                $datas
            );

        if (!empty($select_func))
        {
            $rtexts=array();
            foreach ($texts as $text)
            {
                if ($this->$select_func($text))
                {
                    array_push($rtexts,$text);
                }
            }

            return $rtexts;
        }

        return $texts;
    }
    
    //*
    //* 
    //*

    function Text_Descendent_IDs($id)
    {
        if (is_array($id)) { $id=$id[ "ID" ]; }
        
        $ids=
            $this->Sql_Select_Unique_Col_Values
            (
                "ID",
                array
                (
                    "Parent" => $id,
                )
            );

        $rids=$ids;
        foreach ($rids as $rid)
        {
            $ids=
                array_merge
                (
                    $ids,
                    $this->Text_Descendent_IDs($rid)
                );
        }

        return $ids;
    }
}

?>