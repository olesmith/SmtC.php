<?php

trait MyMod_Handle_Email_Cells_CC
{
    //*
    //* CC cell.
    //*

    function MyMod_Handle_Email_Cell_CC($edit,$item)
    {
        $mailinfo=$this->ApplicationObj()->MyApp_Mail_Info_Get();
        $emails=
            array
            (
                array
                (
                    "ID" => 0,
                    "Email" => $this->ApplicationObj()->MyApp_Mail_Info_Get( "BCCEmail" ),
                    "Name" => "Sistema",
                ),
                $this->LoginData
            );

        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Handle_Emails_Table
                (
                    $edit,
                    array
                    (
                        array
                        (
                            "ID" => 0,
                            "Email" => $this->ApplicationObj()->MyApp_Mail_Info_Get
                            (
                                "BCCEmail"
                            ),
                            "Name" => "Sistema",
                        ),
                        $this->LoginData
                    ),
                    2,
                    TRUE,TRUE
                ),
                array
                (
                    "ALIGN" => 'left',
                ),
                array(),array(),TRUE,TRUE
            );
    }
}

?>