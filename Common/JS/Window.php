<?php



trait JS_Window
{ 
    ##! 
    ##! 
    ##!
        
    function Hash_2_String($hash,$glue="&",$pre="")
    {
        if (!is_array($hash)) { return $hash; }

        $strings=array();
        foreach ($hash as $key => $value)
        {
            array_push($strings,$key."=".$value);
        }

        return $pre.join($strings,$glue);
    }
    
    ##! 
    ##! 
    ##!
        
    function JS_Window_Popup($url,$target,$args="popup=1")
    {
        return
            $this->JS_Function_Call
            (
                $this->JS_Window_Popup,
                array
                (
                    "this",
                    $this->Hash_2_String($url,"&","?"),
                    $target,
                    $this->Hash_2_String($args,",")
                )
            );
    }
}
?>