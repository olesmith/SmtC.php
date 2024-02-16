<?php

trait MyMod_Handle_Email_Html
{
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Html_Table($edit,$item)
    {
         return
            $this->Htmls_Table
            (
                "",
                array_merge
                (
                    $this->MyMod_Handle_Email_Html_Mail_Parts_Table
                    (
                        $edit,$item
                    )
                    //,
                    /* $this->MyMod_Handle_Email_Printables */
                    /* ( */
                    /*     $edit,$printables */
                    /* )//, */
                    /*     $this->MyMod_Handle_Email_Attachments_Rows($edit,$attachments) */
                ),
                array
                (
                    "ALIGN" => 'center',
                ),
                array(),array(),FALSE,FALSE
            );
    }
    
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Html_Mail_Parts_Table($edit,$item)
    {
        return
            array
            (
               array
               (
                  $this->B("De:",array("TITLE" => "Responder para/Reply-to")),
                  $this->LoginData[ "Email" ]
               ),
               array
               (
                  $this->B("Para:",array("TITLE" => "BCC/CCO")),
                  $this->MyMod_Handle_Email_Cell_To($edit,$item)
               ),
               array
               (
                  $this->B("CC:"),
                  $this->MyMod_Handle_Email_Cell_CC($edit,$item)
               ),
               array
               (
                  $this->B("Assunto:"),
                  $this->MyMod_Handle_Email_Cell_Subject($edit,$item)
               ),
               array
               (
                  $this->B("Mensagem:"),
                  $this->MyMod_Handle_Email_Cell_Body($edit,$item),
               ),
            );
    }

 }

?>