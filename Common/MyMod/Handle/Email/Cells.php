<?php

include_once("Cells/To.php");
include_once("Cells/CC.php");
include_once("Cells/Subject.php");
include_once("Cells/Body.php");

trait MyMod_Handle_Email_Cells
{
    use
        MyMod_Handle_Email_Cells_To,
        MyMod_Handle_Email_Cells_CC,
        MyMod_Handle_Email_Cells_Subject,
        MyMod_Handle_Email_Cells_Body;
    
    //*
    //* Creates table with checkbox and email.
    //*

    function MyMod_Handle_Email_Cell($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
       return
           array
           (
               $this->MyMod_Handle_Email_Cell_CheckBox
               (
                   $edit,$email,$selected,$disabled
               ),
               $this->Span
               (
                   strtolower($email[ "Email" ]).";",
                   array
                   (
                       "TITLE" => $email[ "Name" ]." (".$email[ "ID" ].")"
                   )
               ),
           );
    }
    
    //*
    //* Creates table email checkbox
    //*

    function MyMod_Handle_Email_Cell_CheckBox($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
        $check="";
        if ($edit==1)
        {
            $cgi="Inc_".$email[ "ID" ];
            if (!$selected)
            {
                $val=$this->GetPOSTint($cgi);
                if ($val==1) { $selected=TRUE; }
                else         { $selected=FALSE; }
            }

             $check=$this->MakeCheckBox($cgi,1,$selected,$disabled);
        }
        
        return $check;
    }
}

?>