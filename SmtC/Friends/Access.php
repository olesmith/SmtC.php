<?php

trait Friends_Access
{
    //*
    //* function CheckDownloadAccess, Parameter list: $item=array()
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
    //* function CheckShowAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
                
        $res=False;
        if 
            (
                !empty($item[ "ID" ])
                &&
                $item[ "ID" ]==$this->LoginData("ID")
            )
        {
            $res=True;
        }
        elseif
            (
                $this->Profile_Coordinator_Is()
                ||
                $this->Profile_Admin_Is()
            )
        {
            $res=True;
        }
        elseif (intval($item[ "Public" ])==2)
        {
            $res=True;
        }
        
        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=$this->CheckShowAccess($item);

        $trust=$this->Profile_Trust();
        $friend_trust=$this->Friend_Profile_Trust($item);

        if ($this->Profile_Admin_Is())
        {
            $res=True;
        }
        elseif ($trust<=$friend_trust)
        {
            $res=False;
        }

        //Allow user to edit his data
        if
            (
                !empty($item[ "ID" ])
                &&
                $item[ "ID" ]==$this->LoginData("ID")
            )
        {
            $res=TRUE;
        }
        
        return $res;
    }
    
    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted.
    //* Allowed if may edit, AND no child entries:
    //* Inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        $res=$this->CheckEditAccess($item);

        /* if */
        /*     ( */
        /*         $res */
        /*         && */
        /*         $this->PermissionsObj()->Sql_Select_NHashes */
        /*         ( */
        /*             array */
        /*             ( */
        /*                 "User" => $item[ "ID" ], */
        /*             ) */
        /*         )>0 */
        /*     ) */
        /* { */
        /*     $res=False; */
        /* } */
        
        return $res;
    }
    
    //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if we may list registrations
    //*

    function CheckShowListAccess($item=array())
    {
        $res=$this->CheckShowAccess();

        return $res;
    }
    //*
    //* function CheckShowListAccess, Parameter list: $item=array()
    //*
    //* Checks if we may list registrations
    //*

    function CheckEditListAccess($item=array())
    {
        //shouldn't receive $item!
        
        $res=$this->CheckEditAccess();
       
        return $res;
    }
}

?>