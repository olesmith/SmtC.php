"use strict";

function Curve_Functions_DIVs(setup,curve)
{
    let divs=document.createElement('div');
    
    divs.append
    (
        Curve_Functions_Control_DIV(Setup,curve)
    );
    
    divs.append
    (
        Curve_Functions_DIV(Setup,curve)
    );

    return divs;
}

function Curve_Functions_DIV(setup,curve)
{
    let div=document.createElement('div');

    div.append
    (
        Curve_Functions_SVG(setup,curve)
    );
    
    return div;
}

function Curve_Functions_Control_DIV(setup,curve)
{
    let div=document.createElement('div')

    div.append
    (
        Curve_Functions_Control_Table(setup)
    );
    //td.style.verticalAlign="middle";
    
    return div;
}

function Curve_Functions_SVG(setup,curve)
{
    let svg=new MySVG(setup.Functions);
    
    svg.SVG_WCS
    (
        svg.svg,
        setup.Functions
    );

    let g=Curve_Functions_SVG_Family(svg,setup);

    svg.svg.append(g);
    
    return svg.svg;
}

function Curve_Functions_SVG_Family(svg,setup)
{
    let g=svg.SVG_Create
    (
        'g',
        {
            "class": setup[ "Class" ],
            "stroke-width": setup[ "stroke-width" ],
        }
    );
    
    let opacity=1.0;
    let dopacity=Curve_dOpacity(setup);
    
    for (let p=0;p<setup[ "Parameters" ][ "Values" ].length;p++)
    {
        let gg=Curve_Functions_SVG_Family_Member(svg,setup,p,opacity);

        g.append(gg);
        opacity-=dopacity;
    }

    return g;
}
    
function Curve_Functions_SVG_Family_Member(svg,setup,p,opacity)
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
    //let parameter_name=setup[ "Parameters" ][ "Title" ];

    //Set parameter and calculate curve
    Curve_Set_Parameter(parameter);
    let rcurve=Curve_Calc(setup);

    //Curve components
    g.append
    (
        Curve_Functions_SVG_Components
        (
            svg,setup,rcurve,p,parameter,opacity
        )
    );

    //Animation Points
    g.append
    (
        Curve_Functions_SVG_Animation_Points
        (
            svg,setup,rcurve,p,parameter,opacity
        )
    );

    return g;
}


//*
//* Draw components.
//*

function Curve_Functions_SVG_Components(svg,setup,curve,p,parameter,opacity)
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
    
    let functions=setup[ "Functions" ][ "Components" ];
    for (let n=0;n<functions.length;n++)
    {
        if (curve[ functions[n] ])
        {
            svg.SVG_Curve_Add
            (
                g,
                ["Func",functions[n], "P_"+p],
                curve[ functions[n] ],
                Curve_SVG_G_Options(setup,functions[n],"Functions"),
                p+1
            );
        }
    }

    return g;
}

    
//*
//* Insert animation points.
//*

function Curve_Functions_SVG_Animation_Points(svg,setup,curve,p,parameter,opacity)
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
    
    let functions=Curve_Components_Get(setup,"Functions");

    for (let n=0;n<functions.length;n++)
    {
        if (curve[ functions[n] ])
        {
            let comp=functions[n];

            let options=setup[ "Functions" ][ comp ][ "Options" ];
            let hide=setup[ "Functions" ][ comp ][ "Hide" ];
            
            if (hide)
            {
                options[ "display" ]='none';
            }

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
                
                svg.SVG_Add_Point
                (
                    gc,
                    point
                );

                g.append(gc);
            }
        }
    }

    return g;
}

//*
//* Creates html table with Curve functions info 
//*

function Curve_Functions_Control_Table(setup)
{    
    let section="Functions";
    let parts=setup[ section ][ "Components" ];

    let table=[];
    for (let n=0;n<parts.length;n++)
    {
        let hash=setup[ section ][ parts[n] ];
        
        table.push
        (
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
            ]
        );
    }

    return Html_Table
    (
        Matrix_Transpose(table)
    );
}

