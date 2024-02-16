<?php



trait JS_Select
{
    ##! 
    ##! Calls Select_Send
    ##!
        
    function JS_Select_Send($url,$dest_id,$takeids=array())
    {
        if (is_array($url))
        {
            $url="?".$this->CGI_Hash2URI($url);
        }
        
        return
            $this->JS_Select_Send.
            "(".
            "this,".
            $this->JS_Quote($url).
            ",".
            $this->JS_Quote($dest_id).
            ",".
            $this->JS_Array($takeids).
            "\n);".
            "";
    }

    
    ##! 
    ##! 
    ##!  
    
    function JS_Select_Copy_To_Elements($dest_elements)
    {
        return
            $this->JS_Select_Copy_To_Elements.
            "(".            
            "this".
            ",".
            $this->JS_Array($dest_elements).
            ");".
            "";
    }
    
    ##! 
    ##! 
    ##!  
    
    function JS_Select_Update_Register($stat_icon_id,$stat_color,$stat_icon)
    {
        return
            $this->JS_Select_Update_Register.
            "(this,".
            $this->JS_Quote($stat_icon_id).
            ",".
            $this->JS_Quote($stat_color).
            ",".
            $this->JS_Quote($stat_icon).
            ");".  
            "";
    }
    
    ##! 
    ##! 
    ##!  
    
    function JS_Select_Updated_Elements_Send($update_to_id)
    {
        return
            $this->JS_Select_Updated_Elements_Send.
            "(".            
            "this".
            ",".
            $this->JS_Quote($update_to_id).
            ");".
            "";
    }

    
    ##! 
    ##! 
    ##!  
    
    function JS_Selects_Union_Select($new_id,$dest_id,$select_ids,$items_name="entries")
    {
        return
            "Selects_Union_Select".
            "(".
            $this->JS_Quote($new_id).
            ",".
            $this->JS_Quote($dest_id).
            ",".
            $this->JS_Array($select_ids).
            ",".
            $this->JS_Quote($items_name).
            ");";
    }
    ##! 
    ##! 
    ##!  
    
    function JS_Selects_Intersection_Select($new_id,$dest_id,$select_ids,$items_name="entries")
    {
        return
            "Selects_Intersection_Select".
            "(".
            $this->JS_Quote($new_id).
            ",".
            $this->JS_Quote($dest_id).
            ",".
            $this->JS_Array($select_ids).
            ",".
            $this->JS_Quote($items_name).
            ");";
    }
}
?>