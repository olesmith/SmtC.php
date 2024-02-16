<?php

trait MyMod_CLI
{
    //*
    //* CLI Post processing
    //*

    function MyMod_CLI_POST($args)
    {
        print $this->ModuleName." Define MyMod_CLI_POST_Do\n\n";;

        if (method_exists($this,"MyMod_CLI_POST_Do"))
        {
            $this->MyMod_CLI_POST_Do($args);
        }

        return array();
    }
}

?>