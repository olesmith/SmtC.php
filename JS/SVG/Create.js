"use strict";


class MySVG_Create
{
    //
    // Create svg tag (using createElementNS) and set attributes.
    //

    SVG_Create(tag,attrs={},text=false)
    {
        let svg=document.createElementNS("http://www.w3.org/2000/svg", tag);

        let attr="";
        
        //Parse classes as list, if it is a list (object).
        //Pad with space ( )
        
        attr="class";
        if (attrs[ attr ] && typeof attrs[ attr ] === "object")
        {
            attrs[ attr ]=attrs[ attr ].join(" ");
        }
        
        //Parse id as list, if it is a list (object).
        //Pad with _
        
        attr="id";
        if (attrs[ attr ] && typeof attrs[ attr ] === "object")
        {
            attrs[ attr ]=attrs[ attr ].join("_");
        }
        
        //Parse style as hash, if it is a hash (object).
        //Style: key: value;
        
        attr="style";
        if (attrs[ attr ] && typeof attrs[ attr ] === "object")
        {
            let styles=[];
            for (let key in attrs[ attr ])
            {
                styles.push( key+": "+attrs[ attr ][ key ]+";");
            }
            attrs.style=styles.join("\n");
        }
        
        this.SVG_Attributes_Set(svg,attrs);

        if (text)
        {
            svg.innerHTML=text;
        }

        //svg.style.zIndex="1";
        //svg.style.position="relative";
        
        return svg;
    }
}
