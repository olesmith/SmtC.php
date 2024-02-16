"use strict";



function Click_Element_By_ID(elementid)
{
    Register_Time("Click_Element_By_ID");

    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        element.click();
    }
    else
    {
        console.log("Click_Element_By_ID: No such element: "+elementid);
    }
}

function Click_Elements_By_ID(elementids,checkstub=false)
{    
    for (let n=0;n<elementids.length;n++)
    {
        if (checkstub)
        {
            let checkbox_id=checkstub
        }
        Click_Element_By_ID(elementids[ n ])
    }
}


function Click_Elements_By_Class(classid)
{
    if (Array.isArray(classid))
    {
        classid=classid.join(" ");
    }
    
    let elements = document.getElementsByClassName(classid);    
    for (let n=0;n<elements.length;n++)
    {
        elements[n].click();
    }
}


function Click_Elements_By_Checked_IDs(element_ids,check_ids)
{
    for (let n=0;n<element_ids.length;n++)
    {
        let check_id=check_ids[n];

        let check_element=Get_Element_By_ID(check_id);

        if (check_element.checked)
        {
            Click_Element_By_ID(element_ids[ n ]);
        }
    }
}

function Click_Parent_Element_By_Class(element_id,clss,ignore_first=0,debug=false)
{    
    let element=document.getElementById(element_id);
 
    if (debug) { console.log("START",element_id); }

    for (let level=0;level<ignore_first;level++)
    {
        if (element)
        {
            element=element.parentNode;
        }
    }
    
    let clicked=false;
    while (element && !clicked)
    {
        let elements=element.getElementsByClassName("Reload");
        
        let n=elements.length-1;
            
        if (elements.length>0)
        {
            if (debug) { console.log("FOUND!",element.tagName,elements[n]); }
            //found! Click it!
            elements[n].click();
            clicked=true;
        }
        else
        {
            element=element.parentNode;
            if (element)
            {
                if (debug) { console.log(element.tagName); }
            }
        }
    }

    if (!clicked)
    {
        console.log("Not found");
    }
}
//function criar() {
//let a = document.createElement('a')
//a.setAttribute('href', '#link')
//document.body.appendChild(a)
//a.click()
//a.innerHTML = 'aaaaa'


function Click_Above(click_id,db_id=0)
{
    console.clear();

    //let element=Get_Element_By_ID(element_id);
    //console.log(element,db_id);
    //let elements = document.getElementsByClassName("Reload_DIV");

    let reload_id="Reload_"+click_id;

    let reload_div_icon=Get_Element_By_ID(reload_id);
    if (reload_div_icon)
    {
        let reload_icon=reload_div_icon.getElementsByClassName("Reload");
        if (reload_icon.length>0)
        {
            let click=reload_icon[0];
            
            let onclick=click.getAttribute('onclick');
            let onclick_old=onclick;

            //Add include ID GET arg arg (handler may open this item, if appropriate)
            if (db_id>0)
            {
                //Remove old ID, if present
                onclick=onclick.replace('?Include_ID=\d+&?',"",onclick);

                //Insert current ID
                onclick=onclick.replace('?',"?Include_ID="+db_id+"&");
                //console.log(1,onclick);
            
                click.setAttribute('onclick',onclick);
            }
            
            click.click();
            click.style.color="red";

            //Reset onclick attr
            if (db_id>0)
            {
                click.setAttribute('onclick',onclick_old);

            }

            //console.log("Reload",onclick,onclick_old);
        }
        else
        {
            console.log("Click_Above: Reload not in div",reload_id);
        }
    }
    else
    {
        console.log("Click_Above: Reload icon not found",reload_id);
    }
    console.clear();
}
