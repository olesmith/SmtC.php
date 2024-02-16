<?php

trait Texts_Latex_List
{
    //*
    //* 
    //*

    function Text_Latex_List($text)
    {
        $latex=
            array
            (
                $text[ "Body" ],
                "","",
                "\\underline{\\textbf{Exercises:}}\n\n"
            );

        foreach
            (
                $this->Text_Children
                (
                    $text,
                    array
                    (
                        "Type" => $this->Text_Type_No("Exercise"),
                    )
                )
                as $exercise
            )
        {
            array_push
            (
                $latex,
                $this->Text_Latex_Exercise($exercise)
            );
        }

        return $latex;
    }
}

?>