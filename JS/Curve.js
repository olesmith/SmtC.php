"use strict";


var SVGs=[];


function Curve_SVGs(element_id)
{
    let element=Get_Element_By_ID(element_id);
    if (!element)
    {
        console.log("Nu such element ID",element_id);
        return;
    }
    element.append
    (
        Curve_SVGs_DIV()
    );
    
    Load_MathJax();
}

function Curve_SVGs_DIV()
{
    let div=document.createElement('div');
    div.style.display="flex";
    div.style.flexDirection="column";
    
    let curve=Curve_Calc(Setup);
    div.append(Curve_Control_Center(Setup));
    
    
    div.append
    (
        Curve_Curves_DIVs(Setup,curve)
    );;
    
    div.append
    (
        Curve_Functions_DIVs(Setup,curve)
    );    

    return div;
}

//*
//* SVG IDs
//*
function Curve_SVG_IDs(setup)
{
    return [
        setup[ "Curve" ][ "ID" ],
        setup[ "Functions" ][ "ID" ],
    ];
}


//*
//* Curve components keys.
//* Key is Curve of Function.
//* setup[ key ][ comp ] must exist.
//*

function Curve_Components_Get(setup,key="Curve")
{
    let comps=setup[ key ][ "Components" ];

    let rcomps=[];
    for (let n=0;n<comps.length;n++)
    {
        if (setup[ key ][ comps[n] ])
        {
            rcomps.push(comps[n]);
        }
    }
    
    return rcomps;
}


function Curve_dOpacity(setup)
{
    let dopacity=0.2;
    if (setup[ "Parameters" ][ "Values" ])
    {
        dopacity=0.6/(setup[ "Parameters" ][ "Values" ].length);
    }
    else
    {
        if (setup[ "dOpacity" ])
        {
            dopacity=setup[ "dOpacity" ];
        }
    }
    
    return dopacity;
}

