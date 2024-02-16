"use strict";



//*
//* Draws osculating initial circle.
//*

function Curve_Osculating_Initial_Add(svg,g,setup,curve,p)
{    
    let options=Curve_SVG_G_Options(setup,"Osculating","Curve");
        
    options[ "class" ]="Node Osculating";
    options[ "fill" ]="none";
    
    let p_c=curve[ "Evolute" ][0];
    let p_rho=curve[ "rho" ][0];

    let rho=Math.abs(p_rho[1]);
    
    let gc=svg.SVG_Create('g',options);
    svg.SVG_Add_Circle
    (
        gc,
        p_c,
        rho,
        {"fill": 'none'}//setup[ "Curve" ][ "Osculating" ][ "Options" ]
    );

    g.append(gc);
}

//*
//* Moves center of current osculating circle to
//* current evolute point and changes radius to rho-value.
//*


function Curve_Osculating_Animate(g,p,comp,N,debug=true)
{
    //Osculating circle to move in the G
    let osc_g=Curve_Animated_Point_Element
    (
        g,p,comp,N
    );
    
    if (osc_g && osc_g.children.length>0)
    {
        let osc=osc_g.children[0];

        let svg_ids=Curve_SVG_IDs(Setup);
        //Functions SVG
        let svg_id=svg_ids[1];
        let svg=Element_By_ID(svg_id);
        
        //let r=Curve_Animated_Point(document,p,"rho",N);
        let r_element=Curve_Parameter_Component_Segment(
            svg,p,"rho",N
        );

        if (r_element)
        {
            svg_id=svg_ids[0];
            svg=Element_By_ID(svg_id);
        
            let c_element=Curve_Parameter_Component_Segment(
                svg,p,"Evolute",N
            );

            if (c_element)
            {
                let cx=c_element.getAttributeNS("","x1");
                let cy=c_element.getAttributeNS("","y1");
                
                let rho=r_element.getAttributeNS("","y1");
                
                osc.setAttributeNS("","cx",cx);
                osc.setAttributeNS("","cy",cy);
                osc.setAttributeNS("","r",Math.abs(rho));
            }
        }
    }
     
}
