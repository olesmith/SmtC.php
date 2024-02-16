<?php

class Language_Messages_Handle_Arrays_Form extends Language_Messages_Handle_Arrays_Update
{
    var $Language_Messages_Handle_Arrays_Form_CGI="Save";
    //*
    //* Generates the common table.
    //*

    function Language_Messages_Handle_Array_Form($edit,$item)
    {
        return
            array
            (
                $this->Htmls_H(3,"List of Messages"),
                $this->MyMod_Items_Dynamic
                (
                    0,
                    $this->Sql_Select_Hashes
                    (
                        array
                        (
                            "Message_Key"  => $item[ "Message_Key" ],
                            "Message_Type" => $item[ "Message_Type" ],
                        )
                    )
                ),
            );
        
    /*     $this->Language_Messages_Handle_Array_Read($edit,$item); */

    /*     if ($this->CGI_POSTint($this->Language_Messages_Handle_Arrays_Form_CGI)==1) */
    /*     { */
    /*         $this->Language_Messages_Handle_Array_Update($edit,$item); */
    /*     } */
        
    /*     return */
    /*         array */
    /*         ( */
    /*             $this->Htmls_Form */
    /*             ( */
    /*                 1, */
    /*                 "Arrays", */
    /*                 "", */
    /*                 array */
    /*                 ( */
    /*                     $this->Language_Messages_Handle_Array_SGroup(0,$item), */
    /*                     $this->Language_Messages_Handle_Array_Html($edit,$item), */

    /*                 ), */
    /*                 $args=array */
    /*                 ( */
    /*                     "Hiddens" => array */
    /*                     ( */
    /*                         $this->Language_Messages_Handle_Arrays_Form_CGI => 1, */
    /*                     ) */
    /*                 ) */
    /*             ), */
    /*         );   */
    }
}
?>