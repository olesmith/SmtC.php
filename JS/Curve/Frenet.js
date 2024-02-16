"use strict";



//*
//* Draws initial frenet system, R,t,n.
//*

function Curve_Frenet_Initial_Add(svg,g,setup,curve,p)
{    
    g.append
    (
        Curve_Frenet_Create(svg,setup,curve,p,0)
    );
}

//*
//* Draws initial frenet system, R,t,n.
//*

function Curve_Frenet_Create(svg,setup,curve,p,N)
{
    let options=Curve_SVG_G_Options(setup,"Frenet","Curve");
        
    options[ "class" ]="Node Frenet";
    options[ "fill" ]="none";
    
    let p_r=curve[ "R" ][N];
    let t_r=curve[ "T" ][N];
    
    let g=svg.SVG_Create('g',options);
    
    svg.SVG_Add_Vector
    (
        g,
        p_r,
        t_r
    );
    
    svg.SVG_Add_Vector
    (
        g,
        p_r,
        Vector_Hat(t_r)
    );

    return g;
}

//*
//* 
//*


function Curve_Frenet_Animate(svg,g,p,comp,N,debug=true)
{
    //Frenet system
    let frenet_g=Curve_Animated_Point_Element
    (
        g,p,comp,N
    );
    
    if (frenet_g && frenet_g.children.length>1)
    {

        //let t_frenet=frenet_g.children[0];
        //let n_frenet=frenet_g.children[1];

        let r_element=Curve_Parameter_Component_Segment(
            svg,p,"R",N
        );
        
        let dr_element=Curve_Parameter_Component_Segment(
            svg,p,"dR",N
        );

        let r=[
            r_element.getAttributeNS("","x2"),
            -r_element.getAttributeNS("","y2"),
        ];

        let dr=[
            dr_element.getAttributeNS("","x1"),
            -dr_element.getAttributeNS("","y1"),
        ];

        let t=Vector_Unit(dr);
        


        let t_element=SVGs[0].SVG_Draw_Vector
        (
            r,
            t
        );

        let n_element=SVGs[0].SVG_Draw_Vector
        (
            r,
            Vector_Hat(t)
        );

        frenet_g.replaceChild(t_element,frenet_g.children[0]);
        frenet_g.replaceChild(n_element,frenet_g.children[1]);
        
        //console.log(t_element,n_element);
    }
    else if (false)
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
