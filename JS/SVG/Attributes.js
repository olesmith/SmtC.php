"use strict";


class MySVG_Attributes extends MySVG_Create
{
    //
    // Call setAttributeNS fro attributes.
    //


    SVG_Attributes_Set(svg_element,attrs={})
    {
        for (let key in attrs)
        {
            let value=attrs[key ];

            let namespace=null;
            if (key ==="xlink:href")
            {
                namespace='http://www.w3.org/1999/xlink';
            }
            
            svg_element.setAttributeNS(namespace,key,value);
        }
    }
}
