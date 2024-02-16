<?php

trait Texts_Import_HTML_Read
{
    //*
    //* 
    //*

    function Text_Import_HTML_Read_Files($text)
    {
        $keys=
            array("Name","Title","Contents");
        
        $html_hash=array();
        foreach ($keys as $key)
        {
            $file=$text[ "Src" ]."/".$key.".html";

            
            if (!file_exists($file))
            {           
                print $file.": Non existent\n";
            }
            else
            {
                //$html_hash[ $key ]=$file;
               $html_hash[ $key ]=
                    join
                    (
                        "",
                        $this->MyFile_Read($file)
                    );
                
                if ( preg_match('/^(Name|Title)/',$key) )
                {
                    $html_hash[ $key ]=strip_tags($html_hash[ $key ]);
                }
                else
                {
                    $html_hash[ $key ]=preg_replace('/\'/',"",$html_hash[ $key ]);
                }
            }
        }

        $this->Text_Import_HTML_Read_Contents_Rewrite($text,$html_hash);
        return $html_hash;
    }

    
    //*
    //* 
    //*

    function Text_Import_HTML_Read_Contents_Rewrite($text,$html_hash)
    {
        return;
        $key="Contents";
        
        libxml_use_internal_errors(true);
        //$doc = new DOMDocument();

        $html=$html_hash[ $key ].
            "";


        // $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->Htmls_Parse($html);
        

        /* foreach ($doc->childNodes as $child) */
        /* { */
        /*     foreach ($child->childNodes as $rchild) */
        /*     { */
                
        /*         var_dump($rchild); */
        /*     } */
        /* } */
        /* $n=0; */
        /* foreach ($doc->getElementsByTagName('ol') as $list) */
        /* { */
        /*     $n++; */
            
        /*     $m=0; */
        /*     $items=array(); */
        /*     foreach ($list->getElementsByTagName('li') as $item) */
        /*     { */
        /*         array_push($items,trim($item->nodeValue)); */
        /*         //$list->removeChild($item); */
        /*     } */

        /*     //var_dump($items); */
        /* } */

        $n=0;
        if ($n>0)
        {
            //print $doc->saveHTML();
            exit();
        }
    }
}

?>