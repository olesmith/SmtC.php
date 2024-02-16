<?php

trait App_CLI_Messages_Language
{

    function MyApp_CLI_Messages_Language($args)
    {
        if
            (
                count($args)<3
                ||
                !preg_match('/Language/i',$args[1])
            )
        {
            print "Omitting Language_Messages_CLI\n";
            return;
        }

        $language=$args[2];
        
        $nstart=$this->LanguagesObj()->Sql_Select_NHashes();
        print "MyApp Messages CLI: ".$nstart."\n";

        var_dump($nstart,$language);

}
