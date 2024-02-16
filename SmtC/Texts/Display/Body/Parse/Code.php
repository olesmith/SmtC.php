<?php

trait Texts_Display_Body_Parse_Code
{
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code($text,$args)
    {
        $hash=$this->Text_Display_Body_Parse_Code_Hash($text,$args);
        
        return
            $this->Html_Tags
            (
                "DIV",
                array
                ( 
                    $this->Html_Tags
                    (
                        "PRE",
                        $this->Html_Tags
                        (
                            "CODE",  
                            htmlentities
                            (
                                preg_replace('/&#039;/'," ",$hash[ "Content" ])
                            ),
                            array
                            (
                                "CLASS" => "language-".$hash[ "Language" ],
                            )
                        )
                    ),
                    $this->Text_Display_Body_Parse_Code_Regexp_Text
                    (
                        $text,
                        $hash
                    ),
                   
                ),
                array
                (
                    "CLASS" => $this->Text_Display_Code_ID($text),
                )
            );
    }
    
    //*
    //* Hash for defining code.
    //*

    function Text_Display_Body_Parse_Code_Hash($text,$args)
    {
        $hash=
            array
            (
                "File" => $this->Text_Display_Body_Parse_Code_File_Name
                (
                    $text,$args
                ),
                "Search" => $this->Text_Display_Body_Parse_Code_Search
                (
                    $text,$args
                ),
            );

        $hash[ "Content" ]=$hash[ "File" ];
        $hash[ "Language" ]=
           $this->Text_Display_Body_Parse_Code_Language
           (
               $text,$args,$hash
           );

        if ($this->MyFile_Exists($hash[ "Content" ]))
        {
            $hash=
                $this->Text_Display_Body_Parse_Code_File($text,$hash,$args);
        }

        return $hash;
    }
    
    //*
    //* Detect file name from $text and $args.
    //*

    function Text_Display_Body_Parse_Code_File_Name($text,$args)
    {
        $file="";

        if (count($args)>0)
        {
            $file=$args[0];
        
            if (!empty($file) && !file_exists($file))
            {
                if (file_exists(getcwd()."/".$file))
                {
                    $file=getcwd()."/".$file;
                }
            }
        }

        if (empty($file))
        {
            $file=$this->Text_Parents_First_File($text);
        }
        
        return $file;        
    }

    //*
    //* Detect search name from $text and $args.
    //*

    function Text_Display_Body_Parse_Code_Search($text,$args)
    {
        $search="";
        if (count($args)>1)
        {
            $search=$args[1];
        }

        return $search;
    }
    
    //*
    //* Detect programming language name from $text and $args.
    //*

