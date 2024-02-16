<?php


include_once("Friends/Access.php");
include_once("Friends/Profiles.php");
include_once("Friends/Top.php");

class Friends extends ModulesCommon
{
    use
        Friends_Access,
        Friends_Profiles,
        Friends_Top;
    
    var $StateKeys=array("Address_State","RG_UF");
    var $FriendDataMessages="Friends.php";

    var $Profile2Permissions=array
    (
        "Friend" => array
        (
        ),
        "Coordinator" => array
        (
        ),
        
        "Admin" => array
        (
        ),
    );

    //*
    //* Constructor.
    //*

    function __construct($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Public");
        $this->Sort=array("Name");
        $this->UploadFilesHidden=FALSE;        

        /* if (preg_match('/^(Friend)$/',$this->Profile())) */
        /* { */
        /*     $this->SqlWhere[ "ID" ]=$this->ApplicationObj->LoginData[ "ID" ]; */
        /* } */

        $this->ItemNamer="Name";
        $this->IDGETVar="Friend";
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return
            $this->ApplicationObj()->MyApp_Setup_Path().
            "/Friends/Profiles.php";
    }
    
    //*
    //* function SetProfilePermissions, Parameter list:
    //*
    //* Based on profile, updates $this->ItemData permissions
    //*

    function SetProfilePermissions()
    {
        if ($this->ApplicationObj->LoginType=="Person")
        {
            $profile=$this->ApplicationObj->Profile();

            $perms=array();
            foreach (array_keys($this->ApplicationObj->Profiles) as $rprofile)
            {
                if ($rprofile=="Public") { continue; }
                $perms[ $rprofile ]=0;
            }

            if (!empty($this->Profile2Permissions[ $profile ]))
            {
                foreach ($this->Profile2Permissions[ $profile ] as $rprofile => $value)
                {
                    $perms[ $rprofile ]=$value;
                }

                foreach ($perms as $rprofile => $value)
                {
                    $pkey="Profile_".$rprofile;
                    $this->ItemData[ $pkey ][ $profile ]=$value;
                }
            }
       }
    }


    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->Profile_Datas_Add();
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        #parent::PostInit();
     }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!=$this->ModuleName)
        {
            return $item;
        }

        $this->TextsObj();
        

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->Sql_Select_Hash_Datas_Read
        (
            $item,
            array("TextName")
        );
        
        $updatedatas=$this->PostProcessTextName($item);
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }

    //*
    //* function PostProcessTextName, Parameter list: &$item
    //*
    //* Postprocesses Name to TextName.
    //*

    function PostProcessTextName(&$item,$updatedatas=array())
    {
        if (!empty($item[ "Name" ]))
        {
            $name=$this->Html2Sort($item[ "Name" ]);
            $name=$this->Text2Sort($name); 

            if ($item[ "TextName" ]!=$name)
            {
                $item[ "TextName" ]=$name;
                array_push($updatedatas,"TextName");
            }
        }

        return $updatedatas;
    }
}

?>
