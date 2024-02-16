"use strict";

function Color_Element(element,newcolor)
{
    element.style.color = newcolor;
}

function Color_Elements(elements,newcolor)
{
    for (let n=0;n<elements.length;n++)
    {
        elements[n].style.color = newcolor;
    }
}

function Color_Element_By_ID(elementid,newcolor)
{
    let element = document.getElementById(elementid);
    if (element)
    {
        Color_Element(element,newcolor);
    }    
}

function Color_Elements_By_Classes(classid,newcolor)
{
    let elements = document.getElementsByClassName(classid);
    for (let n = 0; n < elements.length; n++)
    {
        Color_Element(elements[n],newcolor);
    }    
}


function Color_SVG_Element(element,newcolor)
{
    let fill= element.getAttributeNS(null,"fill");
    if (fill && fill!='none')
    {    
        element.setAttributeNS(null,"fill",newcolor);
    }
    
    element.setAttributeNS(null,"stroke",newcolor);
}


function Color_SVG_Elements_By_Classes(classid,newcolor)
{
    let elements = document.getElementsByClassName(classid);
    for (let n = 0; n < elements.length; n++)
    {
        Color_SVG_Element(elements[n],newcolor);
    }    
}