    function Text_Display_Body_Parse_Code_Language($text,$args,$hash)
    {
        $language="haml";
        if (preg_match('/\.\S+$/',$hash[ "File" ]))
        {
            $language=$this->Text_Code_File_2_Language($hash[ "File" ]);
            if (count($args)>2)
            {
                $language=$args[2];
            }
        }

        return $language;
    }
        
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_File($text,$hash,$args)
    {
        $func=
            $this->Text_Display_Body_Parse_Code_Function_Regexp
            (
                $text,$hash
            );
        
        $pres="";
        $isjs=False;
        if (preg_match('/^javascript/',$hash[ "Language" ]))
        {
            $isjs=True;
            $pres="let|const|var";
        }

        $contents=$this->MyFile_Read($hash[ "File" ]);

        $functions=array();
        for ($n=0;$n<count($contents);$n++)
        {
            if
                (
                    preg_match
                    (
                        '/^\s*('.$func.')\s+(\S+)/',
                        $contents[$n],$matches
                    )
                )
            {
                $function=$matches[2];
                $functions[ $function ]=$n;
            }
            
            //Fucking javascript classes use nothing ('function') before methods...
            elseif ($isjs)
            {
                if
                    (
                        preg_match
                        (
                            '/^\s*(var|let|const)\s+(\S+)=('.$func.')/',
                            $contents[$n],$matches
                        )
                    )
                {
                    //var_dump($matches);
                    $function=$matches[2];
                    $functions[ $function ]=$n;
                }
                
            }
        }

        $function_nos=array_values($functions);
        
        if (!empty($hash[ "Search" ]))
        {
            //translate 'ending in' $ to \b
            if (preg_match('/\$$/',$hash[ "Search" ]))
            {
                $hash[ "Search" ]=preg_replace('/\$$/',"\\b",$hash[ "Search" ]);
            }
            
            $rfunctions=
                preg_grep
                (
                    '/'.$hash[ "Search" ].'/',
                    array_keys($functions)
                );
            
            $from_tos=array();
            foreach ($rfunctions as $id => $rfunction)
            {
                $from=$functions[ $rfunction ];            
                $tos=array();
                foreach ($function_nos as $no)
                {
                    if ($no>$from)
                    {
                        array_push($tos,$no);
                    }
                }

                $to=$from+1;
                if (count($tos)>0)
                {
                    $to=min($tos);
                }
                else
                {
                    $to=count($contents)-1;
                }

                array_push($from_tos,[$from,$to-1]);
            }
            
            //var_dump(count($contents),$from_tos);

            $rcontents=array();
            foreach ($from_tos as $from_to)
            {
                $from=$from_to[0];
                $to=$from_to[1];

                $this->Text_Display_Body_Parse_Code_File_Comments_Adjust
                (
                    $text,$hash,$contents,
                    $from,$to
                );
                
                //var_dump($from_to);

                if ($from<=$to)
                {
                    for ($m=$from;$m<=$to;$m++)
                    {
                        array_push($rcontents,$contents[$m]);
                    }
                }
            }

            $contents=$rcontents;
            
        }
        //var_dump();

        $hash[ "Content" ]=join("",$contents);
        
        return $hash;
    }

    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_Regexp_Text($text,$hash)
    {
        return
            $this->Html_Tags
            (
                "DIV",
                array
                (
                    "Regexp:",
                    "/".
                    $this->Text_Display_Body_Parse_Code_Function_Regexp($text,$hash).
                    "\\s+".
                    $hash[ "Search" ].
                    "/.",
                ),
                array
                (
                    "CLASS" => "Regexp",
                )
            );
    }
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_Function_Regexp($text,$hash)
    {
        $func="";
        if (preg_match('/^py/',$hash[ "Language" ]))
        {
            $func="def";
        }
        elseif (preg_match('/^(javascript|js)$/',$hash[ "Language" ]))
        {
            $func="function";
        }
        elseif (preg_match('/^(php|)$/',$hash[ "Language" ]))
        {
            $func="function";
        }

        return $func;
    }
    
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_Comment_Regexp($text,$hash)
    {
        return "\s*(\/\/|#)";
    }
    
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_Comment_Is($text,$hash,$content)
    {
        $comments=
            $this->Text_Display_Body_Parse_Code_Comment_Regexp($text,$hash);
        
        $res=False;
        if
            (
                preg_match
                (
                    '/^\s*$/',
                    $content
                )
                ||
                preg_match
                (
                    '/'.$comments.'/',
                    $content
                )
            )
        {
            $res=True;
        }

        return $res;
    }

    
    //*
    //*
    //*

    function Text_Display_Body_Parse_Code_File_Comments_Adjust($text,$hash,$contents,&$from,&$to)
    {
        while
            (
                $to>$from
                &&
                $this->Text_Display_Body_Parse_Code_Comment_Is
                (
                    $text,$hash,$contents[$to]
                )
            )
        {
            $to--;
        }
        
        while
            (
                $from>0
                &&
                $this->Text_Display_Body_Parse_Code_Comment_Is
                (
                    $text,$hash,$contents[$from-1]
                )
            )
        {
            $from--;
        }

        //skip leading empty lines
        while
            (
                $from<$to
                &&
                preg_match('/^\s*$/',$contents[$from])
            )
        {
            $from++;
        }
        
        //skip trailing lines
        while
            (
                $from<$to
                &&
                preg_match('/^\s*$/',$contents[$to])
            )
        {
            $to--;
        }
    }
}

?>