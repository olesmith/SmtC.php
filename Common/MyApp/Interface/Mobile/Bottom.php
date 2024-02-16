<?php


trait MyApp_Interface_Mobile_Bottom
{  
    //*
    //* 
    //*

    function MyApp_Interface_Mobile_Bottom()
    {
        $h=1;
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->MyApp_Interface_Mobile_Languages()
                ),
            );
    }
}

?>