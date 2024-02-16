"use strict";

//let get2=GET2Hash();

var id=Curve_Setup_ID();

var scale=1.1;

var r=1.0;
var lambda=1.0;

var t1=-1.0;
var t2=3.0;

t1=t1*Math.PI;
t2=t2*Math.PI;

var part;


//Parameters

part="Parameters";

//Setup[ part ][ "Values" ]=[1.0,0.8,0.6,0.5,0.4,0.2];
Setup[ part ][ "Values" ]=[1.0,1.25,1.5,0.75,0.5];

Setup[ part ][ "t1" ]=t1;
Setup[ part ][ "t2" ]=t2;
Setup[ part ][ "N" ]=200;


var name="Trochoids";

var title="Trochoids";



part="Curve";

Setup[ "Name" ]=title;
Setup[ "Class" ]=name;
Setup[ "Title" ]=title;


//Curve part


Setup[ part ][ "ID" ]=name+'_'+id;
Setup[ part ][ "Name" ]=title+' Curve';

Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=1200;

Setup[ part ][ "Min" ]=[ t1,-2.05*scale*r ];
Setup[ part ][ "Max" ]=[ t2*r, 2.75*scale*r ];

Setup[ part ][ "Frenet_P" ]=[ 1.15*t2*r, -2.25*scale*r ];
Setup[ part ][ "Rolling" ][ "R" ]=r;



//Functions part

part="Functions";

Setup[ part ][ "ID" ]=name+'_F_'+id;
Setup[ part ][ "Name" ]=title+' Functions';


Setup[ part ][ "height" ]=600;
Setup[ part ][ "width" ]=1200;


var v_max=1.0*r*r*scale*(1+lambda*lambda);
var v_min=-2.0*r*r*scale*(1+lambda*lambda);

Setup[ part ][ "Min" ]=[ t1,   v_min ];
Setup[ part ][ "Max" ]=[ t2*r, v_max ];

var Curve_Animate=function(n)
{
    return Curve_Animation_Ts(n);
}


//*
//* Draws rolling initial circle.
//*

function Curve_Base_Add(svg,g,setup,curve,p)
{    
    Curve_Rolling_Initial_Add(svg,g,setup,curve,p);
}

//*
//* 
//*

function Curve_Base_Animate(svg,g,setup,curve,p)
{
}

function Curve_Set_Parameter(p)
{
    Setup[ "Parameters" ][ "lambda" ]=p;
}

