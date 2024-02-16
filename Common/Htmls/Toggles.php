<?php

trait Htmls_Toggles
{
    //*
    //* 
    //*

    function Hmls_Display_Toggles($def,$options=array())
    {
        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array();
        }

        if (!is_array($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array($options[ "CLASS" ]);
        }

        
        if (!empty($def[ "Class" ]))
        {
            array_push($options[ "CLASS" ],$def[ "Class" ]);
        }
        
        if (!empty($def[ "Title" ]))
        {
            $icon=$def[ "Title" ];
            $alt_icon=$def[ "Title" ];
        }
        else
        {
            $icon=    $this->MyMod_Interface_Icon($def[ "Icons" ][0]);
            $alt_icon=$this->MyMod_Interface_Icon($def[ "Icons" ][1]);
        }

        $dest_id=$def[ "Destination" ];

        if (is_array($dest_id))
        {
            $dest_id=join("_",$def[ "Destination" ]);
        }

        return
            array
            (
                $this->Htmls_SPAN
                (
                    $icon,
                    //$options=
                    array_merge
                    (
                        $options,
                        array
                        (
                            "ID"      => $def[ "Show" ],
                            "CLASS"   => array_merge
                            (
                                $options[ "CLASS" ],
                                $def[ "Show" ]
                            ),
                            "ONCLICK" => array
                            (
                                $this->JS_Hide_Element_By_ID($def[ "Show" ]),
                                $this->JS_Show_Element_By_ID($def[ "Hide" ]),
                            
                                $this->JS_Show_Element_By_ID
                                (
                                    $dest_id,
                                    $def[ "Display" ]
                                ),
                                $this->JS_Load_URL_2_Element
                                (
                                    $def[ "URL" ],
                                    $dest_id
                                ),
                            )
                        )
                    ),
                    
                    $this->Hmls_Display_Toggle_Style($def,False)
                ),
                $this->Htmls_SPAN
                (
                    $alt_icon,
                    //$options=
                    array_merge
                    (
                        $options,
                        array
                        (
                        
                            "ID"      => $def[ "Hide" ],
                            "CLASS"   => array_merge
                            (
                                $options[ "CLASS" ],
                                $def[ "Hide" ]
                            ),
                            "ONCLICK" => array
                            (                            
                                $this->JS_Show_Element_By_ID($def[ "Show" ]),
                                $this->JS_Hide_Element_By_ID($def[ "Hide" ]),
                                $this->JS_Hide_Element_By_ID($dest_id),
                            )
                        )
                    ),
                    
                    $this->Hmls_Display_Toggle_Style($def,True)
                ),
            );        
    }
    
    //*
    //* 
    //*

    function Hmls_Display_Toggle_Style($def,$hide)
    {
        $style=array();

        $pos=0;
        if ($hide)
        {
            $pos=1;
            $style[ "display" ]='none';
        }

        if (!empty($def[ "Colors" ]))
        {
            $style[ "color" ]=$def[ "Colors" ][ $pos ];
        }
        
        if (!empty($def[ "Opacities" ]))
        {
            $style[ "opacity" ]=$def[ "Opacities" ][ $pos ];
        }
        
        return $style;
    }
}

?>