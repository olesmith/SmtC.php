<?php



trait JS_Opacity
{
    ##! 
    ##! 
    ##!  
    
    function JS_Opacity_Toggle($opacity)
    {
        return
            $this->JS_Opacity_Toggle.
            "(".
            "this,".
            $this->JS_Quote($opacity).
            ")";
    }
}
?>