"use strict";

//let get2=GET2Hash();

var id=Curve_Setup_ID();

var scale=5;

var a=1.0;
var b=1.0;


var t1=0;
var t2=2;

t1=t1*Math.PI;
t2=t2*Math.PI;

var part;


//Parameters

part="Parameters";

Setup[ part ][ "Values" ]=[0.25,0.5,0.75,1.0,1.25,1.5,1.75];

Setup[ part ][ "t1" ]=t1;
Setup[ part ][ "t2" ]=t2;
Setup[ part ][ "N" ]=200;


let name="Ellipse";


part="Curve";

Setup[ "Name" ]=name;
Setup[ "Class" ]=name;
Setup[ "Title" ]=name;


//Curve part


Setup[ part ][ "ID" ]=name+'_'+id;
Setup[ part ][ "Name" ]=name+' Curve';

Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=600;

Setup[ part ][ "Min" ]=[ -scale,-scale ];
Setup[ part ][ "Max" ]=[ scale,scale ];



//Functions part

part="Functions";

Setup[ part ][ "ID" ]=name+'_F_'+id;
Setup[ part ][ "Name" ]=name+' Functions';


Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=600;


Setup[ part ][ "Min" ]=[ t1, -scale ];
Setup[ part ][ "Max" ]=[ t2, scale ];

var Curve_Animate=function(n)
{
    return Curve_Animation_Ts(n);
}


//*
//* Draws rolling initial circle.
//*

function Curve_Base_Add(svg,g,setup,curve,p)
{    
}

//*
//* Draws rolling circles.
//*

function Curve_Base_Animate(svg,g,setup,curve,p)
{    
    
}

function Curve_Set_Parameter(p)
{
    Setup[ "Parameters" ][ "lambda" ]=p;
}

