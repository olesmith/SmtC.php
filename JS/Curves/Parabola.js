"use strict";

var part;

//Parameters

part="Parameters";

Setup[ part ][ "Curve_Title" ]="a";


Setup[ part ][ "Properties" ]=
{
    "a":
    { 
        "Name": "a",
        "Symbol": "$a$",
    },
};

Setup[ part ][ "a" ]=1;



//Parabola parametrization.
var R=function(t)
{
    let a=Setup.Parameters.a;

    return [
        t,
        0.5*a*t*t,
    ];
}

var dR=function(t)
{    
    let a=Setup.Parameters.a;

    return [
        1.0,
        a*t,
    ];
}


var dR_Hat=function(t)
{    
    let a=Setup.Parameters.a;

    return [
        -a*t,1.0
    ];
}


var d2R=function(t)
{  
    let a=Setup.Parameters.a;
    
    return [0.0,a];
}


var Evolute=function(t)
{  
    let a=Setup.Parameters.a;
    
    return [-a*a*t*t*t,1.5*a*t*t+1.0/a];
}

//*
//* Velocity, Analytical
//*

var v2=function(t)
{
    let a=Setup.Parameters.a;
    
    return 1+a*a*t*t;
}

//*
//* Determinant, Analytical
//*

var d=function(t)
{
    let a=Setup.Parameters.a;
    return a;
}



//*
//* Angular velocity, Analytical
//*

var omega=function(t)
{    
    let a=Setup.Parameters.a;
    let at=a*t;

    return a/(1+at**2);
}

//*
//* Angular frequency, Analytical
//*

var nu=function(t)
{
    let a=Setup.Parameters.a;
    let at=a*t;

    return (1+at**2)/a;
}



//*
//* Arc Length, Analytical
//*

var s=function(t)
{
    let a=Setup.Parameters.a;
    let at=a*t;
    let sqrt=Math.sqrt(1+at**2);

    return 0.5*Math.abs( t*sqrt+Math.log(at+sqrt)/a);
}




//*
//* ??? To appear in slides
//*

var klll=function(t)
{
}

