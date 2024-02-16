"use strict";

var part;

//Parameters

part="Parameters";

Setup[ part ][ "Curve_Title" ]="&lambda;";


Setup[ part ][ "Properties" ]=
{
    "a":
    { 
        "Name": "X-axis",
        "Symbol": "$r$",
    },
    "lambda":
    {
        "Name": "Ratio, Dimensionless",
        "Symbol": "$\\lambda$",
    },
    "b":
    {
        "Name": "Y-axis",
        "Symbol": "$b=\\lambda r$",
    },
};

Setup[ part ][ "a" ]=2;
Setup[ part ][ "lambda" ]=1;
Setup[ part ][ "b" ]=1;


//*
//* Trochoid parametrization.
//*
var R=function(t)
{
    let a=Setup.Parameters.a;
    let b=a*Setup.Parameters.lambda;

    return [
        a*Math.cos(t),
        b*Math.sin(t),
    ];
}

//*
//* First derivative, Analytical
//*

var dR=function(t)
{    
    let a=Setup.Parameters.a;
    let b=a*Setup.Parameters.lambda;

    return [
        -a*Math.sin(t),
        b*Math.cos(t),
    ];
}


//*
//* Second derivative, Analytical
//*
var d2R=function(t)
{  
    let a=Setup.Parameters.a;
    let b=a*Setup.Parameters.lambda;

    return [
        -a*Math.cos(t),
        -b*Math.sin(t),
    ];  
}
//*
//* Evolute, Analytical
//*
var Evolute=function(t)
{  
    let a=Setup.Parameters.a;
    let lambda=Setup.Parameters.lambda;

    let fact=a*(1/lambda-lambda);
    
    return [
        fact*lambda*Math.cos(t)**3,
        -fact*Math.sin(t)**3,
    ];  
}

//*
//* Velocity, Analytical
//*

var v2=function(t)
{
    let a2=Setup.Parameters.a*Setup.Parameters.a;
    let lambda2=Setup.Parameters.lambda*Setup.Parameters.lambda;

    return a2*( Math.sin(t)**2+lambda2*Math.cos(t)**2);
}

//*
//* Determinant, Analytical
//*

var d=function(t)
{
    let a=Setup.Parameters.a;
    let lambda=Setup.Parameters.lambda;

    return a**2*lambda;
}




//*
//* Angular frequency, Analytical
//*

var nu=function(t)
{
    let lambda=Setup.Parameters.lambda;

    return (1.0/lambda)*( Math.sin(t)**2+lambda*lambda*Math.cos(t)**2);
}

//*
//* Angular velocity, Analytical
//*

var omega=function(t)
{
    1.0/nu(t);    
}
