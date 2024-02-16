<?php



trait JS_Copy
{
    ##! 
    ##! Copy elements URL to clipboard.
    ##!  
    
    function JS_Copy_To($src_id,$dest_id)
    {        
        return
            $this->JS_Copy_To.
            "(".
            $this->JS_Quote($src_id).
            ",".
            $this->JS_Quote($dest_id).
            ");".
            "";
    }
    
    ##! 
    ##! Copy elements URL to clipboard.
    ##!  
    
    function JS_Copy_InnerHtml($src_id,$dest_id,$create_tag="li")
    {
        if (is_array($src_id))
        {
            $src_id=join("_",$src_id);
        }
        
        if (is_array($dest_id))
        {
            $dest_id=join("_",$dest_id);
        }
        
        return
            $this->JS_Copy_InnerHtml.
            "(".
            $this->JS_Quote($src_id).
            ",".
            $this->JS_Quote($dest_id).
            ",".
            $this->JS_Quote($create_tag).
            ");".
            "";
    }
}
?>