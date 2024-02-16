"use strict";


function Array_Copy(array)
{
    let newlist=[];
    for (let n=0;n<array.length;n++)
    {
        newlist.push(array[n]);
    }

    return newlist;
}
