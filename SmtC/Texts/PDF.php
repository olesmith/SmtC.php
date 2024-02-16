<?php

trait Texts_PDF
{
    //*
    //* 
    //*

    function Text_PDF_Handle($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }

        $this->Text_PDF_Generate($text);
               
    }

    //*
    //* 
    //*

    function Text_PDF_Generate($text)
    {
        $this->Latex_PDF
        (
            $this->Text_Latex_File_Name($text),
            
            $this->Latex_Head().
            $this->Htmls_Text
            (
                $this->Text_Latex_Generate($text)
            ).
            $this->Latex_Tail()
        );
        
    }
}

?>