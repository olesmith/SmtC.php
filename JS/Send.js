"use strict";

function String2Hash(text)
{
    text=text.substring(1);
    let comps=text.split("&");

    let hash={};
    for (let n=0;n<comps.length;n++)
    {
        let comp=comps[n].split("=");
        hash[ comp[0] ]=comp[1];
    }

    return hash;
}

function Hash2String(hash,pre="")
{
    let texts=[];
    for (let key in hash)
    {
        texts.push(key+"="+hash[ key ]);
    }
    texts=texts.join("&");

    return pre+texts;
}


function Send_Form_URL(element,url)
{
    Register_Time("Send_Form_URL");

   
    let form_element=element.closest("form");

    let args=String2Hash(url);
    console.log(args);
    for (let key in args)
    {
        let input=document.createElement("input");
        input.name=key;
        input.setAttribute("type", "hidden");
        
        input.value=args[ key ];
        form_element.appendChild(input);
    }

    
    form_element.submit();
}

function Select_Send(element,url,dest_id,cgis=[])
{
    Register_Time("Select");
    
    let rurl=Url2Hash(url);
     
    rurl[ element.name ]=element.value;
    for (let n=0;n<cgis.length;n++)
    {
        let relement=Get_Element_By_ID(cgis[n]);
        if (relement)
        {
            console.log(relement);
            rurl[ relement.name ]=relement.value;
        }
    }
    
    let rrurl=Hash2Get(rurl);
    
    //???let form_element=element.closest("form");
    //var buttons = form_element.getElementById("BUTTON");

    //???console.log(form_element);
     
    Load_URL_2_Element_Do(dest_id,Hash2Get(rurl));
}
