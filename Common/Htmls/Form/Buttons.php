<?php

trait Htmls_Form_Buttons
{
    //*
    //* function Html_Form_Buttons_Make, Parameter list:
    //*
    //* Generates buttons html, none if $edit!=1.
    //*
    
    function Htmls_Form_Buttons_Make($edit,$buttons,$divoptions=array())
    {
        $html=array();
        if ($edit==1 && !empty($buttons))
        {
            $html=
                $this->Htmls_Tag
                (
                    "DIV",
                    $buttons,
                    $this->Htmls_Form_Buttons_DIV_Options($divoptions)
                );
        }

        return $html;
    }
    
    //*
    //* 
    //*
    
    function Htmls_Form_Buttons_DIV_Options($divoptions)
    {
        if (empty($divoptions[ "ALIGN" ]))
        {
            $divoptions[ "ALIGN" ]='center';
        }
        
        if (True)//!$this->MyMod_Interface_Mobile_Is())
        {
            $divoptions[ "STYLE"  ]=
                array
                (
                    'position' => 'sticky',
                    'bottom'      => 0,
                );
        }
        
        return $divoptions;
    }
    
    //*
    //* function Html_Form_Buttons, Parameter list:
    //*
    //* Conditionally generates buttons.
    //*
    
    function Htmls_Form_Buttons($edit,$args)
    {
        $buttons=array();
        if (!empty($args[ "Buttons" ])) { $buttons=$args[ "Buttons" ]; }

        return $this->Htmls_Form_Buttons_Make($edit,$buttons);
    }
}

?>