"use strict";

var part;

//Parameters

part="Parameters";

Setup[ part ][ "Curve_Title" ]="&lambda;";


Setup[ part ][ "Properties" ]=
{
    "r":
    { 
        "Name": "Radius",
        "Symbol": "$r$",
    },
    "lambda":
    {
        "Name": "Ratio, Dimensionless",
        "Symbol": "$\\lambda$",
    },
    "b":
    {
        "Name": "Poop Size",
        "Symbol": "$b=\\lambda r$",
    },
};

Setup[ part ][ "r" ]=1;
Setup[ part ][ "lambda" ]=1;
Setup[ part ][ "b" ]=1;

part="Curve";
Setup[ part ][ "Rolling" ]={
    "Name": "Rolling",
    "Symbol": "$\\underline{R}(t)$",
    
    "stroke": '#'+cols[ "Rolling" ],
    
    "point-size": 0.05,
    "Hide": false,
    
    "Options":
    {
    },
};


//Rolling Curve
var Rolling=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    return Vector
    (
        [
            r*t,e_i(),
            r,e_j()
        ]
    );
}

//Trochoid parametrization.
var R=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    return Vector
    (
        [
            r*t,e_i(),
            r,e_j(),
            r*lambda,q_t(t)
        ]
    );
}


//*
//* 1st Derivative, Analytical
//*

var dR=function(t)
{    
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    return Vector
    (
        [
            r,e_i(),
            r*lambda,p_t(t)
        ]
    );
}


//*
//* 2nd Derivative, Analytical
//*

var d2R=function(t)
{    
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;
    
    return Vector
    (
        [
            -r*lambda,q_t(t)
        ]
    );
}

//*
//* Square Velocity, Analytical
//*

var v2=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    return r*r*(   1.0+lambda*(  lambda-2.0*Math.cos(t)  )   );
}

//*
//* Determinant, Analytical
//*

var d=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    return r*r*lambda*(Math.cos(t)-lambda);
}

//*
//* Angular velocity, Analytical
//*

var omega=function(t)
{
    let lambda=Setup.Parameters.lambda;

    let cost=Math.cos(t);
    return (lambda*(cost-lambda))/(1+lambda*lambda-2*lambda*cost);
}



//*
//* Angular frequency, Analytical
//*

var nu=function(t)
{
    let lambda=Setup.Parameters.lambda;

    let cost=Math.cos(t);
    return (1+lambda*lambda-2*lambda*cost)/(lambda*(cost-lambda));
}

//*
//* Curvature, Analytical
//*

var kappa=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    let cost=Math.cos(t);
    return lambda/r*(cost-lambda)/(1+lambda*lambda-2*lambda*cost)**1.5;
}

//*
//* Curvature ratio, Analytical
//*

var rho=function(t)
{
    let r=Setup.Parameters.r;
    let lambda=Setup.Parameters.lambda;

    let cost=Math.cos(t);
    return r/lambda*(1+lambda*lambda-2*lambda*cost)**1.5/(cost-lambda);
}



//*
//* Natural Angle, Analytical
//*

var theta=function(t)
{
    let tt=T(t);

    if (!tt) { return false; }
    
    return Math.atan2(tt[0],tt[1]);
}

