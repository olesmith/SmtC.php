<?php

trait Htmls_Table_Cells
{
    //*
    //* Creates TD cell.
    //* 

    function Htmls_Table_Cell($cell,$options=array(),$tdtag="TD")
    {
        if (is_array($cell) && isset($cell[ "Text" ]))
        {
            if (!empty($cell[ "Options" ]))
            {
                foreach ($cell[ "Options" ] as $key => $value)
                {
                    if (empty($options[ $key ]))
                    {
                        if (is_array($value)) { $options[ $key ]=array(); }
                        else                  { $options[ $key ]=""; }
                    }
                    
                    if (is_array($value))
                    {
                        foreach ($value as $rkey => $val)
                        {
                            $options[ $key ][ $rkey ]=$val;
                        }
                    }
                    else
                    {
                        if (is_array($options[ $key ]))
                        {
                            array_push($options[ $key ],$value);
                        }
                        else
                        {
                            $options[ $key ].=" ".$value;
                        }
                    }
                }
            }

            if (!empty($cell[ "Class" ]))
            {
                 $this->Html_CSS_Add($cell[ "Class" ],$options);
            }

            $cell=$cell[ "Text" ];
        }

        if (!empty($options[ "ID" ]))
        {
            $options[ "ID" ]=preg_replace('/\s+/',"",$options[ "ID" ]);
            //var_dump($options[ "ID" ]);
        }

        return $this->Htmls_Tag($tdtag,$cell,$options);
    }
}

?>