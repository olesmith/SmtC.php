<?php

trait App_Profiles
{
    //*
    //* 
    //*

    function Profile_Coordinator_Is()
    {
        return $this->FriendsObj()->Profile_Coordinator_Is();
    }

    //*
    //* 
    //*

    function Profile_Friend_Is()
    {
        return $this->FriendsObj()->Profile_Friend_Is();
    }
}

?>