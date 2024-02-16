<?php


trait DB_Web_Services_Curl
{
    
    //*
    //* Generates query.
    //* 
    //* 

    function DB_Web_Services_Curl_Url($where=array(),$limit=-1,$page=1)
    {
        $url=
            join
            (
                "/",
                $this->DB_Web_Services_Curl_Urls()
            );

        if ($this->DB_Web_Services_Paging())
        {
            if ($limit>=0)
            {
                $where=
                    $this->DB_Web_Services_Where_Assoc_List
                    (
                        $where,
                        $limit,
                        $page
                    );
            }
        }
                
        if (is_array($where))
        {
            $where=http_build_query($where);
        }

        if (!empty($where))
        {
            $url.=
                "?".
                $where;
        }
        
        return $url;
     }
    
    //*
    //* List of URL path components.
    //* 
    //* 

    function DB_Web_Services_Curl_Urls()
    {
        $urls=
            preg_grep
            (
                '/\S/',
                array
                (
                    $this->DBHash("Host"),
                    $this->DBHash("Path"),
                    $this->DBHash("Pre"),
                    $this->DBHash("Version"),
                )
            );
        
        $key='Siga_API_Post';
        $post=$this->SigaZ()->SigaA_Args($key);

        //$post=$this->DBHash("Post");
        if (!empty($post)) { array_push($urls,$post); }

        return $urls;
    }

    
    //*
    //* 
    //* 

    function DB_Web_Services_Curl_Run($url,$args)
    {
        $this->Last_Content=
            $this->Curl_Run
            (
                $url,
                $args,
                False
            );

        return
            json_decode
            (                
                $this->Last_Content,
                True
            );
    }
    
    //*
    //* 
    //* 

    function DB_Web_Services_Curl_Query($query,$options,$method="POST")
    {
        if ($method!="POST")
        {
            //print $method."**********\n\n";
            
            //var_dump($options);
            //exit();
        }

        //var_dump($query);
        $result=
            $this->Curl_Do
            (
                $query,$options
            );
        
        if (empty($result))
        {
            echo "Result empty";
            var_dump($this->DB_Web_Services_Curl_Url($query));
            return array();
        }

        $this->Last_Content=$result;
        
        $json=json_decode($result,TRUE);

        if (!is_array($json))
        {            
            echo
                "Result not JSON, result:\n".
                $result.
                "\n".
                $this->DB_Web_Services_Curl_Url($query).
                "\n";

            //$this->CallStack_Show();
            return array();
        }

        array_push($this->JSONs,$json);
        
        if (!empty($json[ "status" ]) || !empty($json[ "code" ]))
        {
             echo
                 "Invalid result:\n".
                 $result.
                 "\n".
                 $this->DB_Web_Services_Curl_Url($query).
                 "\n";

             //var_dump($this->DB_Web_Services_Curl_Url($query));
             var_dump($json);
             //exit();
             return array();           
        }

        //var_dump($json);
        return $json;
    }

    
}

?>