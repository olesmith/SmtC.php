<?php


trait Htmls_Menues_Horisontal_Dynamic_Cell
{
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*

    function Htmls_Menu_Horisontal_Dynamic_Cell($menu,$key,$def,$is_hide_cell,$hide)
    {
        $rdef=$def;

        $rdef[ "Hide_Cell" ]=$is_hide_cell;
        if ($is_hide_cell)
        {
            $rdef[ "Color" ]=$def[ "Hide_Color" ];
            $rdef[ "Cell_ID" ].="_Hide";
        }
        else
        {
            $rdef[ "Color" ]=$def[ "Color" ];
            $rdef[ "Cell_ID" ].="_Show";
        }

        if (empty($rdef[ "Onclick" ]))
        {
            $rdef[ "Onclick" ]=
                $this->Htmls_Menu_Horisontal_Dynamic_JS
                (
                    $menu,$key,$def,$is_hide_cell,$hide
                );
        }
        //else { var_dump($rdef[ "Onclick" ]); }
        //var_dump($rdef[ "Class" ]);
        
        return
            $this->Htmls_Dynamic_Cell
            (
                $this->Htmls_Menu_Horisontal_Dynamic_Cell_Def
                (
                    $menu,$key,
                    $rdef,
                    $is_hide_cell,$hide
                )
            );
    }
    
    //*
    //* 
    //*

    function Htmls_Menu_Horisontal_Dynamic_Cell_Def($menu,$key,$def,$is_hide_cell,$hide)
    {
        $def[ "Hide_Cell" ]=$is_hide_cell;

        return
            array_merge
            (
                $def,
                array
                (
                    "TYPE" => 'button',
                    "Hide" => $hide,
                )
            );
    }
        
}
?>