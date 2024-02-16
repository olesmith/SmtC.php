<?php


trait Html_Input_Buttons
{
    
    //*
    //* Creates a form button.
    //* 
    //*

    function Button($type,$title,$options=array())
    {
        return $this->Html_Input_Button($type,$title,$options);
    }

    //*
    //* Creates the form buttons.
    //* 

    function Buttons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=
                $this->MyLanguage_GetMessage("SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->MyLanguage_GetMessage("ResetButton");
        }

        return
            $this->Htmls_Center
            (
                array
                (
                    $this->Html_Input_Button_Make
                    (
                        "submit",
                        $submit,
                        array_merge
                        (
                            array
                            (
                                "ONCLICK" => "this.style.color='#DDDDDD';",
                            ),
                            $options
                        )
                    ),
                    $this->Html_Input_Button_Make
                    (
                        "reset",
                        $reset,
                        array_merge
                        (
                            array
                            (
                                "ONCLICK" => "Mark_Form_On_Input_Reset();",
                            ),
                            $options
                        )
                    ),
                )
            );
    }
    



    //*
    //* Creates the form buttons inlcuding a PDF button.
    //* 
    //*

    function PrintAndWhiteButtons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=$this->GetMessage($this->HtmlMessages,"SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->GetMessage($this->HtmlMessages,"ResetButton");
        }

        return
            $this->Center
            (
                $this->Html_Input_Button_Make("submit",$submit,$options).
                $this->Html_Input_Button_Make("reset",$reset,$options).
                $this->Html_Input_Button_Make
                (
                   "submit",
                   "PDF",
                   array_merge
                   (
                      $options,
                      array
                      (
                         "NAME" => "Latex",
                         "VALUE" => "1",
                      )
                   )
                ).
                $this->Html_Input_Button_Make
                (
                   "submit",
                   "Em Branco",
                   array_merge
                   (
                      $options,
                      array
                      (
                         "NAME" => "Latex",
                         "VALUE" => "2",
                      )
                   )
                 )
            );
    }

    
    //*
    //* Creates a form button.
    //* 

    function Html_Input_Button_Make($type,$title,$options=array())
    {
        if (empty($type)) { return $this->Html_Tags("BUTTON",$title,$options); }
        //global $Buttons_ID;

        $options[ "TYPE" ]=$type;

        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array();
        }
        
        if (is_string($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array($options[ "CLASS" ]);
        }
        
        $options[ "CLASS" ]=
            array_merge
            (
                $options[ "CLASS" ],
                array("button is-info")
            );

        
        if (empty($options[ "STYLE" ]))
        {
            $options[ "STYLE" ]=array();
        }

        $options[ "STYLE" ][ "opacity" ]='0.75';
        
        if ($type == "submit")
        {
            //$options[ "CLASS" ]="button is-info";
            if (!empty($options[ "ID" ]))
            {
                $options[ "formaction" ]="#".$options[ "ID" ];
            }
            
            $onclick=array();
            if (empty($options[ "ONCLICK" ]))
            {
                $options[ "ONCLICK" ]=array();
            }
            
            if (!is_array($options[ "ONCLICK" ]))
            {
                $options[ "ONCLICK" ]=array($options[ "ONCLICK" ]);
            }
            
            $options[ "ONCLICK" ]=
                array_merge
                (
                    $options[ "ONCLICK" ],
                    $this->Html_Input_Button_Send_ONCLICK_Color_Changes()
                );
        }
        
        return $this->Htmls_Tag("BUTTON",$title,$options);
    }
    
    //*
    //* Creates a centered form button.
    //* 

    function Html_Input_Button_Send_ONCLICK_Color_Changes()
    {
        return
            array
            (
                //"this.style.color='#222222';",
                //"this.style.background='#777777';",
                "this.style.opacity=0.5;",
            );
    }
    
    //*
    //* Creates a centered form button.
    //* 

    function Html_Input_Button($type,$title,$options=array())
    {
        return
            $this->Center
            (
                $this->Html_Input_Button_Make($type,$title,$options)
            );
    }
    
    //*
    //* Creates form buttons, submit and reset.
    //* 

    function Html_Input_Buttons_Make($buttons,$options=array())
    {
        $html="";
        foreach ($buttons as $button)
        {
            $html.=
                $this->Html_Input_Button_Make
                (
                   $button[ "Type" ],
                   $button[ "Title" ],
                   $options
                );
        }

        return $this->Center($html);
    }
    
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Buttons($buttons,$options=array())
    {
        return
            $this->Center
            (
                $this->Html_Input_Buttons_Make($buttons,$options)
            );
    }
    
    //*
    //* Printsform centered buttons.
    //* 

    function Html_Input_Buttons_Print($buttons,$options=array())
    {
        return
            $this->Center
            (
                $this->Html_Input_Buttons_Make($buttons,$options)
            );
    }
    
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Button_Image($img,$name,$value,$options=array())
    {
        $options[ "SRC" ]=$img;
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;
        return
            $this->Html_Input_Button_Make
            (
                'submit',
                $img,
                $options
            );
    }
    
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Button_Text($text,$name,$value,$options=array())
    {
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;
        return
            $this->Html_Input_Button_Make
            (
                'submit',
                $text,
                $options
            );
    }
    
}
?>