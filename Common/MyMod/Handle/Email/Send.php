<?php

trait MyMod_Handle_Email_Send
{
    //*
    //* function MyMod_Handle_Emails_Send, Parameter list: 
    //*
    //* Do actual sending.
    //*

    function MyMod_Handle_Emails_Send($printables_obj=True,$item=array())
    {
        //$this->ApplicationObj->DebugMail=TRUE;
        $clean=True;
        $this->NAttachments=$this->MyMod_Handle_Email_Attachments_CGI_N_Value();

        $files=array();
        for ($n=1;$n<=$this->NAttachments;$n++)
        {
            $file=
                sys_get_temp_dir().
                "/".
                $this->MyMod_Handle_Email_Attachments_CGI_No_Value($n);

            if (file_exists($file))
            {
                $file=array
                (
                   "File" => $file,
                   "Name" => $this->CGI_POST("File_".$n),
                   "MIME" => $this->CGI_POST("MIME_".$n),
                );

                array_push($files,$file);
            }
        }
        
        $files=
            array_merge
            (
                $files,
                $this->MyMod_Handle_Emails_Printables_Generate
                (
                    $item,$printables_obj
                )
            );
        
        

        $mailinfo=$this->ApplicationObj->MyApp_Mail_Info_Get();
        foreach (array("FromEmail","FromName") as $data)
        {
            $mailhash[ $data ]=$mailinfo[ $data ];
        }

        $mailhash[ "ReplyTo" ]=$this->LoginData[ "Email" ];

        $remails=
            $this->MyMod_Handle_Emails_Read($item);            

        $tos=
            $this->MyMod_Handle_Emails_Send_Tos($item);
        
        
        if (count($tos)>0)
        {
            $subject=$this->CGI_POST("Subject");
            $subject=preg_replace('/^\s+/',"",$subject);
            $subject=preg_replace('/\s+$/',"",$subject);
            $subject=preg_replace('/\s+/'," ",$subject);

            if (preg_match('/\S/',$subject))
            {
                $body=$this->CGI_POST("Body");
                $body=preg_replace('/^\s+/',"",$body);
                $body=preg_replace('/\s+$/',"",$body);
                $body=preg_replace('/\s+/'," ",$body);

                if (preg_match('/\S/',$body))
                {                
                    $mailhash=array
                    (
                       "To" => $tos,
                       "FromEmail" => $mailinfo[ "FromEmail" ],
                       "FromName" => $this->ApplicationObj()->MyApp_Setup_Application_Get_Title(),
                       "CC" => array(),
                       "BCC" => $this->MyMod_Handle_Emails_Send_BCCs($mailinfo),
                       "ReplyTo" => $this->ApplicationObj->LoginData[ "Email" ],
                       "Subject" => $this->CGI_POST("Subject"),
                       "Body" => preg_replace
                       (
                           '/&amp;/',
                           "&",
                           $this->CGI_POST("Body")
                       ),
                       "AltBody" => $this->CGI_POST("Body"),
                    );

                    $res=
                        $this->ApplicationObj->MyApp_Email_Send
                        (
                            array(),
                            $mailhash,
                            array(),
                            $files
                        );
                    
                    foreach ($files as $file)
                    {
                        if ($clean && file_exists($file[ "File" ]))
                        {
                            unlink($file[ "File" ]);
                        }
                    }

                    return $res;
                }
                else
                {
                    $this->ApplicationObj->EmailStatusMessage=
                        "Mensagem sem corpo - mensagem não enviada";
                    $this->ApplicationObj->EmailStatus=FALSE;  
                }
            }
            else
            {
                $this->ApplicationObj->EmailStatusMessage=
                    "Mensagem sem assunto - mensagem não enviada";
                $this->ApplicationObj->EmailStatus=FALSE;  
            }

        }
        else
        {
            $this->ApplicationObj->EmailStatusMessage=
                "Nenhum Recipiente - mensagem não enviada";
            $this->ApplicationObj->EmailStatus=FALSE;  
        }

        echo
            $this->ApplicationObj->EmailStatusMessage().
            "////";

        return False;
    }

    //*
    //* Detects the recipients to send to.
    //*

    function MyMod_Handle_Emails_Send_Tos($item)
    {
        $emails=
            $this->MyMod_Handle_Emails_Read($item);
        
        $tos=array();
        foreach (array_keys($emails) as $typekey)
        {
            foreach ($emails[ $typekey ] as $email)
            {
                if
                    (
                        $this->CGI_POSTint("Inc_".$email[ "ID" ])==1
                        ||
                        $this->CGI_POSTint("Inc_All")==1
                    )
                {
                    array_push($tos,strtolower($email[ "Email" ]));
                }
            }
        }
        
        $friendkey="Friend";
        if ($this->MyMod_Handle_Email_To_Input_Field())
        {
            $ttos=
                $this->CGI_POST("To");
            if (!empty($ttos))
            {
                $ttos=preg_split('/[\s;,]+/',$ttos);
                foreach ($ttos as $to)
                {
                    if ($this->IsValidMailAddress($to))
                    {
                        array_push($tos,$to);
                    }
                }
            }
        }

        return $tos;
    }
    
    //*
    //* Detects the recipients to bcc.
    //*

    function MyMod_Handle_Emails_Send_BCCs($mailinfo)
    {
        $bccs=array();
        array_push($bccs,$this->ApplicationObj->LoginData[ "Email" ]);
        foreach (array("AdmEmail","BCCEmail") as $key)
        {
            if (!empty($mailinfo[ $key ]))
            {
                array_push($bccs,$mailinfo[ $key ]);
            }
        }

        return $bccs;
    }
    
}

?>