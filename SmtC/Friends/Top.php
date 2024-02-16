<?php

trait Friends_Top
{
    
    //*
    //* 
    //*

    function Friend_Tops_Handle($friend=array())
    {
        if (empty($friend)) { $friend=$this->ItemHash; }        

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    3,
                    array
                    (
                        $friend[ "Name" ].":",
                        "Top",
                        $this->TextsObj()->MyMod_ItemsName(),
                    )
                ),
                $this->TextsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Friend_Tops_Texts_Read($friend),
                    ""
                )
            )
        );
    }
    //*
    //* 
    //*

    function Friend_Tops_Texts_Read($friend)
    {
        return
            $this->TextsObj()->Sql_Select_Hashes
            (
                $this->Friend_Tops_Texts_Where($friend),
                array(),
                "Name"
            );
    }
    
    //*
    //* 
    //*

    function Friend_Tops_Texts_Where($friend)
    {
        $where=
            array
            (
                "Friend" => $friend[ "ID" ],
                "Root" => 2,
            );

        if
            (
                $this->Profile_Public_Is()
            )
        {
            $where[ "Public" ]=2;
        }

        return $where;
    }
}

?>