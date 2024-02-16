<?php

trait MyApp_Login_Table
{
    //*
    //* Creates login form table.
    //*

    function MyApp_Login_Table()
    {
        $login=$this->CGI_POST("Login");
        if (empty($login))
        {
            $login=$this->CGI_GET("Email");
        }
 
        return
            array
            (
                $this->MyApp_Login_Row_Login($login),
                $this->MyApp_Login_Row_Password($login),
                array
                (
                    "",
                    $this->MyApp_Login_Form_Trailer()
                )
            );

    }
    //*
    //*
    //*

    function MyApp_Login_Row_Login($login)
    {
        $row=
            array
            (
                $this->B
                (
                    $this->MyLanguage_GetMessage("LoginDataTitle").
                    ":"
                ),
                $this->Htmls_Input_Text
                (
                    "Login",
                    $login,
                    array
                    (
                        "ID"   => "Login",
                        "SIZE" => 25,
                    )
                )
            );

        if ($domain=$this->MyApp_Login_Default_Domain())
        {
            array_push
            (
                $row,
                "[@".$domain."]"
            );
        }

        return $row;
    }
    
    //*
    //*
    //*

    function MyApp_Login_Row_Password($login)
    {
        return
            array
            (
                $this->B
                (
                    $this->MyLanguage_GetMessage("PasswordDataTitle").
                    ":"
                ),
                $this->Htmls_Input_Password
                (
                    "Password",
                    "",
                    array
                    (
                        "ID"   => "Email",
                        "SIZE" => 25,
                    )
                )
            );           
    }
}

?>