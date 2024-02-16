<?php

trait Texts_Display_Body_Parse_Link
{
    //*
    //*
    //*
    //*

    function Text_Display_Body_Parse_Link($text,$args)
    {
        if
            (
                !preg_match('/^https?:/',$args[1])
                &&
                !preg_match('/^\//',$args[1])
            )
        {
            $args[1]="/".$args[1];
        }
        
        $keys=array("HREF","CLASS");

        $content=array_shift($args);
        $a=
            array
            (
                "TARGET" => "_blank",
            );

        for ($n=0;$n<count($args);$n++)
        {
            if (!empty($args[$n]))
            {
                $a[ $keys[$n] ]=$args[$n];
            }
        }

        if (!empty($image[ "TITLE" ]))
        {
            $image[ "ALT" ]=$image[ "TITLE" ];
        }
        
        return
            $this->Html_Tag_Start
            (
                "A",
                array
                (
                    "HREF" => $args[0],
                    "TARGET" => '_blank',
                )
            ).
            $content.
            $this->Html_Tag_Close("A").
            "";
    }
}

?>