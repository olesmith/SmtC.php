<?php

trait MyApp_CLI_Language
{

    function MyApp_CLI_Language_Process($args)
    {
        if
            (
                count($args)<2
            )
        {
            print "Omitting MyApp_CLI_Language_Process\n";
            print "Language src=UK dest=DK\n";
            return;
        }
        elseif (count($args)>1)
        {        
            if (!preg_match('/Language/i',$args[1]))
            {
                print "Omitting MyApp_CLI_Language_Process\n";
                print "Language src=UK dest=DK\n";
                return;
            }
        }

        $src_language=$args[2];
        $dest_language=$args[3];
        
        $n=0;
        $nn=0;
        
        foreach
            (
                $this->LanguagesObj()->Sql_Select_Unique_Col_Values
                (
                    "ID"
                )
                as $id
            )
        {
            $n++;
            $message=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    array("ID" => $id)
                );

            $oldmessage=$message;
            
            $updatedatas=array();
            foreach (array("Name","Title","ShortName") as $data)
            {
                $src_key =$data."_".$src_language;
                $dest_key=$data."_".$dest_language;

                if (empty($message[ $dest_key ]))
                {
                    if (!empty($message[ $src_key ]))
                    {
                        $message[ $dest_key ]=$message[ $src_key ];
                        array_push($updatedatas,$dest_key);
                    }
                }
                else
                {
                    $text=
                        preg_replace
                        (
                            '/ItemName_'.$src_language.'/',
                            "ItemName_".$dest_language,
                            $message[ $dest_key ]
                        );

                    if ($message[ $dest_key ]!=$text)
                    {
                        print
                            $message[ $dest_key ].
                            " --> ".
                            $text.
                            "\n";
                        $message[ $dest_key ]=$text;
                        array_push($updatedatas,$dest_key);
                    }
                }
            }
            
            if (count($updatedatas)>0)
            {
                $nn++;
                echo
                    join
                    (
                        ", ",$updatedatas
                    )."\n";
            
                $this->LanguagesObj()->Sql_Update_Item_Values_Set
                (
                    $updatedatas,$message
                );
            }
        }

        print
            $src_language.
            " -> ".
            $dest_language.
            ": ".
            $n.
            " messagages, ".
            $nn.
            " updated\n";
    }

}
