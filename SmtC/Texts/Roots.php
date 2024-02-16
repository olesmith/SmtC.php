<?php


trait Texts_Roots
{
    //*
    //* Text_Display_Handle handler.
    //*

    function Text_Roots_Handle()
    {
        return
            $this->Htmls_Echo
            (
                $this->Text_Roots_Generate()
            );
    }

   //*
    //* Text_Display_Handle handler.
    //*

    function Text_Roots_Generate()
    {
        return
            array
            (
                $this->Text_Roots_Html(),
            );
    }

    //*
    //*
    //*
    
    function Text_Roots_Html()
    {
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H(1,$this->MyActions_Entry_Name()),
                $this->MyMod_Items_Dynamic
                (
                    0,
                    $this->Text_Roots_Read()
                )
            )
        );
    }
    
    //*
    //*
    //*
    
    function Text_Roots_Friend_ID()
    {
        if ($this->Profile_Is_Friend())
        {
            return $this->Profile("Friend" );
        }
        else
        {
            return $this->CG_GETint("Friend");
        }
    }
    
    //*
    //*
    //*
    
    function Text_Roots_Read()
    {
        return
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Friend" => Text_Roots_Friend_ID(),
                    "Root" => 2,
                )
            );
    }
    

}

?>