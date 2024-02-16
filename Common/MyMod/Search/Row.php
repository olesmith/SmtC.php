<?php


trait MyMod_Search_Row
{
    //*
    //* Creates form search vars table row as array.
    //*

    function MyMod_Search_Row_Generate($data,$fixedvalues,$details,$rval="")
    {
        if (!$this->MyMod_Search_Data_May($data))
        {
            return array();
        }
        
        $row=
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyMod_Search_Field_Title($data).
                        ":",
                    ),
                    array
                    (
                        "CLASS" => 'searchtitle',
                    )
                ),
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyMod_Search_Field_Make($data,$fixedvalues,$rval),
                    ),
                    array
                    (
                        "CLASS" => $this->MyMod_Search_Row_Field_Class($data)
                    )
                ),
            );
        
        if ($details)
        {
            $row=
                array
                (
                    "Row" => $row,
                    "Class" => "Search_Details",
                    "Style" => "display: none;",
                );
        }


        return $row;        
    }
    
    //*
    //* Creates form search vars table row as array.
    //*

    function MyMod_Search_Row_Field_Class($data)
    {
        $classes=array('searchdata');
        if
            (
                $this->MyMod_Data_Field_Is_Sql($data)
                ||
                $this->MyMod_Data_Field_Is_Enum($data)
            )
        {
            array_push($classes,'select');
        }

        return join(" ",$classes);
    }
}

?>