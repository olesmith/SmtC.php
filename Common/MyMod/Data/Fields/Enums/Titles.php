<?php

trait MyMod_Data_Fields_Enums_Titles
{
    //*
    //* Returns TITLEs to display in SELECT field.
    //*

    function MyMod_Data_Field_Enum_Titles($data,$values)
    {
        $valuetitles=array();
        if (!empty($this->ItemData[ $data ][ "Values" ]))
        {
            $valuetitles=$this->ItemData[ $data ][ "Values" ];
        }
        
        $titles=array();
        $checkbox=$this->MyMod_Data_Field_Enum_CheckBox_Is($data);
        
        if ($checkbox==FALSE)
        {
            //if (!empty($this->ItemData[ $data ][ "EmptyName" ]))
            //{
                $titles=array(0);
            //}
        }
        elseif ($checkbox==2)
        {
            $titles=array();
        }

        $n=1;
        foreach ($values as $val)
        {
            $title=$n;
            if (count($valuetitles)>=$n)
            {
                $title=$valuetitles[ $n-1 ]." (".$n.")";
            }
            
            array_push($titles,$title);
            $n++;
        }

        
        if ($this->MyMod_Data_Enum_Reverse_Select_Should($data))
        {
            $titles=array_reverse($titles);
        }

        return $titles;
    }    
}

?>