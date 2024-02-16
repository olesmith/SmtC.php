"use strict";



function Clip_Board_Copy_URL(url)
{
    Register_Time("Clip_Board_Copy_URL");
    try
    {
        navigator.clipboard.writeText(url);
        console.log('Page URL copied to clipboard',url);
    }
    catch (err)
    {
        console.warn('Failed to copy: ', err,url);
    }
    
    //document.navigator.clipboard);
    //document.navigator.clipboard.writeText(url);
}
