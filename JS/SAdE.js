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

var School=Get_Key(parms_start,"School");
var Period=Get_Key(parms_start,"Period");


function Register_URL(url)
{
    if (true)
    {
        let parms = new URLSearchParams(url);

        let update=false;
        let unit=Get_Key(parms,"Unit");
        let school=Get_Key(parms,"School");
        if (school!=School)
        {
            update=true;
        }
        
        let period=Get_Key(parms,"Period");
        if (period!=Period)
        {
            update=true;
        }
        
        if (update)
        {
            let lurl="?Unit="+unit+"&TOP=1";
            if (school!="0")
            {
                lurl=lurl+"&School="+school;
            }
            if (period!="0")
            {
                lurl=lurl+"&Period="+period;
            }
            
            School=school;
            Period=period;

            console.log(lurl);
            //Load_URL_2_Element_Do("TOP",lurl);
        }
    }
}

function Show_Sponsors(elementid,type,nmax,unit,school=0)
{
    //type: Logo or Banner
    console.log(elementid);
    let parms = new URLSearchParams();

    
    let url=
        "?"+
        "Type="+type+
        "&"+
        "N="+nmax+
        "&"+
        "Unit="+unit+
        "&"+
        "RAW=1"+
        "&"+
        "NoHorMenu=1"+
        "&"+
        "Dest="+elementid+
        "&"+
        "School="+school+
        "&"+
        "ModuleName=Sponsors"+
        "&"+
        "Action=Sponsors";

    
    Load_URL_2_Element_Do(elementid,url);
}
