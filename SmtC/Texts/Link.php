<?php

trait Texts_Link
{
    //*
    //* 
    //*

    function Text_Link_Select($data,$text,$edit=0,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $ltext=
            $this->Sql_Select_Hash
            (
                array("ID" => $text[ "Destination" ])
            );

        if (empty($ltext)) { return "-"; }

        return
            $this->Texts_Select
            (
                $rdata,$text,
                $this->Texts_Link_Destinations($ltext)
            );
    }
    
    //*
    //*
    //*
    
    function Texts_Link_Destinations(&$ltext)
    {        
        $parents=$this->Texts_Parents($ltext);
        $children=$this->Text_Children($ltext);

        $destinations=array();
        if (count($parents)==0)
        {
            $destinations=
                array_merge
                (
                    $destinations,
                    $children
                );

            return $destinations;
        }
        else
        {
            foreach ($parents as $parent)
            {
                array_push($destinations,$parent);
                if ($parent[ "ID" ]==$ltext[ "Parent" ])
                {
                    array_push($destinations,$ltext);
                    $siblings=$this->Text_Children($ltext);
                    foreach ($siblings as $sibling)
                    {
                        array_push($destinations,$sibling);

                        if ($sibling[ "ID" ]==$ltext[ "ID" ])
                        {
                            $destinations=
                                array_merge
                                (
                                    $destinations,
                                    $children
                                );
                        }
                    }
                }
            }
        }

        return 
           array_merge
           (
               $destinations,
               $this->Sql_Select_Hashes
               (
                   array("Root" => 2),
                   array("ID","Parent","Name","Title","File","Level")
               )
           );
    }
}

?>