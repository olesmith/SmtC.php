<?php

include_once("Email/Read.php");
include_once("Email/CGI.php");
include_once("Email/Cells.php");
include_once("Email/Table.php");
include_once("Email/Html.php");
include_once("Email/Attachments.php");
include_once("Email/Send.php");
include_once("Email/Printables.php");
include_once("Email/Form.php");

trait MyMod_Handle_Email
{
    use
        MyMod_Handle_Email_Read,
        MyMod_Handle_Email_CGI,
        MyMod_Handle_Email_Cells,
        MyMod_Handle_Email_Table,
        MyMod_Handle_Email_Html,
        MyMod_Handle_Email_Attachments,
        MyMod_Handle_Email_Send,
        MyMod_Handle_Email_Printables,
        MyMod_Handle_Email_Form;
    
    var $MailFilters=array();

    
    //*
    //* Sql where.
    //*

    function MyMod_Handle_Email_To_Input_Field()
    {
        $res=
            $this->Actions
            (
                $this->CGI_GET("Action"),
                "To_Input_Field"
            );
        
        if ($res)
        {
            return True;
        }
        
        return False;
    }
    
    //*
    //* Sql where.
    //*

    function MyMod_Handle_Email_Friend_Keys()
    {
        $keys=
            $this->Actions
            (
                $this->CGI_GET("Action"),
                "Friend_Keys"
            );
        
        if (!empty($keys))
        {
            return $keys;
        }
        
        return array();
    }
    
    //*
    //* Sql where.
    //*

    function MyMod_Handle_Email_Where($item)
    {
        $where=array();
        if (!preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $where[ "ID" ]=-1;
        }
        
        return $where;
    }

    //*
    //* Fixed values for new Temp items.
    //*

    function MyMod_Handle_Email_Fixed($item)
    {
        return $this->MyMod_Handle_Email_Where($item);
    }

    //Email_Form_Title
    //Email_Form_BCC_Title
    
    //*
    //* Handles form for emailing items.
    //*

    function MyMod_Handle_Email()
    {
        $item=$this->ItemHash;
        
        echo
            $this->Htmls_Text
            (
                $this->MyMod_Handle_Email_Form
                (
                    1,
                    $search_table=True,$printables_obj=True,
                    $item             
                )
            );
    }


  
}

?>