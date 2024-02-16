"use strict";

//*
//* Get element by ID.
//*

function Element_By_ID(elementid)
{
    if (!elementid) { return; }
    
    let elements = document.querySelectorAll("#"+elementid);

    if (elements.length>0) { return elements[0]; }
    
    return false;
}

//*
//* Children of element conforming to tag/classes.
//*

function Element_Children(element,tag=false,classes=[])
{
    if (!Array.isArray(classes))
    {
        classes=[classes];
    }
    
    let children=element.children;
    if (tag)
    {
        let rchildren=[];
        for (let n=0;n<children.length;n++)
        {
            if (tag === children[n].tagName)
            {
                let include=true;
                for (let m=0;m<classes.length;m++)
                {
                    if (!children[n].classList.contains(classes[m]))
                    {
                        //console.log("dont contain: ",classes[m],children[n].className);
                        include=false;
                        break;
                    }
                }

                if (include)
                {
                    rchildren.push(children[n]);
                }
            }
        }

        children=rchildren;
    }

    return children;
}

//*
//* Tries to detect unique child.
//*

function Element_Child_Unique(element,tag=false,classes=[])
{
    let children=Element_Children(element,tag,classes);

    let child=false;
    if (children.length==0)
    {
        //console.log("No such child",tag,classes);
    }
    else if (children.length>1)
    {
        console.log("Child not unique",tag,classes);

        //first
        child=children[0];
    }
    else
    {
        //found and unique
        child=children[0];
    }

    return child;
}

//*
//* Elements by (single) class
//*

function Elements_By_Class(clss,element=false,tag="",attrs={})
{
    if (!element) { element=document; }

    let pre="#";
    if (tag)
    {
        if (clss)
        {
            pre=tag+".";
        }
        else
        {
            pre=tag;
        }
    }

    return element.querySelectorAll(pre+clss);
}

//*
//* Elements with all classes (intersection).
//*

function Elements_By_Classes(classes,element=false,tag="",attrs={},debug=false)
{
    let elements=Elements_By_Class(classes[0],element,tag,attrs);

    
    if (debug) { console.log("Elements1",elements.length,classes[0],element,tag); }
    for (let n=1;n<classes.length;n++)
    {
        let relements=[];
        for (let m=0;m<elements.length;m++)
        {
            if (elements[m].classList.contains(classes[n]))
            {
                relements.push(elements[m]);
            }
        }
        
        elements=relements;
    }
    
    
    if (debug) { console.log("Elements2",elements.length); }
    return elements;
}
//*
//* Unique element by classes
//*

function Element_By_Classes(classes,element=false,tag="",attrs={})
{
    let elements=Elements_By_Classes(classes,element,tag,attrs,false);
    
    let relement=false;
    if (elements.length==0)
    {
        //console.log("No such element",tag,classes);
    }
    else if (elements.length>1)
    {
        console.log("Element not unique",tag,classes);

        //first
        relement=elements[0];
    }
    else
    {
        //found and unique
        relement=elements[0];
    }

    return relement;
}

//*
//* Mark or update an elements - setting attrs and styles.
//*

function Elements_Mark(elements,attrs,styles={})
{
    let nchanged=0;
    for (let n=0;n<elements.length;n++)
    {
        let changed=Element_Mark(elements[n],attrs,styles);
        if (changed) { nchanged++; }
    }

    return nchanged;
}




//*
//* Mark or update an element - setting attrs and styles.
//*

function Element_Mark(element,attrs,styles={})
{
    let changed=0;
    for (let attr in attrs)
    {
        let value=attrs[ attr ];
        if (value!=element.getAttributeNS("",attr))
        {
            element.setAttributeNS("",attr,value);
            changed++;
        }
    }
    
    for (let style_key in styles)
    {
        let value=styles[ style_key ];

        if (element.style[ style_key ]!=value)
        {
            element.style[ style_key ]=value;
            changed++;
        }
    }

    return changed;
}
