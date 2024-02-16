<?php

trait Texts_Import_HTML_Update
{
    //*
    //* 
    //*

    function Text_Import_HTML_Update_Path(&$text,$path)
    {
        $updatedatas=array();

        $this->Text_Import_HTML_Update_Src($text,$path,$updatedatas);
        $this->Text_Import_HTML_Update_Type($text,$updatedatas);
        $this->Text_Import_HTML_Update_File_Data($text,$updatedatas);

        $this->Text_Import_HTML_Update_Body_ATs($text,$updatedatas);
        
        $this->Text_Import_HTML_Update_Save($text,$updatedatas);
    }

    
    //*
    //* 
    //*

    function Text_Import_HTML_Update_Body_ATs(&$text,&$updatedatas)
    {
        $sections=preg_split('/\n\n+/',$text[ "Body" ]);
        for ($m=0;$m<count($sections);$m++)
        {
            $lines=preg_split('/\n/',$sections[ $m ]);
            for ($n=0;$n<count($lines);$n++)
            {
                if (preg_match('/@/',$lines[$n]))
                {
                    print $lines[$n];
                    
                    if (preg_match('/@SubdirsList/i',$lines[$n]))
                    {
                        $lines[$n]="";
                    }
                    elseif (preg_match('/@Latex/i',$lines[$n]))
                    {
                        $lines[$n]=
                            "$".
                            preg_replace('/@Latex\s*/i',"",$lines[$n]).
                            "$";

                        $text[ "IsLatex" ]=2;
                        array_push($updatedatas,"IsLatex");
                    }
                    elseif (preg_match('/@(Code|Exec)/i',$lines[$n]))
                    {
                        $lines[$n]=preg_replace('/^\s+/',"",$lines[$n]);
                        $lines[$n]=preg_replace('/\s+$/',"",$lines[$n]);
                        
                        $comps=preg_split('/\s+/',$lines[$n]);

                        $file="--";
                        if (count($comps)>1)
                        {
                            $file=$text[ "Src" ]."/".$comps[1];

                            $this->Text_Import_Code_File_Add($file);
                        }
                        
                        print "\tCODE: ".$file."\n";
                        
                    }
                    else
                    {
                        print "Unknown @\n".$lines[$n]."\n";
                    }
                }
            }

            $sections[ $m ]=join("\n",$lines);
        }


        $text[ "Body" ]=join("\n\n",$sections);
    }
    
    //*
    //* 
    //*

    function Text_Import_HTML_Update_Save($text,$updatedatas)
    {
        if (count($updatedatas)>0)
        {
            $this->CGI_Trim_Hash($text);
            
            print
                "Update ".$text[ "ID" ].", ".
                $text[ "Name" ].": ".
                join(", ",$updatedatas).
                "\n";
            
            $this->Sql_Update_Item_Values_Set($updatedatas,$text);
        }
    }
    
    //*
    //* 
    //*

    function Text_Import_HTML_Update_File_Data(&$text,&$updatedatas)
    {
        $files=
            $this->Text_Import_HTML_Read_Files($text);

        if (!empty($files))
        {
            foreach
                (
                    array
                    (
                        "Name"     => "Name",
                        "Title"    => "Title",
                        "Contents" => "Body",
                    )
                    as $src => $data
                )
            {
                if (!empty($files[ $src ]))
                {
                    $value=$this->Text2Html($files[ $src ]);
                    
                    if ($text[ $data ]!=$value)
                    {                        
                        $text[ $data ]=chop($value);
                        array_push($updatedatas,$data);
                    }
                }
            }

            $data="Code_Type";
            $value=1;//HTML
            if
                (
                    empty($text[ $data ])
                    ||
                    $text[ $data ]!=$value
                )
            {
                $text[ $data ]=$value;
                array_push($updatedatas,$data);
            }
        }

        /* //libxml_use_internal_errors(true); */
        /* $doc = new DOMDocument(); */

        /* $html= */
        /*     //"<HTML><BODY>". */
        /*     $text[ "Body" ]. */
        /*     //"</BODY></HTML>". */
        /*     ""; */
        /* $doc->loadHTML($html); */

        /* foreach ($doc->getElementsByTagName('ol') as $list) */
        /* { */
        /*     var_dump($list); */
        /*     exit(); */
        /* } */
        
        /* //var_dump($doc->saveHTML()); */
        //exit();
    }
    
    //*
    //* 
    //*

    function Text_Import_HTML_Update_Src(&$text,$path,&$updatedatas)
    {
        $values=
            array
            (
                "Src" => $text[ "Src" ],
                "Sort" => basename($text[ "Src" ]),
            );

        foreach ($values as $data => $value)
        {
            if
                (
                    empty($text[ $data ])
                    ||
                    $text[ $data ]!=$value
                )
            {
                $text[ $data ]=$value;
                array_push($updatedatas,$data);
            }
        }
            }
    
    //*
    //* 
    //*

    function Text_Import_HTML_Update_Type(&$text,&$updatedatas)
    {
        $value=$this->Text_Type_No("Text");
        
        $data="Type";
        if
            (
                empty($text[ $data ])
                ||
                $text[ $data ]!=$value
            )
        {
            $text[ $data ]=$value;
            array_push($updatedatas,$data);
        }
    }
}

?>