"use strict";

let get=GET2Hash();

var id=Curve_Setup_ID();

var scale=1.5;
var r=1.0;
var t1=0;
var t2=2*Math.PI;

let part;


//Parameters


part="Parameters";

Setup[ part ][ "Values" ]=[0.75,1];

Setup[ part ][ "Curve_Title" ]="&omega;";


Setup[ part ][ "Properties" ]=
{
    "r":
    {
        "Name": "Radius",
        "Symbol": "$r$",
    },
    "omega":
    {
        "Name": "Angular Velocity",
        "Symbol": "$\\omega$",
    },
};

Setup[ part ][ "r" ]=r;
Setup[ part ][ "omega" ]=1;

Setup[ part ][ "t1" ]=t1;
Setup[ part ][ "t2" ]=t2;
Setup[ part ][ "N" ]=100;




let name="Circle";


part="Curve";

Setup[ "Name" ]=name;
Setup[ "Class" ]=name;
Setup[ "Title" ]=name;

//Curve


part="Curve";
Setup[ "Name" ]=name;
Setup[ "Title" ]=name;

Setup[ part ][ "ID" ]=name+'_'+id;
Setup[ part ][ "Name" ]=name+' Curve';

Setup[ part ][ "height" ]=400;
Setup[ part ][ "width" ]=400;

Setup[ part ][ "Min" ]=[ -scale*r,-scale*r ];
Setup[ part ][ "Max" ]=[  scale*r, scale*r ];


//Curve

part="Functions";

Setup[ part ][ "ID" ]='Circle_F_'+id;
Setup[ part ][ "Name" ]='Circle';


Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=800;


Setup[ part ][ "Min" ]=[ t1, -1 ];
Setup[ part ][ "Max" ]=[ t2,  6 ];


//Curve functions.

//function R(t)
var R=function(t)
{    
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return Vector([r,e_t(t,omega) ]);
}

var dR=function(t)
{    
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return Vector
    (
        [
            omega*r,
            f_t(t,omega)
        ]
    );
}

var d2R=function(t)
{    
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return Vector
    (
        [
            -omega*omega*r,
            e_t(t,omega)
        ]
    );
}


//*
//* Velocity
//*

var v2=function(t)
{
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return (r*omega)**2;
}

//*
//* Determinant
//*

var d=function(t)
{
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return omega*(r*omega)**2;
}

//*
//* Angular velocity, Analytical
//*

var omega=function(t)
{
    let omega=Setup.Parameters.omega;
    
    return omega;
}

//*
//* Angular frequency, Analytical
//*

var omega=function(t)
{
    let omega=Setup.Parameters.omega;
    
    return 1.0/omega;
}

//*
//* Curvature ratio, Analytical
//*

var rho=function(t)
{
    let r=Setup.Parameters.r;
    
    return r;
}

//*
//* Curvature rion, Analytical
//*

var kappa=function(t)
{
    let r=Setup.Parameters.r;
    
    return 1.0/r;
}

//*
//* Curve length, Analytical
//*

var s=function(t)
{
    let r=Setup.Parameters.r;
    let omega=Setup.Parameters.omega;
    
    return r*omega*t;
}

var Curve_Animate=function(n)
{
    Curve_Animation_Ts(n);
}


function Curve_Set_Parameter(p)
{
    Setup[ "Parameters" ][ "omega" ]=p;
}

//*
//* Draws nothing.
//*

function Curve_Base_Add(svg,g,setup,curve,p)
{    
}



var Curve_Animate=function(n)
{
    return Curve_Animation_Ts(n);
}
