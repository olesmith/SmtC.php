<?php

trait Texts_Latex_Question
{
    //*
    //* 
    //*

    function Text_Latex_Question_Body($question)
    {
        $body=$question[ "Body" ];
            
        if (!empty($question[ "Answer" ]))
        {
            $body.=
                "\n\\underline{\\textbf{Answer:}} ".
                $question[ "Answer" ];
        }
        
        return $body;
    }
    
    //*
    //* 
    //*

    function Text_Latex_Question_Solution($question)
    {
        $solution=array($question[ "Solution" ]);
        if (empty($question[ "Solution" ]))
        {
            $solution=array("-");
        }

        foreach
            (
                $this->Text_Children
                (
                    $question,
                    array
                    (
                        "Type" => $this->Text_Type_No("Input"),
                    )
                )
                as $child
            )
        {
            array_push
            (
                $solution,
                $child[ "Solution" ]
            );
        }

        

        return $solution;
    }
}

?>