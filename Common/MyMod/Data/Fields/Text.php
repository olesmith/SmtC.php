<?php


trait MyMod_Data_Fields_Text
{
    //*
    //* Creates TEXT AREA input field.
    //*

    function MyMod_Data_Fields_Text_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$options=array(),$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        if (!empty($this->ItemData[ $data ][ "Input_Class" ]))
        {
            if (empty($options[ "CLASS" ]))
            {
                $options[ "CLASS" ]=array();
            }
            
            if (!is_array($options[ "CLASS" ]))
            {
                $options[ "CLASS" ]=array($options[ "CLASS" ]);
            }

            array_push
            (
                $options[ "CLASS" ],
                $this->ItemData[ $data ][ "Input_Class" ]
            );
        }
        $options[ "ID"]=
            $this->MyMod_Data_Field_Input_Edit_ID($data,$item);

        $value=preg_replace('/^\s+/',"",$value);
        $value=preg_replace('/\s+$/',"",$value);

        $value=
            $this->Htmls_Input_Text_Area
            (
                $rdata,
                $this->MyMod_Data_Fields_Text_COLS($data,$value,$plural),
                $this->MyMod_Data_Fields_Text_ROWS($data,$value,$plural),
                $value,
                $options,
                "hard"
            );

        return $value;
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Fields_Text_Size($data,$plural)
    {
        $size=$this->ItemData[ $data ][ "Size" ];
        if ($plural && $this->ItemData[ $data ][ "TableSize" ]!="")
        {
            $size=$this->ItemData[ $data ][ "TableSize" ];
        }

        return preg_split('/\s*x\s*/',$size);
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Fields_Text_COLS($data,$value,$plural)
    {
        $size=
            $this->MyMod_Data_Fields_Text_Size($data,$plural);
        
        $cols=50;
        if (count($size)>0) { $cols=$size[0]; }

        return $cols;
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Fields_Text_ROWS($data,$value,$plural)
    {
        $value=html_entity_decode($value);
        $values=preg_split('/\n+/',$value);
       
        $size=
            $this->MyMod_Data_Fields_Text_Size($data,$plural);
        
        $rows=5;
        if (count($size)>1) { $rows=$size[1]; }

        $rows=max($rows,count($values));
        
        return $rows;
    }
    
    //*
    //* Creates TEXT AREA input field.
    //*

    function MyMod_Data_Fields_Text_Show($data,$item,$value="",$plural=False,$options=array())
    {
        if (empty($value) && isset($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        
        if (empty($options[ "NoBR" ]))
        {
            $value=preg_replace('/\n/',$this->BR(),$value);
        }
        
        //Remove leading and trailing white space
        $value=preg_replace('/^\s+/',"",$value);
        $value=preg_replace('/\s+$/',"",$value);

        if (!empty($this->ItemData($data,"CSS")))
        {
            $value=
                $this->Htmls_DIV
                (
                    $value,
                    array
                    (
                        "CLASS" => $this->ItemData($data,"CSS"),
                    )
                );
        }

        return $value;
    }
    
 }

?>