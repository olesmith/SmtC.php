"use strict";

var  url_start= window.location.search;
var parms_start = new URLSearchParams(url_start);

//Store values on load
var App=GET_Key(parms_start,"App");

function Register_URL(url)
{
    Register_Time("Register_URL");
    if (true) { return true; }

    let parms = new URLSearchParams(url);

    let update=false;
    
    let app=GET_Key(parms,"App");
    if (app!=App)
    {
        update=true;
    }
    if (update)
    {
        let lurl="?Mobile=1&TOP=1";
        if (app!="0")
        {
            lurl=lurl+"&App="+app;
        }
        
        console.log(lurl);
        Load_URL_2_Element_Do("TOP",lurl);
    }
}
