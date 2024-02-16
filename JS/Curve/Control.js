"use strict";


function Curve_Control_Center(setup)
{
    let div=Child_Create
    (
        'div',"",
        {
            "align": 'center',
        },
        {
            "textAlign": 'center',
        }
    );
 
    Child_Add
    (
        div,
        'h3',
        "Control Center: "+setup[ "Name" ]
    );
    
    div.append
    (
        Html_Table
        (
            Curve_Control_Tables(setup)
        )
    );
    
    return div;
}

//*
//* Creates color input.
//*

function Curve_Control_Stroke_Color_Input(section,component,setup)
{
    let key='stroke';

    //console.log(section,component,setup[ section ][ component ]);

    let input=Child_Create('input');
    input.type='color';

    let value=Curve_Component_Color(section,component,setup);
    
    input.value=value;
    input.name=[component].join("_");

    input.setAttribute("onchange","Input_SVG_Colors_Set(this);");

    return input;
}
//*
//* Creates color input.
//*

function Curve_Component_Color(section,component,setup)
{    
    let key='stroke';
    let value=setup[ section ][ component ][ "Options" ][ key ];
    if (!value)
    {
        value=setup[ section ][ component ][ key ];
    }

    return value;    
}

function Curve_Control_Tables(setup)
{
    return [
        [
            Curve_Control_Table
            (
                "Parameters",
                ["t1","t2","N"],
                setup
            ),
            Curve_Control_Parameters_Table
            (
                setup
            ),
            Curve_Control_Animation_Table
            (
                setup
            ),
        ],
    ];
}

function Curve_Control_Table(section,parms,setup)
{        
    return Html_Table
    (
        Curve_Control_Rows
        (
            section,
            parms,
            setup
        )
    );
}

function Curve_Control_Table_Title(title)
{
    return Child_Create('h5',title);
}
    

//*
//* Creates toggle, to show/hide section/component.
//*

function Curve_Control_Toggle(section,component,setup,comp)
{
    let clss=component;
    let sclss=clss+" Show";
    let hclss=clss+" Hide";

    //console.log(setup[ section ][ component ]);
    let toggle=Html_Toggles
    (
        clss,comp,
        "g",
        setup[ section ][ component ][ "Hide" ],
        {
            "Color": setup[ section ][ component ][ "stroke" ],
        }
    );


    return toggle;
}


function Curve_Control_Rows(section,parms,setup)
{
    let rows=[];

    rows.push([Curve_Control_Table_Title(setup[ section ][ "Name" ])]);
    
    for (let n=0;n<parms.length;n++)
    {
        rows.push
        (
            Curve_Control_Row(section,parms[n],setup)
        );
    }
    
    return rows;
}
        
function Curve_Control_Row(section,parm,setup)
{
    let row=
    [
        Curve_Control_Row_Title(section,parm,setup),
        Child_Create
        (
            'span',
            setup[ section ][ parm ]
        ),
    ];

    return row;
}

function Curve_Control_Row_Title(section,parm,setup)
{
    let title=parm;
    if (setup[ section ][ parm+"_Title" ])
    {
        title=setup[ section ][ parm+"_Title" ];
    }
    
    return Child_Create
    (
        'span',
        title,
        {
        },
        {
            "fontWeight": "bold",
        }
    );
}

