"use strict";


function Curve_Animation_Ts(N)
{
    Curve_Animation_SVG(N,Setup,"Curve");
    Curve_Animation_SVG(N,Setup,"Functions");    
}

function Curve_Animation_SVG(N,setup,section)
{
    let svg=Element_By_ID(setup[ section ][ "ID" ]);
    if (svg)
    {
        Curve_Animation_Points(svg,N,setup,section);
    }
    else
    {
        console.log("No such element");
    }
}


//*
//* CSS ID to N SPAN elements, N e t.
//*

function Curve_Animation_CSS_ID(name)
{
    let id="Span_"+name+"_"+Curve_Setup_ID();

    return id;
}

//*
//*
//*

function Curve_Animation_Points(svg,N,setup,section)
{
    let gs=Elements_By_Class("Animation",svg,"g");

    for (let n=0;n<gs.length;n++)
    {
        let p=gs[n].getAttributeNS("","P");

        let comps=Curve_Components_Get(setup,section);
        //comps.push("Base");
        
        for (let m=0;m<comps.length;m++)
        {
            Curve_Animation_Point(svg,gs[n],p,comps[m],N);
        }
    }
}

//*
//* Try to retrieve component point to animate and animated point coordinates.
//* On success, animate point.
//*

function Curve_Animation_Point(svg,g,p,comp,N)
{
    let pt=Curve_Parameter_Component_Coordinates
    (
        svg,p,comp,N
    );

    //console.log(comp,pt);
    if (pt)
    {
        let animation_g=Curve_Animated_Point_Element
        (
            g,p,comp,N
        );

        //console.log(animation_g);
        if (animation_g)
        {
            let circle=animation_g.children[0];
            if (circle)
            {
                circle.setAttributeNS("","cx",pt[0]);
                circle.setAttributeNS("","cy",pt[1]);
            }

            if (comp=="R")
            {
                Curve_Rolling_Animate(g,p,"Rolling",N,pt);
            }
            else if (comp=="Evolute")
            {
                Curve_Osculating_Animate(g,p,"Osculating",N);
            }
            else if (comp=="dR")
            {
                Curve_Frenet_Animate(svg,g,p,"Frenet",N);
            }
        }
        else
        {
            console.log("No animated point",p,comp,N,pt);
        }
    }
    else
    {
        //console.log("No such point",p,comp,N);
    }
}


//*
//* Try to retrieve animated point as element (g).
//*


function Curve_Animated_Point(g,p,comp,N,debug=false)
{
    let g_c=Curve_Animated_Point_Element
    (
        g,p,comp,N,
        debug
    );

    let point=g_c.children[0];
    let pp=Element_2_Point(point);

    if (debug) { console.log(g_c,point); }
    
    return pp;
}
//*
//* Try to retrieve animated point as element (g).
//*


function Curve_Animated_Point_Element(g,p,comp,N,debug=false)
{
    let animated_point=Elements_By_Classes
    (
        ["Node",comp],
        g,"g",
        debug
    );

    if (!animated_point)
    {
        console.log("Animated point not found");

        return;
    }   

    return animated_point[0];
}

//*
//* Try to retrieve coordinates for point N, in comp, parameter no p
//*


function Curve_Parameter_Component_Coordinates(svg,p,comp,N,debug=false)
{    
    let segment=Curve_Parameter_Component_Segment(
        svg,p,comp,N,
        debug
    );

    let pt=false;
    if (segment)
    {
        pt=[
            segment.getAttributeNS("","x2"),
            segment.getAttributeNS("","y2"),
        ];
    }

    return pt;
}


//*
//* Try to locate segment N, in comp, parameter no p
//*

function Curve_Parameter_Component_Segment(svg,p,comp,N,debug=false)
{
    if (debug)
    {
        console.log("Locating main G tag");
    }
    //CLASS="Name" G element: all components
    let g_mesh=Curve_G_Mesh(svg,p);
    if (!g_mesh)
    {
        console.log("No mesh");
        return false;
    }
    
    //Parameter p G element
    let g_parm=Curve_G_Mesh_Parameters(g_mesh,p);
    if (!g_parm)
    {
        console.log("No parm",comp,p);
        return false;
    }
    
    //Component p G element
    let g_comp=Curve_G_Mesh_Parameter_Comp(g_parm,p,comp)

    if (!g_comp)
    {
        //console.log("No Component",p,"comp",comp);
        return false;
        
    }
    
    let segment=Element_Child_Unique(g_comp,"line",["N_"+N]);

    //console.log(segment);
    return segment;
}

//*
//* Try to locate unique Meshes tag in g.
//*

function Curve_G_Mesh(svg,p)
{    
    return Element_By_Classes(["Parameter","P_"+p],svg,"g");
}

//*
//* Try to locate unique parameter p g-tag in g.
//*

function Curve_G_Mesh_Parameters(g,p)
{    
    return Element_By_Classes(["Meshes"],g,"g");
    //return Element_Child_Unique(g,"g",["P_"+p]);
}

//*
//* Try to locate unique parameter/component p g-tag in g.
//*

function Curve_G_Mesh_Parameter_Comp(g,p,comp)
{    
    return Element_Child_Unique(g,"g",[comp]);
}



//Should be redeclared by each animation
var Curve_Animate=function(n)
{
    //console.log("No curve animator",n);
}



window.animate=false;
window.isanimating=false;
window.anim_n=0;
window.anim_max=0;


function Curve_Animation_Run(setup)
{
    if (window.anim_max==0)
    {
        window.anim_max=setup.Parameters[ "N" ];
    }
    //console.log(window.anim_n,window.anim_max);
    let time1=new Date();
    
    window.isanimating=true;
    let res=Curve_Animate(anim_n);
    window.isanimating=false;
    
    let time2=new Date();

    if (window.anim_n>setup.Parameters.N)
    {
        window.animate=false;
    }

    window.anim_n++;
    if (window.anim_n>window.anim_max)
    {
        window.anim_n=0;
    }
    
    Curve_Animation_Anim_N_To_Span();
}


function Curve_Animation_Anim_N_To_Span()
{
    let span_n_id=Curve_Animation_CSS_ID("N");    
    let span_n=Element_By_ID(span_n_id);
    if (span_n)
    {
        span_n.innerText=window.anim_n;
    }
    else
    {
        console.log("No SPAN_N",span_n_id);
    }
    
    let span_t_id=Curve_Animation_CSS_ID("t");    
    let span_t=Element_By_ID(span_t_id);
    
    if (span_t)
    {
        
        span_t.innerText=Curve_Calc_t(window.anim_n);
    }
    else
    {
        console.log("No SPAN_t",span_t_id);
    }
}

var mtime=Date.now();
var delay=1000;//Setup.Animation[ "Delay" ]*1000;


var myanimate = setInterval
(
    function()
    {
        if (!window.animate) { return; }
        if (window.isanimating) { console.log("postponed"); return; }

        let dtime=Date.now()-mtime;

        if (dtime>delay)
        {
            //console.log("Run",dtime-delay);
            Curve_Animation_Run(Setup);
            mtime=Date.now();
        }
        else
        {
            //console.log("Wait",dtime-delay);
        }
    },
    200 //every second
);


function Curve_Animation_Delay_Set(rdelay)
{
    delay=parseFloat(rdelay)*1000;
}
