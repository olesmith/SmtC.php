<?php

trait Texts_Is
{
    //*
    //* 
    //*

    function Text_Is_Open($text)
    {
        $res=False;
        if (intval($text[ "Open" ])==2)
        {
            $res=True;
        }

        return $res;
    }
    //*
    //* 
    //*

    function Text_Is_Inline($text)
    {
        return
            $this->Text_Is_List($text);
    }
    
    //*
    //* 
    //*

    function Text_Is_Carousel($text)
    {
        return $this->Text_Type_Is("Carousel",$text);
    }
    
    //*
    //* 
    //*

    function Text_Is_Link($text)
    {
        return $this->Text_Type_Is("Link",$text);
    }
    
    //*
    //* 
    //*

    function Text_Is_List($text)
    {
        $res=False;
        
        $value=intval($text[ "Type" ]);
        if
            (
                $value==$this->__Types__[ "List" ]
                ||
                $value==$this->__Types__[ "Itemize" ]
                ||
                $value==$this->__Types__[ "Enumerate" ]
            )
        {
            $res=True;
        }

        //var_dump($res);

        return $res;
    }

    //*
    //* 
    //*

    function Text_Is_Root($text)
    {
        if (empty($text)) { return True; }
        
        $res=False;

        
        if
            (
                !empty($text[ "Root" ])
                &&
                intval($text[ "Root" ])==2
            )
        {
            $res=True;
        }

        return $res;
    }

    //*
    //* 
    //*

    function Text_Is_Question($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "Question" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_Exercise($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "Exercise" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_Code($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "Code" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_Curve($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "Curve" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_URL($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "URL" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_Image($text)
    {
        $res=False;
        if
            (
                intval($text[ "Type" ])==$this->__Types__[ "Image" ]
            )
        {
            $res=True;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Text_Is_Question_Or_Exercise($text)
    {
        return
            $this->Text_Is_Question($text)
            ||
            $this->Text_Is_Exercise($text);
    }

    //*
    //* 
    //*

    function Text_Latex_Is($text=array())
    {
        if (empty($text)) { return True; }
        
        $res=False;
        if (intval($text[ "IsLatex" ])==2)
        {
            $res=True;
        }

        //var_dump($text[ "Type" ]);
        return $res;
    }

    //*
    //* $text has "File" nonempty.
    //*

    function Text_File_Is($text=array())
    {
        return !empty($text[ "File" ]);
    }
    
    //*
    //* $text is executable.
    //*

    function Text_Exec_Is($text=array())
    {
        return 
            $this->Text_File_Is($text)
            &&
            $this->Text_Is_Python($text);
    }
    
    //*
    //* 
    //*

    function Text_PDF_Is($text=array())
    {
        if (empty($text)) { return True; }
        
        $res=False;
        if (intval($text[ "PDF" ])==2)
        {
            $res=True;
        }

        //var_dump($text[ "Type" ]);
        return $res;
    }

}

?>