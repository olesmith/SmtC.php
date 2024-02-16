"use strict";


//Not OO!!!

//
// Hightlight curves for list of svg_ids
//

function SVGs_Mark(p,release=false)
{
    let svg_ids=Curve_SVG_IDs(Setup);

    for (let n=0;n<svg_ids.length;n++)
    {
        SVG_Mark(svg_ids[n],p,release);
    }
}

//
// Hightlight curve components corresponding to parameter p (0,1,2,...)
// in svg_id.
//

function SVG_Mark(svg_id,p,release=false)
{
    let svg=Element_By_ID(svg_id);
    if (svg)
    {
        let gs=Elements_By_Classes(["Parameter","P_"+p],svg,"g");
        for (let n=0;n<gs.length;n++)
        {
            SVG_G_Mark_Opacity(gs[n],release);
            let gss=Element_Children(gs[n],"g");

            for (let m=0;m<gss.length;m++)
            {
                let gsss=Element_Children(gss[m],"g");
                
                for (let l=0;l<gsss.length;l++)
                {
                    SVG_G_Mark_Stroke(gsss[l],release);
                }
            }
            
        }
    }
    else
    {
        console.log("No such SVG, ID",svg_id);
    }
}


//
// Hightlight curve. Curve in element g.
// Called when click internally on a curve within SVG.
//

function SVG_Gs_Mark(g,release=false)
{
    //Tracwe upwards from g element, untill P atribute 
    let n=0;
    let gparent=g.parentElement;
    while (n<5)
    {
        n++;
        if (gparent.hasAttributeNS("","P"))
        {
            break;
        }
        
        gparent=gparent.parentElement;
    }

    let p=gparent.getAttributeNS("","P");
    if (g.tagName!='g') { g=g.parentElement; }

    let svg_ids=Curve_SVG_IDs(Setup);

    for (let n=0;n<svg_ids.length;n++)
    {
        SVG_Mark(svg_ids[n],p,release);
    }
}


//
// Hightlight curve. Curve in element g.
//

function SVG_G_Mark_Stroke(g,release=false)
{
    let stroke='white';
    if (release)
    {
        stroke=g.getAttributeNS("",'stroke_orig');
    }
    else
    {
        g.setAttributeNS
        (
            "",'stroke_orig',
            g.getAttributeNS("",'stroke')
        );
    }

    //for text tags to work
    if (g.getAttributeNS("",'fill'))
    {
        g.setAttributeNS("",'fill',stroke);
    }

    g.setAttributeNS("",'stroke',stroke);
}

//
// Hightlight curve. Curve in element g.
//

function SVG_G_Mark_Opacity(g,release=false)
{
    let opacity=1;
    if (release)
    {
        opacity=
            g.getAttributeNS
            (
                "",'opacity_orig'
            );
    }
    else
    {
        
        g.setAttributeNS
        (
            "",'opacity_orig',
            g.style.opacity
        );
    }

    g.style.opacity=opacity;
    //console.log(g,release);
}
