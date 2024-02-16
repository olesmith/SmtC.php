<?php


trait Htmls_Menues_Horisontal_Dynamic_Cells
{
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*

    function Htmls_Menu_Horisontal_Dynamic_Cells($menu,$key,$def)
    {
        $hide=$def[ "Hide" ];
        return
            array
            (
                $this->Htmls_Menu_Horisontal_Dynamic_Cell($menu,$key,$def,True,$hide),
                $this->Htmls_Menu_Horisontal_Dynamic_Cell($menu,$key,$def,False,!$hide),                
            );
    }
    
    
    
    
    
}
?>