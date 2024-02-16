<?php

trait Texts_Exec_Path
{
    #var $_RBash__Root_Bin__="/usr/bin/rbash";
    var $__RBash_Root_Base__="/usr/local/rbash";

   
    //*
    //* Suitable path in chroot
    //*

    function Texts_Exec_Path_Absolute_Create($text)
    {
        return
            $this->Dir_Create_AllPaths
            (
                $this->Texts_Exec_Path_Absolute($text),
                True
            );     
    }
    
    //*
    //* Suitable path in chroot
    //*

    function Texts_Exec_Path_Absolute($text)
    {
        $paths=
            array
            (
                $text[ "Friend" ],
            );
        
        if ($this->Text_Is_Python($text))
        {
            array_push($paths,"Python");
        }

        $pdata="Path";
        if (!empty($text[ $pdata ]))
        {
            array_push($paths,$text[ $pdata ]);
        }

        $rpaths=
            array_merge
            (
                array($this->__RBash_Root_Base__),
                $paths
            );

        $rpath=join("/",$rpaths);

        return join("/",$rpaths);
    }
}

?>