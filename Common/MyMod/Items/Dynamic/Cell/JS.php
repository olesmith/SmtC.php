<?php

include_once("Common/JS.php");

trait MyMod_Items_Dynamic_Cell_JS
{
    use JS;
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Cell_JS_OnClick($group,$item,$action,$def,$load,$hide_button)
    {
        $display="table-row";
        if ($hide_button)
        {
            $display="none";
        }

        //var_dump($def);
        if (empty($item))
        {
            $function_body=
                $this->JS_Function_Call
                (
                    "Load_Module_Action",
                    array
                    (
                        $this->MyMod_Item_Dynamic_Cell_Url
                        (
                            $group,$item,$action,$def
                        ),
                        $this->ModuleName,
                        $action,
                        $this->MyMod_Item_Dynamic_Destination_Cell_ID($item,$group),
                        $this->MyMod_Item_Dynamic_Destination_Row_ID($item,$group),
                        $display,
                    )
                );
        }
        else
        {
            $function_body=
                $this->JS_Function_Call
                (
                    "Load_Item_Module_Action",
                    array
                    (
                        $this->MyMod_Item_Dynamic_Cell_Url
                        (
                            $group,$item,$action,$def
                        ),
                        $item[ "ID" ],
                        $this->ModuleName,
                        $action,
                        $this->MyMod_Item_Dynamic_Destination_Cell_ID($item,$group),
                        $this->MyMod_Item_Dynamic_Destination_Row_ID($item,$group),
                        $display,
                    )
                );
        }

        $function1='Show_Elements_By_Class';
        $function2='Hide_Elements_By_Class';
        if ($hide_button)
        {
            $tmp=$function1;
            $function1=$function2;
            $function2=$tmp;
        }
        

        

        return
            /* "function Loadit(){". */
            join
            (
                "\n",
                array
                (
                    "",
                    join("\n",$function_body),
                    /* $function1.'("'. */
                    /* $this->MyMod_Item_Dynamic_Cell_Classes($item,$action,$def,True). */
                    /* '");', */
                    /* $function2.'("'. */
                    /* $this->MyMod_Item_Dynamic_Cell_Classes($item,$action,$def,False). */
                    /* '");', */
                )
            ).
            /* "\n}". */
            "";
   }
}

?>