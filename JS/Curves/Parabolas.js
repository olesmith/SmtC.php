"use strict";

//let get2=GET2Hash();

var id=Curve_Setup_ID();

var scale=4;
var low=-0.25;

var a=1.0;


var t1=-2;
var t2=2;


var part;


//Parameters

part="Parameters";

Setup[ part ][ "Values" ]=[1.0,1.25,1.5,1.75,2.0];

Setup[ part ][ "t1" ]=t1;
Setup[ part ][ "t2" ]=t2;
Setup[ part ][ "N" ]=200;


let name="Parabolas";


part="Curve";

Setup[ "Name" ]=name;
Setup[ "Class" ]=name;
Setup[ "Title" ]=name;


//Curve part


Setup[ part ][ "ID" ]=name+'_'+id;
Setup[ part ][ "Name" ]=name+' Curve';

Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=400;

Setup[ part ][ "Min" ]=[ -scale,low ];
Setup[ part ][ "Max" ]=[ scale,scale ];



//Functions part

part="Functions";

Setup[ part ][ "ID" ]=name+'_F_'+id;
Setup[ part ][ "Name" ]=name+' Functions';


Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=400;


Setup[ part ][ "Min" ]=[ -scale,low ];
Setup[ part ][ "Max" ]=[ scale,scale ];

Setup[ part ][ "Components" ].push("s");

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
    Setup[ "Parameters" ][ "a" ]=p;
}

