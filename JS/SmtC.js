"use strict";

var  url_start= window.location.search;
var parms_start = new URLSearchParams(url_start);


function Get_Key(parms,key)
{
    let value="0";
    if (parms.has(key))
    {
        value=parms.get(key);
    }
    
    return value;
}

//Store values on load
var App=Get_Key(parms_start,"App");

function Register_URL(url)
{
    Register_Time("Register_URL");
    if (true) { return true; }

    let parms = new URLSearchParams(url);

    let update=false;
    
    let app=Get_Key(parms,"App");
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
