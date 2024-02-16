<?php

trait Htmls_List
{
    //*
    //* Generate a HTML list (UL) with elements in $list
    //* 
    //*

    function Htmls_List_OL($list,$options=array(),$lioptions=array())
    {
        return
            $this->Htmls_List
            (
                $list,$options,$lioptions,
                "OL"
            );
    }
    
    //*
    //* Generate a HTML list (UL) with elements in $list
    //* 
    //*

    function Htmls_List($list,$options=array(),$lioptions=array(),$ul="UL")
    {
        if ($this->LatexMode())
        {
            if ($ul=="UL") { $ul="itemize"; }
            else           { $ul="enumerate"; }

            return $this->LatexList($list,$ul);
        }
        else
        {
            return
                array
                (
                    $this->Htmls_Tag
                    (
                        $ul,
                        $this->Htmls_Tag_List
                        (
                            "LI",
                            $list,
                            array_merge
                            (
                                /* array */
                                /* ( */
                                /*    #"CLASS" => 'menu-label', */
                                /* ), */
                                $lioptions
                            )
                        ),
                        array_merge
                        (
                            /* array */
                            /* ( */
                            /*     #"CLASS" => 'content menu-list', */
                            /* ), */
                            $options
                        )
                    )
                );
        }
    }

}


?>