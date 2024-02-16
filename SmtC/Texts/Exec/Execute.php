<?php

trait Texts_Exec_Execute
{
    //*
    //* Execute rbash-ed command.
    //*

    function Texts_Exec_Execute(&$text)
    {
        $res="-";
        if ($this->Texts_Exec_File_Prepare($text))
        {
            if ($this->Texts_Exec_Execute_Should($text))
            {
                $ctime=time();
                $res=
                    $this->System_Run
                    (
                        $this->Texts_Exec_Execute_Command
                        (
                            $text
                        )
                    );
                
                $fdatas=array("File_Run_Res","File_Run_Time","File_Run_Last");
                
                $text[ $fdatas[0] ]=$res;
                $text[ $fdatas[1] ]=time()-$ctime;
                $text[ $fdatas[2] ]=$ctime;

                $this->Sql_Update_Item_Values_Set($fdatas,$text);

                $res="Generated Now";
            }
            else
            {
                $res="Generated Earlier";
            }
        }
        
        return $res;
    }

    
    //*
    //* Tests if we should execute command:
    //*
    //* Return code ("File_Run_Res") non zero
    //* or
    //* uploaded file has changed.
    //*

    function Texts_Exec_Execute_Should($text)
    {
        
        if (intval($text[ "File_Run_Res" ])!=0)
        {
            return True;
        }
        
        $src_time=
            $this->MyFiles_MTime
            (
                $this->MyMod_Data_Fields_File_FileName("File",$text)
            );
        
        $exec_time=
            $this->MyFiles_MTime
            (
                $this->Texts_Exec_File_Name($text)
            );
        
        $dest_time=
            $this->MyFiles_MTime
            (
                $this->Texts_Exec_Output_File_Name($text)
            );

        $res=False;
        if
            (
                $dest_time<$src_time
                ||
                $dest_time<$exec_time
            )
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* Chroot command (as list) 
    //*

    function Texts_Exec_Execute_Command($text)
    {
        return
            array
            (
                "cd ",
                $this->Texts_Exec_Path_Absolute($text)." && ",
                //Put RBash/CHROOT stuff here
                //"echo",
                //$this->__Ch_Root_Bin__,
                //$this->__RBash_Root_Base__,
                $this->__Code_2_Bin__[ $text[ "Code_Type" ] ],
                $this->Texts_Exec_File_Name($text),
                ">",
                $this->Texts_Exec_Output_File_Name($text),
                "2>&1"
            );
    }
}

?>