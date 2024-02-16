"use strict";


function GET_Key(parms,key)
{
    let value="0";
    if (parms.has(key))
    {
        value=parms.get(key);
    }
    
    return value;
}

function GET2Hash(key=false)
{
    let url=window.location.search.substr(1);
    let comps=url.split("&");

    let hash={};
    for (let n=0;n<comps.length;n++)
    {
        let comp=comps[n].split("=");
        hash[ comp[0] ]=comp[1];
    }

    if (key)
    {
        return hash[ key ];
    }

    return hash;
}

function Hash2Get(hash)
{
    let keys=[];
    for (let key in hash)
    {
        keys.push(key+"="+hash[ key ]);
    }

    return "?"+keys.join("&");
}

function Url2Hash(url)
{
    let comps=url.split("?");
    comps=comps[1].split("&");
    
    let hash={};
    for (let n=0;n<comps.length;n++)
    {
        let comp=comps[n].split("=");
        hash[ comp[0] ]=comp[1];
    }

    return hash;
}


