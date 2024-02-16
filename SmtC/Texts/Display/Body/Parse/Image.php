<?php

trait Texts_Display_Body_Parse_Image
{
    //*
    //*
    //*
    //*

    function Text_Display_Body_Parse_Image($text,$args)
    {
        if
            (
                !preg_match('/^http/',$args[0])
                &&
                !preg_match('/^\//',$args[0])
            )
        {
            $args[0]="/".$args[0];
        }
        
        $keys=array("SRC","HEIGHT","WIDTH","TITLE","ALT","CLASS");
        $image=
            array
            (
                "CLASS" => 'image',
                "TITLE" => $args[0],              
            );

        for ($n=0;$n<count($args);$n++)
        {
            if (!empty($args[$n]))
            {
                $image[ $keys[$n] ]=$args[$n];
            }
        }

        if (!empty($image[ "TITLE" ]))
        {
            $image[ "ALT" ]=$image[ "TITLE" ];
        }
        
        return
            "".
            $this->Html_Tag_Start("IMG",$image).
            "";
    }
}

?>