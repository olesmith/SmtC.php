<?php

trait Texts_Create
{
    //*
    //* 
    //*

    function Text_Create_Child_Handle($text=array())
    {
        if (empty($text)) { $text=$this->ItemHash; }

        
        $this->Htmls_Echo
        (
            $this->Text_Child_Create_Form($text)
        );
    }

    //*
    //* 
    //*

    function Text_Child_Create_Form($text)
    {
        if ($this->CGI_POSTint("Create")==1)
        {
            $create=True;

            $new_text=
                $this->Text_Create_Child_New($text);
            foreach ($this->ItemData as $data => $def)
            {
                if (!empty($this->ItemData[ $data ][ "Compulsory" ]))
                {
                    if (empty($new_text[ $data ]))
                    {
                        $create=False;
                    }
                }
            }
            
            if ($create)
            {
                $this->CGI_Trim_Hash($new_text);
                //var_dump("insert",$new_text);
                $this->Sql_Insert_Item
                (
                    $new_text
                );

                $id="ID_".time();//random/unique
                $dest=$this->CGI_GET("PDest");;
        
                $this->Htmls_Echo
                (
                    array
                    (
                        $this->Htmls_DIV
                        (
                            "".
                            "Click_Above('".$id."','".$dest."','".$text[ "ID" ]."');",
                            array
                            (
                                "ID" => $id,
                            )
                        ),
                        $this->Htmls_SCRIPT
                        (
                            array
                            (
                                "Click_Above('".$id."','".$dest."','".$text[ "ID" ]."');",
                            )
                        )
                    )
                );
                exit();
            }
        }
        

        $this->ItemDataGroups();

        //Rerunning as singular?
        $this->Datas_Included=array();

        $h=2;
        return
            $this->Htmls_Form
            (
                1,
                "Weeklies",
                "",

                //$contents=
                array
                (
                    $this->Htmls_H
                    (
                        $h++,
                        array
                        (
                            $create_msg=
                            $this->MyLanguage_GetMessage("Create"),
                            $this->MyMod_ItemName(),
                        )
                    ),
                    $this->MyMod_Item_Group_Table_HTML
                    (
                        1,
                        "Basic",
                        $this->Text_Create_Child_New($text)
                    ),
                ),

                //$args=
                array
                (
                    "Buttons" => $this->Buttons($create_msg),
                    "Hiddens" => array
                    (
                        "Create" => 1,
                    )
                )
            );
    }

    //*
    //* 
    //*

    function Text_Create_Child_New($text)
    {
        $new_text=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (empty($new_text[ $data ]))
            {
                //Take from CGI (POST)
                $value=$this->CGI_POST($data);

                if (!empty($value))
                {
                    $new_text[ $data ]=$value;
                }
            }

            if ($data=="Type" && empty($new_text[ $data ]))
            {
                if (!empty($this->ItemData[ $data ][ "Nexts" ][ $text[ $data ] ]))
                {
                    $new_text[ $data ]=
                        $this->ItemData[ $data ][ "Nexts" ][ $text[ $data ] ];
                }
            }

            if (empty($new_text[ $data ]))
            {
                //Take from $text
                if
                    (
                        !preg_match('/^(ID)$/',$data)
                        &&
                        empty($new_text[ $data ])
                    )
                {
                    $new_text[ $data ]=$text[ $data ];
                }
                
                //Take from Default
                if
                    (
                        !empty($this->ItemData[ $data ][ "Default" ])
                        &&
                        empty($new_text[ $data ])
                    )
                {
                    $new_text[ $data ]=$this->ItemData[ $data ][ "Default" ];
                }
            }
        }
        

        return
            array_merge
            (
                $new_text,
                array
                (
                    "Parent"    => $text[ "ID" ],
                    "Friend"    => $text[ "Friend" ],
                )
            );
    }
}

?>