<?php

trait MyMod_Handle_Email_Cells_Subject
{
    //*
    //* Creates subject cell as table.
    //*

    function MyMod_Handle_Email_Cell_Subject($edit,$item)
    {
        $subject=$this->MyMod_Handle_Email_CGI_Value("Subject");
        if (empty($subject))
        {
            $subject=
                $this->MyMod_Handle_Email_Cell_Subject_Default($edit,$item);
        }

        $cell="";
        if ($edit==1)
        {
            $cell=$this->MakeInput("Subject",$subject,80);
        }
        else
        {
            $cell=$subject;
        }

        return  $this->Span($cell,array("WIDTH" => '75%'));
    }
    
    //*
    //* Provide $item Subject Default. May be overwritten.
    //*

    function MyMod_Handle_Email_Cell_Subject_Default($edit,$item)
    {
        return "";
    }
}

?>