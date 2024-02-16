"use strict";


function Curve_Curves_DIVs(setup,curve)
{
    let divs=document.createElement('div');
    
    divs.append
    (
        Curve_Curves_DIV(Setup,curve)
    );
    
    divs.append
    (
        Curve_Curves_Control_DIV(Setup,curve)
    );

    return divs;  
}

function Curve_Curves_DIV(setup,curve)
{
    let div=document.createElement('div');
        
    let svg=Curve_SVG(setup,curve);
    div.append(svg );

    
    return div;
}

function Curve_Curves_Control_DIV(setup,curve)
{
    let div=document.createElement('div');

    div.append
    (
        Curve_Curves_Control_Table(setup)
    );

    return div;
}



function Curve_SVG(setup,curve)
{
    let svg=new MySVG(setup.Curve);
    
    svg.SVG_WCS
    (
        svg.svg,
        setup.Curve
    );

    Curve_SVG_Add_Family(svg,setup);

    SVGs.push(svg);
    
    return svg.svg;
}

//*
//* 
//*

function Curve_SVG_Add_Family(svg,setup)
{
    let g=svg.SVG_Create
    (
        'g',
        {
            "class": setup[ "Class" ],
            "stroke-width": setup[ "stroke-width" ],
        }
    );
    
    let dopacity=Curve_dOpacity(setup);
   
    //for (let p=0;p<setup[ "Parameters" ][ "Values" ].length;p++)

    //Draw p=0 last, so poop will be on top.
    for (let p=setup[ "Parameters" ][ "Values" ].length-1;p>=0;p--)
    {
        let opacity=1.0-dopacity*p;
        let gg=Curve_SVG_Add_Family_Member(svg,setup,p,opacity);

        g.append(gg);
    }
    
    svg.svg.append(g);
}


//*
//* 
//*

function Curve_SVG_Add_Family_Member(svg,setup,p,opacity)
{
    let g=svg.SVG_Create
    (
        'g',
        {
            "class": "Parameter P_"+p,
            "P": p,
            "style":
            {
                "opacity": opacity,
            },
        }
    );

    let parameter=setup[ "Parameters" ][ "Values" ][ p ];
    let parameter_name=setup[ "Parameters" ][ "Title" ];

    //Set parameter and calculate curve
    Curve_Set_Parameter(parameter);
    let rcurve=Curve_Calc(setup);

    //Draw curve components
    g.append
    (
        Curve_SVG_Components
        (
            svg,setup,rcurve,p,parameter,opacity
        )
    );

    //Points to animate
    g.append
    (
        Curve_SVG_Animation_Points
        (
            svg,setup,rcurve,p,parameter,opacity
        )
    );

    return g;
}
    
//*
//* Join options of component embracing G field.
//*

function Curve_SVG_G_Options(setup,comp,key="Curve")
{
    let options=setup[ key ][ comp ][ "Options" ];
    let hide=setup[ key ][ comp ][ "Hide" ];   
    if (hide)
    {
        options[ "style" ]='display: none;';
    }

    if (!options[ "stroke" ] && setup[ key ][ comp ][ "stroke" ])
    {
        options[ "stroke" ]=setup[ key ][ comp ][ "stroke" ]
    }

    return options;
}

//*
//* g element, with curve components start point - used to animate.
//*
function Curve_SVG_Animation_Points(svg,setup,curve,p,parameter,opacity)
{
    let parameter_name=p;
    let g=svg.SVG_Create
    (
        'g',
        {
            "class": "Animation P_"+p,
            "P": p,
        }
    );

    
    let comps=Curve_Components_Get(setup);
    for (let n=0;n<comps.length;n++)
    {        
        let comp=comps[n];

        if (comp==="Rolling")
        {
            continue;
        }
  
        if (!setup[ "Curve" ][ comp ])
        {
            continue;
        }
        
        let options=setup[ "Curve" ][ comp ][ "Options" ];
        let hide=setup[ "Curve" ][ comp ][ "Hide" ];

        options[ "style" ]='';
        if (hide)
        {
            options[ "style" ]='display: none;';
        }

        if (!curve[ comp ]) { continue; }
        
        let classes=["Node",comp];
        let point=curve[ comp ][0];

        if (Point_Is(point))
        {
            if (!options[ "fill" ] && options[ "stroke" ])
            {
                options[ "fill" ]=options[ "stroke" ];
            }
            
            options[ "class" ]=classes.join(" ");
            
            let gc=svg.SVG_Create('g',options);

            let pc=svg.SVG_Draw_Point(point);

            gc.append(pc);
            g.append(gc);
        }
        else
        {
            console.log("First entry not a point",comp,point);
        }
    }

    
    if (setup[ "Curve" ][ "Osculating" ])
    {
        Curve_Osculating_Initial_Add(svg,g,setup,curve,p);
    }
    
    if (setup[ "Curve" ][ "Frenet" ])
    {
        Curve_Frenet_Initial_Add(svg,g,setup,curve,p);
    }
   
    Curve_Base_Add(svg,g,setup,curve,p);
    
    return g;
}



function Curve_SVG_Components(svg,setup,curve,p,parameter,opacity)
{
    let g=svg.SVG_Create
    (
        'g',
        {
            "class": "Meshes P_"+p,
        }
    );
         
    g.addEventListener
    (
        'mouseover',
        function(event)
        {
            SVG_Gs_Mark(event.srcElement);
        }
    );
    
    g.addEventListener
    
    (
        'mouseout',
        function(event)
        {
            SVG_Gs_Mark(event.srcElement,true);
        }
    );
        
    let comps=Curve_Components_Get(setup);

    for (let n=0;n<comps.length;n++)
    {
        let comp=comps[n];

        let options=Curve_SVG_G_Options(setup,comp,"Curve");

        if (comp)
        {
            svg.SVG_Curve_Add
            (
                g,
                [ comp, "P_"+p ],
                curve[ comp ],
                options,
                p+1
            );
        }
    }
    
    return g;
}


//*
//* Creates html table with Curve info 
//*

function Curve_Curves_Control_Table(setup)
{
    let section="Curve";
    let parts=Curve_Components_Get(setup);
    
    let table=[];
    for (let n=0;n<parts.length;n++)
    {
        let hash=setup[ section ][ parts[n] ];
        
        let row=
            [
                Curve_Control_Toggle
                (
                    section,parts[n],setup,
                    hash[ "Name" ]
                ),
                hash[ "Symbol" ],
                Curve_Control_Stroke_Color_Input
                (
                    section,parts[n],setup
                )
            ];
        
        table.push(row);
    }

    let rtable=Matrix_Transpose(table);

    return Html_Table(rtable);
}

