<?php


trait MyMod_Items_Dynamic_Cell_Args
{
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_Args($item,$action,$def)
    {
        $args=$def[ "Args" ];
        $this->ApplicationObj()->AddCommonArgs2Hash($args);

        foreach ($def[ "GETs" ] as $data)
        {
            if (!empty($item[ $data ]))
            {
                $args[ $data ]=$item[ $data ];
            }
            elseif ( ($value=$this->CGI_GETint($data))>0)
            {
                $args[ $data ]=$value;
            }
        }

        if (!empty($def[ "Hash" ]))
        {
            foreach ($def[ "Hash" ] as $data => $rdata)
            {
                if (!empty($item[ $rdata ]))
                {
                    $args[ $data ]=$item[ $rdata ];
                }
                elseif ( ($value=$this->CGI_GETint($rdata))>0)
                {
                    $args[ $data ]=$value;
                }
            }
        }

        //var_dump($item,$args);
       
        return $args;
    }
}

?>