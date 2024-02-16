<?php

trait MyMod_Handle_Email_Read
{
    var $MyMod_Handle_Emails_Warning=array();
    
    //*
    //* Reads emails.
    //*

    function MyMod_Handle_Emails_Read($item)
    {
        $this->NoPaging=TRUE;
        $this->MyMod_Handle_Emails_Warning=array();

        //Array keeping track of included ids. Avoids multiple entries.
        $ids=array();
        $emails=array();        

        foreach ($this->MyMod_Handle_Email_Friend_Keys() as $friendkey)
        {
            $emails[ $friendkey ]=array();
        }

        
        foreach
            (
                $this->MyMod_Handle_Emails_Read_Items($item)
                as $friend
            )
        {
            foreach ($this->MyMod_Handle_Email_Friend_Keys() as $friendkey)
            {
                //Avoid repeated entries.
                if (!empty($ids[ $friend[ $friendkey ] ]))
                {
                    continue;
                }

                
                $rfriend=
                    $this->UsersObj()->Sql_Select_Hash
                    (
                        array("ID" => $friend[ $friendkey ]),
                        array("ID","Email","Name")
                    );

                if (!empty($rfriend[ "Email" ]) && preg_match('/^\S+\@\S+$/',$rfriend[ "Email" ]))
                {
                   if (empty($emails[ $friendkey ][ $rfriend[ "Email" ] ]))
                   {
                       $emails[ $friendkey ][ $rfriend[ "Email" ] ]=$rfriend;
                   }
                   else
                   {
                       array_push
                       (
                           $this->MyMod_Handle_Emails_Warning,
                           array
                           (
                               "Double Email: ".$rfriend[ "Email" ],
                               $this->UsersObj()-> MyActions_Entry("Edit",$rfriend,$noicons=True)
                           )
                       );
                   }
                }
                else
                {
                    array_push
                    (
                        $this->MyMod_Handle_Emails_Warning,
                        array
                        (
                            "Empty email ".$rfriend[ "Name" ].": ".$rfriend[ "Email" ],
                            $this->UsersObj()-> MyActions_Entry("Edit",$rfriend,$noicons=True)
                        )
                    );
                }
                

                //Register entry
                $ids[ $friend[ $friendkey ] ]=1;
            }
 
            //$emails[ $friendkey ]=$this->Sort_List_ByKey($emails[ $friendkey ],"Email");
        }

        return $emails;
    }

    
    //*
    //* Reads items to send email to... plural version. $item signular version.
    //*

    function MyMod_Handle_Emails_Read_Items($item=array())
    {
        $this->MyMod_Items_Read
        (
            $this->MyMod_Handle_Email_Where($item),
            array_merge
            (
                array("ID","Name"),
                $this->MyMod_Handle_Email_Friend_Keys() 
            ),
            $nosearches=FALSE,
            $nopaging=True,
            $includeall=0,$nopostprocess=True
        );

        if (!empty($item))
        {
            array_push($this->ItemHashes,$item);
        }

        return $this->ItemHashes;
    }
}

?>