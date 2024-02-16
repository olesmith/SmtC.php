<?php

trait App_Mobile
{

    //*
    //* 
    //*

    function Friend()
    {
        if ( !empty($this->CGI_GETint("Friend")) )
        {
            return
                $this->FriendsObj()->Sql_Select_Hash
                (
                    array
                    (
                        "ID" => $this->CGI_GETint("Friend"),
                    )
                );
        }
        elseif ( !empty($this->LoginData()) )
        {
            return $this->LoginData();
        }

        return array();
    }
    
    //*
    //* Use Unit to get top titles
    //*

    function MyApp_Interface_Top_Titles_Owner()
    {
        $divs=array();

        $friend=$this->Friend();
        if ( !empty($friend) )
        {
            array_push
            (
                $divs,
                $this->Htmls_DIV
                (
                    $friend[ "Name" ],
                    array
                    (
                        "CLASS" => array
                        (
                            "Mobile_Top_Title",
                            "Mobile_Top_Title_Second",
                        )
                    )
                )
            );
        }
        
        return $divs;
    }
}

?>