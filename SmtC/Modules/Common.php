<?php


include_once("Application/DBDataObj.php");
class ModulesCommon extends DBDataObj
{
    //*
    //* 
    //*

    function Profile_Coordinator_Is()
    {
        return $this->Current_Profile_Is("Coordinator");
    }

    //*
    //* 
    //*

    function Profile_Friend_Is()
    {
        return $this->Current_Profile_Is("Friend");
    }

    //*
    //* SCRIPT/LINK for highlight.
    //*

    function MyMod_Load_Highlight_By_ID($element_id,$language,$style="rainbow",$key="ITEMPROP")
    {
        return
            array_merge
            (
                $this->ApplicationObj()->MyApp_Load_Highlight($style),
                array
                (
                    $this->Htmls_Tag
                    (
                        "SCRIPT",
                        array
                        (
                            "Load_Highlight_By_ID(".
                            $this->JS_Quote($element_id).
                            ");\n"
                        )
                    ),
                )
            );
    }
}

?>