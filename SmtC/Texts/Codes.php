<?php

trait Texts_Codes
{
    //*
    //*
    //*

    function Text_Codes_Handle()
    {
        $text=$this->ItemHash;
        
        $texts=
            $this->Text_Descendents_Read
            (
                $text,
                array
                (
                    //"File" => $this->__Types__[ "Code" ],
                ),
                array(),
                "Text_Exec_Is"
                
            );

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    2,
                    array
                    (
                        $this->MyActions_Entry_Title().":",
                        count($texts),
                        $this->MyMod_ItemsName(),
                    )
                ),
                $this->MyMod_Items_Dynamic
                (
                    0,
                    $texts,
                    "Codes"
                ),
            )
        );
    }
}

?>