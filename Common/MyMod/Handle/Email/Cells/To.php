<?php

trait MyMod_Handle_Email_Cells_To
{
    //*
    //* To (Recipient) cell.
    //*

    function MyMod_Handle_Email_Cell_To($edit,$item)
    {
        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Handle_Email_Cell_To_Table($edit,$item),
                array
                (
                    "ALIGN" => 'left',
                ),
                array(),array(),TRUE,TRUE
            );
    }

    //*
    //* Row with CELL table.
    //*

    function MyMod_Handle_Email_Cell_To_Table($edit,$item)
    {
        $table=
            $this->MyMod_Handle_Email_Cell_To_Emails_Table
            (
                $edit,$item
            );
        
        if ($this->MyMod_Handle_Email_To_Input_Field())
        {
            array_push
            (
                $table,
                $this->MyMod_Handle_Email_Cell_To_Input_Row
                (
                    $edit,$item
                )
            );
                
        }

        return $table;
    }
    
    //*
    //* Row with Emails table.
    //*

    function MyMod_Handle_Email_Cell_To_Emails_Table($edit,$item)
    {
        $emails=
            $this->MyMod_Handle_Emails_Read
            (
                $item
            );
        
        $row=array();
        foreach (array_keys($emails) as $friendkey)
        {
            $table=
                $this->MyMod_Handle_Emails_Table
                (
                    $edit,
                    $emails[ $friendkey ],
                    2,
                    True,FALSE
                );


            $name=$this->ItemsName;
            if ($friendkey!="ID")
            {
                if (!empty($this->ItemData[ $friendkey ][ "PName" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "PName" ];
                }
                if (!empty($this->ItemData[ $friendkey ][ "Name" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "Name" ];
                }                
            }

            array_unshift
            (
                $table,
                $this->B($name)
            );
            
            array_push
            (
                $row,
                $this->Htmls_Table
                (
                    "",
                    $table,
                    array("WIDTH" => '100%'),array(),array(),TRUE,TRUE
                )
            );
        }

        return array($row);
    }
    
    //*
    //* Row with Input (TEXT) field.
    //*

    function MyMod_Handle_Email_Cell_To_Input_Row($edit,$item)
    {
        return
            array
            (
                $this->Htmls_Input_Text
                (
                    "To","",
                    array
                    (
                        "SIZE" => 80,
                        "PLACEHOLDER" => "Emails"
                    )
                ),
            );
    }
}

?>