<?php

include_once("Parse/Image.php");
include_once("Parse/Code.php");
include_once("Parse/Link.php");
include_once("Parse/File.php");
include_once("Parse/Exec.php");

trait Texts_Display_Body_Parse
{
    use
        Texts_Display_Body_Parse_Image,
        Texts_Display_Body_Parse_Code,
        Texts_Display_Body_Parse_Link,
        Texts_Display_Body_Parse_File,
        Texts_Display_Body_Parse_Exec;
    
    //*
    //*
    //*

    function Text_Display_Body_Parse($text,$key="Body")
    {
        $text[ $key ]=html_entity_decode($text[ $key ]);
        //$text[ $key ]=preg_replace('/#039;/'," ",$text[ $key ]);
        
        $lines=preg_split('/\n+/',$text[ $key ]);
        for ($n=0;$n<count($lines);$n++)
        {
            if (preg_match('/\@/',$lines[$n]))
            {
                $lines[$n]=
                    $this->Text_Display_Body_Parse_Line($text,$lines[$n]);
            }
            elseif (preg_match('/^\s+$/',$lines[$n]))
            {
                $lines[$n]="<BR><BR>";
            }
            else
            {
                $lines[$n]=
                    preg_replace
                    (
                        '/\s/',
                        "&nbsp;&nbsp;&nbsp;",
                        $lines[$n]

                    );
            }

            $lines[$n]=
                $this->Text_Display_Body_Parse_Tex_Commands($text,$lines[$n]);
        }

        return
            join
            (
                "",
                $lines
            );
    }

    //*
    //* Branch, depending on @$component{}{}...{}
    //*

    function Text_Display_Body_Parse_Tex_Commands($text,$line)
    {
        $command="Vector";
        $rcomand_pre="\\underline{\\mathbf{";
        $rcomand_post="}}";

        $regexp="\\\\".$command."\{([A-Za-z0-9]*)\}";
        while (preg_match('/'.$regexp.'/',$line,$matches))
        {
            $line=
                preg_replace(
                    '/'.$regexp.'/',
                    $rcomand_pre.$matches[1].$rcomand_post,
                    $line,
                    1 //only one
                );
        }
        
        $command="Matrix";
        $rcomand_pre="\\underline{\\underline{\\mathbf{";
        $rcomand_post="}}}";

        $regexp="\\\\".$command."\{([A-Za-z0-9]*)\}";
        while (preg_match('/'.$regexp.'/',$line,$matches))
        {
            $line=
                preg_replace(
                    '/'.$regexp.'/',
                    $rcomand_pre.$matches[1].$rcomand_post,
                    $line,
                    1 //only one
                );
        }

        return $line;
    }
    
    //*
    //* Branch, depending on @$component{}{}...{}
    //*

    function Text_Display_Body_Parse_Line($text,$line)
    {
        if (!preg_match('/\@\S+/',$line)) { return $line; }

        //Remove leading and trailing whitespace
        $line=preg_replace('/^\s/',"",$line);
        $line=preg_replace('/\s+$/',"",$line);
        
        $pre="";

        //Anything before \@...
        if (preg_match('/^([^\@]+)\@(.*)/',$line,$matches))
        {
            $pre=$matches[1];
            $line=$matches[2];

            var_dump($matches);
        }

        $command="--";
        if (preg_match('/^\@([a-z0-9_]+)(.*)/i',$line,$matches))
        {
            $command=$matches[1];
            $line=preg_replace('/^\s+/',"",$matches[2]);

        }


        $args=array();
        
        $max=10;
        $n=0;
        while ($n++<=$max)
        {
            //Arguments embraced by {..}
            if (preg_match('/^\{([^\{\}]*)\}(.*)/',$line,$matches))
            {
                array_push($args,$matches[1]);
                $line=preg_replace('/^\s+/',"",$matches[2]);
            }
        }

        return
            $pre.
            $this->Text_Display_Body_Parse_Command($text,$command,$args).
            $line.
            "";
    }
    
    
    //*
    //* Branch, depending on @$component{}{}...{}
    //*

    function Text_Display_Body_Parse_Command($text,$command,$args)
    {
        $output="";
        $res=0;
        if (preg_match('/Ima?ge?/i',$command))
        {
            $res=1;
            $output=
                $this->Text_Display_Body_Parse_Image($text,$args);
        }
        elseif (preg_match('/Code/i',$command))
        {
            $res=2;
            $output=
                $this->Text_Display_Body_Parse_Code($text,$args);
        }
        elseif (preg_match('/Link/i',$command))
        {
            $res=3;
            $output=
                $this->Text_Display_Body_Parse_Link($text,$args);
        }

        //var_dump($command,$res,$output);
        
        return $output;
    }
}

?>