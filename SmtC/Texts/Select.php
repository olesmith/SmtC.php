<?php

trait Texts_Select
{    
    //* 
    //* 
    //*

    function Texts_Select($data,$text,$texts,$selected=0)
    {
        if (empty($text[ "ID" ])) {return array(); }
        
        $source_id="Texts_".$data."_".$text[ "ID" ];
        $destination_id="Texts_".$data."_".$text[ "ID" ];

        if ($selected==0) { $selected=$text[ $data ]; }
        
        $names=array();
        $titles=array();
        $values=array();
        $disableds=array();
        
        if (empty($text[ $data ]))
        {
            array_push($names,"");
            array_push($titles,"");
            array_push($values,0);
            array_push($disableds,0);
        }

        $ids=array();
        
        foreach ($texts as $rtext)
        {
            if ($rtext[ "ID" ]==$text[ "ID" ]) { continue; }
            
            if (isset($ids[ $rtext[ "ID" ] ])) { continue; }
            $ids[ $rtext[ "ID" ] ]=True;
            
            array_push($values,$rtext[ "ID" ]);

            $name=$rtext[ "Name" ].": ".$rtext[ "Title" ];            
            $title=$rtext[ "Title" ]." (".$rtext[ "ID" ].")";            
            if ($selected==$rtext[ "ID" ])
            {
                $name="*".$name."*";
            }
            
            array_push($disableds,0);
            array_push($names,$name);
            array_push($titles,$title);

            //var_dump($name);
        }
        
        $url=
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "Dest" => $destination_id,
                    "Action" => "Select",
                )
            );
        
        return
            $this->Htmls_Select
            (
                $data,
                $values,$names,
                $selected,
                //$args=
                array
                (
                    "Titles" => $titles,
                    "Disableds" => $disableds,
                ),
                //$select_options=
                array
                (
                    "ID" => "Texts_Parent_".$text[ "ID" ],
                    "ONCHANGE" => $this->JS_Load_Select
                    (
                        $url,
                        $destination_id,
                        $data,
                        $source_id
                    )
                ),
                //$opt_options=
                array
                (
                )
            );
    }

}

?>