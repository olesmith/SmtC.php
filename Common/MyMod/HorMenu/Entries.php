<?php

trait MyMod_HorMenu_Entries
{
    var $MyMod_HorMenu_Entries_Included=array();
    
    //*
    //* Generates menu entries for all menu.
    //*

    function MyMod_HorMenues_Entries($singular,$id,$item,$destination="",$class="")
    {        
        $entries=array();
        foreach ($this->MyMod_HorMenu_Get($singular) as $cssclass => $menu)
        {
            if
                (
                    !empty($class)
                    &&
                    $class!=$cssclass
                )
            {
                continue;
            }
            
            if (count($menu)>0)
            {
                $entries=
                    array_merge
                    (
                        $entries,
                        $this->MyMod_HorMenu_Entries
                        (
                            $singular,
                            $menu,$cssclass,$id,$item,$destination
                        )
                    );
            }
        }

        return $entries;
    }

    
    //*
    //* Generates menu entries for individual menu.
    //*

    function MyMod_HorMenu_Entries($singular,$pactions,$cssclass,$id,$item,$destination="")
    {
        $current_action=$this->MyActions_Detect();

        $last_action="";

        $entries=array();
        foreach
            (
                $this->MyMod_HorMenu_Actions_Get
                (
                    $singular,
                    $pactions,$id,$item
                )
                as $action
            )
        {
            $raction=
                $this->MyMod_HorMenu_Action_Get
                (
                    $singular,
                    $action,$id,$item
                );
            
            if (!empty($this->MyMod_HorMenu_Entries_Included[ $raction ]))
            {
                continue;
            }
            
            $entries[ $action ]=
                $this->MyMod_HorMenu_Entry
                (
                    $singular,
                    $action,
                    $cssclass,
                    $id,
                    $item,
                    $destination
                );

            $this->MyMod_HorMenu_Entries_Included[ $action ]=True;

            $last_action=$action;
        }

        if (!empty($last_action))
        {
            $entries[ $last_action ][ "Last" ]=True;
        }

        return $entries;
    }
}

?>