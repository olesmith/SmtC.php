<?php

include_once("Application/Language_Messages.php");

class Languages extends Language_Messages
{
    var $Message_Tables=array("SAdE_Messages","Sivent2_Messages");
    
    //*
    //* Profile
    //*

    function Messages_Edit_Profile()
    {
        return "Admin";
    }
    
}
?>