<?php

trait Texts_Access
{
    //*
    //* Checks if $item may be downloaded. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckDownloadAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        return TRUE;
    }
    
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
                
        $res=False;
        if ($this->Profile_Admin_Is())
        {
            $res=True;
        }
        elseif
            (
                !empty($item[ "Friend" ])
                &&
                $item[ "Friend" ]==$this->LoginData("ID")
            )
        {
            $res=TRUE;
        }
        elseif
            (
                $this->Profile_Coordinator_Is()
            )
        {
            $res=True;
        }
        elseif
            (
                $this->Profile_Public_Is()
                &&
                intval($item[ "Public" ])==2
            )
        {
            $res=True;
        }

        return $res;
    }

    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=$this->CheckShowAccess($item);


        if ($this->Profile_Admin_Is())
        {
            $res=True;
        }

        //Allow user to edit his $text's
        if
            (
                !empty($item[ "Friend" ])
                &&
                $item[ "Friend" ]==$this->LoginData("ID")
            )
        {
            $res=TRUE;
        }
        
        return $res;
    }
    
    //*
    //* Checks if $item may be deleted.
    //* Allowed if may edit, AND no child entries:
    //* Inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        $res=$this->CheckEditAccess($item);

        if
            (
                $res
                &&
                $this->Sql_Select_NHashes
                (
                    array
                    (
                        "Parent" => $item[ "ID" ],
                    )
                )>0
            )
        {
            $res=False;
        }
        
        return $res;
    }
    
    //*
    //* Checks if we may list registrations
    //*

    function CheckShowListAccess($item=array())
    {
        $res=$this->CheckShowAccess();

        return $res;
    }
    
    //*
    //* Checks if we may list registrations
    //*

    function CheckEditListAccess($item=array())
    {
        //shouldn't receive $item!
        
        $res=$this->CheckEditAccess();
       
        return $res;
    }

    //*
    //* 
    //*
    
    function Text_Perms_Exercise_Answer($data,$item=array())
    {
        if (empty($item)) { return 1; }

        $res=0;
        if ($this->Text_Is_Question_Or_Exercise($item))
        {
            $res=2;
        }

        elseif (!empty($item[ $data ]))
        {
            $res=2;
        }

        return $res;
    }

}

?>