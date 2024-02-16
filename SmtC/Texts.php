<?php


include_once("Texts/Access.php");
include_once("Texts/Is.php");
include_once("Texts/Types.php");
include_once("Texts/Cells.php");
include_once("Texts/Children.php");
include_once("Texts/Parent.php");
include_once("Texts/Descendents.php");
include_once("Texts/Handle.php");
include_once("Texts/Display.php");
include_once("Texts/Roots.php");
include_once("Texts/Root.php");
include_once("Texts/Select.php");
include_once("Texts/Create.php");
include_once("Texts/Latex.php");
include_once("Texts/Exec.php");
include_once("Texts/Link.php");
include_once("Texts/PDF.php");


include_once("Texts/Code.php");
include_once("Texts/Codes.php");
include_once("Texts/Curve.php");
include_once("Texts/Carousel.php");

include_once("Texts/Import.php");

class Texts extends ModulesCommon
{
    use
        Texts_Access,
        Texts_Is,
        Texts_Types,
        Texts_Cells,
        Texts_Children,
        Texts_Descendents,
        Texts_Parent,
        Texts_Handle,
        Texts_Select,
        Texts_Create,
        Texts_Display,
        Texts_Link,
        Texts_Exec,
        Texts_Root,
        Texts_Roots,
        Texts_Latex,
        Texts_PDF,
        
        Texts_Code,
        Texts_Codes,
        Texts_Curve,
        Texts_Carousel,
        Texts_Import;
    
    //*
    //* Constructor.
    //*

    function __construct($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
                "Name","Title","Friend","Parent",
                "Mode","Type","Code_Type","File","File_OrigName"
            );
        $this->Sort=array("Name");
        $this->UploadFilesHidden=FALSE;        
        $this->CellMethods[ "Text_Cell_NChildren" ]=TRUE;   
        $this->CellMethods[ "Text_Cell_File" ]=TRUE;

        $this->ItemNamer="Name";
        $this->IDGETVar="Text";
    }


    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push
        (
            $this->ItemDataFiles,
            "Data.Exercises.php",
            "Data.URL.php",
            "Data.File.php",
            "Data.Carousel.php",
            "Data.Link.php"
        );        
    }

    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }
        
        $updatedatas=array(); 

        $data="File";

        $updatedatas=array(); 

        $rdata="Code_Type";
        if (!empty($item[ $data ]))
        {
            $type=0;
            if (preg_match('/\.html$/i',$item[ $data ]))
            {
                $type=1;
            }
            elseif (preg_match('/\.js/i',$item[ $data ]))
            {
                $type=2;
            }
            elseif (preg_match('/\.svg/i',$item[ $data ]))
            {
                $type=3;
            }
            elseif (preg_match('/\.tex/i',$item[ $data ]))
            {
                $type=4;
            }
            elseif (preg_match('/\.py3?/i',$item[ $data ]))
            {
                $type=5;
            }
            elseif (preg_match('/\.php?/i',$item[ $data ]))
            {
                $type=6;
            }

            if
                (
                    empty($item[ $rdata ])
                    ||
                    intval($item[ $rdata ])!=$type
                )
            {
                $item[ $rdata ]=$type;
                array_push($updatedatas,$rdata);
                
            }
                
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }
    
    //*
    //* Load_Method in data groups.
    //*

    function Text_Open_Should($item,$items)
    {
        $res=False;
        if (intval($item[ "Open" ])==2)
        {
            $res=True;
        }

        return $res;
    }

    //*
    //* Preprocesser for copying. Does nothing - meant to be overriden.
    //*

    function MyMod_Handle_Copy_Pre_Process(&$item)
    {
        $sorts=
            $this->Sql_Select_Unique_Col_Values
            (
                "Sort",
                array("Parent" => $item[ "Parent" ])
            );
        
        if (preg_match('/^\d+$/',$item[ "Sort" ]))
        {
            $item[ "Sort" ]=max($sorts)+1;
        }
        elseif (preg_match('/(\w)$/',$item[ "Sort" ]))
        {
            sort($sorts);

            
            $value=ord(array_pop($sorts));
            $value=chr($value+1);
            $item[ "Sort" ]=$value;
        }
    }

    
    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function MyMod_Data_Upload_Path0000($item=array())
    {
        if (empty($item[ "Friend" ]))
            {
                var_dump($item,$r);
                exit();
            }
        
        return
            preg_replace
            (
                '/Uploads\//',
                "Uploads/".$item[ "Friend" ]."/",
                parent::MyMod_Data_Upload_Path($item)
            );
    }

    //*
    //* Will move output files to new path.
    //*

    function Text_Path_Exec_Trigger($text,$data,$newvalue)
    {
        $outpath=$this->Texts_Exec_Path_Absolute($text);
        $outname=
            preg_replace
            (
                '/\.log$/',"",
                $this->Texts_Exec_Output_File_Name($text)
            );
        
        $outname=
            preg_replace
            (
                '/\S+\//',"",
                $outname
            );

        $files=$this->Dir_Files($outpath,$outname);
        

        $rtext=$text;
        $rtext[ "Path" ]=$newvalue;
        $newpath=$this->Texts_Exec_Path_Absolute($rtext);
        
        //var_dump($outpath,$outname,$files,$newpath);
        $res=$this->Dir_Create_AllPaths($newpath,$tell=True);

        if ($res)
        {
            /* $commands= */
            /*     array */
            /*     ( */
            /*         //"echo", */
            /*         "/bin/mv", */
            /*         $outpath."/".$outname."*", */
            /*         $newpath."/.", */
            /*     ); */

            /* $text[ "Path" ]=$newvalue; */
            /* $this->System_Run($commands,$echo=True); */
        }
        
        return $text;
    }

}

?>