<?php

trait MyMod_Handle_Email_Cells_Body
{
    //*
    //* Creates body (textarea) cell as table.
    //*

    function MyMod_Handle_Email_Cell_Body($edit,$item)
    {
        $body=$this->MyMod_Handle_Email_CGI_Value("Body");
        if (empty($body))
        {
            $body=
                $this->MyMod_Handle_Email_Cell_Body_Default($edit,$item);
        }

        $cell="&nbsp;";
        if ($edit==1)
        {
            $cell=
                $this->MakeTextArea("Body",5,78,$body);
        }
        else
        {
            $cell=$body;
        }

        return $this->Span($cell,array("WIDTH" => '75%'));
    }
    
    //*
    //* Provide $item Subject Default. May be overwritten.
    //*

    function MyMod_Handle_Email_Cell_Body_Default($edit,$item)
    {
        return "";
    }
}

?>