<?php

trait Texts_Latex_Exercise
{
    //*
    //* 
    //*

    function Text_Latex_Exercise($text)
    {
        $latex=
            array
            (
                "\\textbf{".$text[ "Title" ]."}.\n\n",
                "\\begin{addmargin}[2em]{2em}",
                $this->Text_Latex_Exercise_Body($text)
            );

        
        //Add solution, if defined

        $solution=False;
        if (!empty($text[ "Solution" ]))
        {
            $solution=True;
        }
        
        $enums=array();
        foreach ($this->Text_Children($text) as $question)
        {
            if (!empty($question[ "Solution" ]))
            {
                $solution=True;
            }

            array_push
            (
                $enums,
                $this->Htmls_Text
                (
                    $this->Text_Latex_Question_Solution($question)
                )
            );
        }
 
        if ($solution)
        {
            array_push
            (
                $latex,
                "\n\n\\underline{\\textbf{Solution}}:\n\n",
                $text[ "Solution" ]
            );
            

            if (count($enums)>0)
            {
                array_push
                (
                    $latex,
                    $this->LatexList($enums,"enumerate","(a)")
                );
            }
        }

        array_push
        (
            $latex,
            "\\end{addmargin}"
        );
        
        return $latex;                
    }
    
    //*
    //* 
    //*

    function Text_Latex_Exercise_Body($text)
    {
        $latex=
            array
            (
                $text[ "Body" ]
            );

        $enums=array();
        foreach
            (
                $this->Text_Children
                (
                    $text,
                    array
                    (
                        "Type" => $this->Text_Type_No("Question"),
                    )
                )
                as $question
            )
        {
            $body=$question[ "Body" ];
            
            if (!empty($question[ "Answer" ]))
            {
                $body.=
                    "\n\\underline{\\textbf{Answer:}} ".
                    $question[ "Answer" ];
            }
            
            array_push
            (
                $enums,
                $this->Htmls_Text
                (
                    $this->Text_Latex_Question_Body($question)
                )
            );
        }

        if (count($enums)>0)
        {
            array_push
            (
                $latex,
                $this->LatexList($enums,"enumerate","(a)")
            );
        }

        //Add answer, if defined
        if (!empty($text[ "Answer" ]))
        {
            array_push
            (
                $latex,
                "\n\n\\underline{\\textbf{Answer}}:",
                $text[ "Answer" ]
            );
        }

        return $latex;
    }
    
    //*
    //* 
    //*

    function Text_Latex_Exercise_Solution($text)
    {
    }
}

?>