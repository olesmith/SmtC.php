<?php

include_once("Latex/List.php");
include_once("Latex/Exercise.php");
include_once("Latex/Question.php");

trait Texts_Latex
{
    use
        Texts_Latex_List,
        Texts_Latex_Exercise,
        Texts_Latex_Question;
    //*
    //* 
    //*

    function Text_Latex_Handle($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        
        $latex=
            array
            (
                $item[ "Body" ]
            );

        $this->Htmls_Echo
        (
            $this->Htmls_DIV
            (
                $this->Htmls_Latex
                (
                    $this->Text_Latex_Generate($item)
                )
            )
        );
               
    }

    //*
    //* 
    //*

    function Text_Latex_Generate($item)
    {
        if ($this->Text_Is_List($item))
        {
            return $this->Text_Latex_List($item);
        }
        elseif ($this->Text_Is_Question_Or_Exercise($item))
        {
            return $this->Text_Latex_Exercise($item);
        }
        
        $latex=
            array
            (
                $item[ "Body" ]
            );
        
        return $latex;      
    }

    //*
    //* 
    //*

    function Text_Latex_File_Name($text)
    {
        return
            preg_replace
            (
                '/\s+/',
                "-",
                $text[ "Name" ]
            ).
            "_".
            $this->MyTime_Current_Date_Sort().
            ".tex";
    }

    //*
    //* 
    //*

    function Htmls_Latex($latex)
    {
        $latex=$this->Htmls_Text($latex);
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    preg_replace
                    (
                        '/\s/',
                        "&nbsp;&nbsp;&nbsp;",
                        preg_replace
                        (
                            '/\n/',
                            "<BR>",
                            $latex
                        )
                    ),
                    array
                    (
                        "CLASS" => "Latex",
                    )
                )
            );
               
    }
}

?>