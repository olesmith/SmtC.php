<?php



trait JS_Inputs
{
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic($max,$sumclasses=array(),$inc=-1)
    {
        $rsumclasses="false";
        if (!empty($sumclasses))
        {
            if (!is_array($sumclasses))
            {
                $sumclasses=array($sumclasses);
            }
            
            $rsumclasses=$this->JS_Array($sumclasses);
        }
        
        return
            $this->JS_Input_Cyclic.
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".
            $rsumclasses.
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic_Increasing($max,$inc=1)
    {
         
        return
            $this->JS_Input_Cyclic."_Increasing".
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
    
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic_Increase_Input($element_id,$max,$inc=1)
    {
         
        return
            $this->JS_Input_Cyclic."_Increase_Input".
            "(".             
            $this->JS_Quote
            (
                $element_id
            ).    
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
    
    ##! 
    ##! Cyclicly change input field value.
    ##!  
    
    function JS_Input_Cyclic_Decrease_Input($element_id,$dec=1)
    {
         
        return
            $this->JS_Input_Cyclic."_Decrease_Input".
            "(".             
            $this->JS_Quote
            (
                $element_id
            ).    
            ",".            
            $this->JS_Quote
            (
                $dec
            ).
            ");".
            "";
    }
    
    ##! 
    ##! Load Select field based on other.
    ##!  
    
    function JS_Input_Cyclic_KeyBoard($max,$sumclasses=array(),$inc=-1)
    {        
        $rsumclasses="false";
        if (!empty($sumclasses))
        {
            if (!is_array($sumclasses))
            {
                $sumclasses=array($sumclasses);
            }
            
            $rsumclasses=$this->JS_Array($sumclasses);
        }
        
        return
            $this->JS_Input_Cyclic_KeyBoard.
            "(".            
            "this".
            ",".            
            $this->JS_Quote
            (
                $max
            ).
            ",".
            $rsumclasses.
            ",".            
            $this->JS_Quote
            (
                $inc
            ).
            ");".
            "";
    }
   
    ##! 
    ##! 
    ##!  
    
    function JS_Inputs_Sum_Row($clss,$dest_class,$totals_id="",$percent_class="")
    {
        return
            $this->JS_Inputs_Sum_Row.
            "(".            
            "this".
            ",".
            join
            (
                ",",
                $this->JS_Quotes
                (
                    array
                    (
                        $clss,$dest_class,
                        $totals_id,
                        $percent_class
                    )
                )                
            ).
            ");".
            "";
    }

    
    ##! 
    ##! 
    ##!  
    
    function JS_Input_Copy_To_Elements($dest_elements)
    {
        return
            $this->JS_Input_Copy_To_Elements.
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
    
    function JS_Input_Copy_To_Elements_ByID($src_id,$dest_ids,$cvalue=0)
    {
        return
            $this->JS_Input_Copy_To_Elements_ByID.
            "(".            
            $this->JS_Quote($src_id).
            ",".
            $this->JS_Array($dest_ids).
            ",".
            $cvalue.
             ");".
            "";
    }

    ##! 
    ##! 
    ##!  
    
    function JS_Input_Copy_To_Elements_ByID_If_Empty($src_id,$dest_ids)
    {
        return
            $this->JS_Input_Copy_To_Elements_ByID_If_Empty.
            "(".            
            $this->JS_Quote($src_id).
            ",".
            $this->JS_Array($dest_ids).
            ");".
            "";
    }

    
    ##! 
    ##! 
    ##!  
    
    function JS_Input_Value_Set_Elements_ByID($dest_ids,$value="")
    {
        return
            $this->JS_Input_Value_Set_Elements_ByID.
            "(".            
            $this->JS_Array($dest_ids).
            ",".
            $this->JS_Quote($value).
             ");".
            "";
    }
    
    ##! 
    ##! 
    ##!  
    
    function JS_Input_Value_Set_Element_ByID($dest_id,$value="")
    {
        if (is_array($dest_id))
        {
            $dest_id=join("_",$dest_id);
        }
        
        return
            $this->JS_Input_Value_Set_Element_ByID.
            "(".            
            $this->JS_Quote($dest_id).
            ",".
            $this->JS_Quote($value).
             ");".
            "";
    }
}
?>