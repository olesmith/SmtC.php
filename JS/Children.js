"use strict";

//
// Just creates element - doesn't add to DOM.
//


function Children_Create(ctag,tag,htmls,attrs={},styles={})
{
    let child=document.createElement(ctag);

    for (let n=0;n<htmls.length;n++)
    {
        let child_n=Child_Create
        (
            tag,
            "",
            attrs,styles
        );
                
        child_n.append(htmls[n]);
        
        child.append(child_n);
    }

    return child;
}

//
// Just creates element - doesn't add to DOM.
//


function Child_Create(tag,html="",attrs={},style={})
{
    let child=document.createElement(tag);
    child.innerHTML=html;
    
    Element_Set_Attributes(child,attrs);
    Element_Set_Style(child,style);

    return child;
}


//
// Set element attributes
//


function Element_Set_Attributes(element,attrs)
{
    for (let key in attrs)
    {
        let value=attrs[ key ];
        element.setAttribute(key,value);
    }
}

//
// Set child style
//


function Element_Set_Style(element,style)
{
    for (let key in style)
    {
        element.style[ key ]=style[ key ];
    }
}

// Create element and add to DOM.
//


function Child_Add(parent,tag,html,attrs={},styles={})
{
    let child=Child_Create(tag,html,attrs,styles);

    parent.append(child);
}
