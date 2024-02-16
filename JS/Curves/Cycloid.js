"use strict";

var part;

//Parameters

part="Parameters";

Setup[ part ][ "Curve_Title" ]="r";


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
    "Hide": true,
    
    "Options":
    {
    },
};


//Rolling Curve
var Rolling=function(t)
{
    let r=Setup.Parameters.r;

    return Vector
    (
        [
            r*t,e_i(),
            r,e_j()
        ]
    );
}

//Cycloid parametrization.

var R=function(t)
{
    let r=Setup.Parameters.r;

    return Vector
    (
        [
            r*t,e_i(),
            r,e_j(),
            r,q_t(t)
        ]
    );
}

var dR=function(t)
{    
    let r=Setup.Parameters.r;

    return Vector
    (
        [
            r,e_i(),
            r,p_t(t)
        ]
    );
}

var dR_Hat=function(t)
{    
    let r=Setup.Parameters.r;
    return Vector
    (
        [
            r,e_j(),
            r,q_t(t)
        ]
    );
}


var d2R=function(t)
{    
    let r=Setup.Parameters.r;
        
    return Vector
    (
        [
            -r,q_t(t)
        ]
    );
}

var Evolute=function(t)
{
    let r=Setup.Parameters.r;
    let tt=t+Math.PI;
    
    return Vector
    (
        [
            R(tt),
            -r*Math.PI,e_i(),
                -2.0*r,e_j()
        ]
    );
}

//*
//* Velocity, Analytical
//*

var v2=function(t)
{
    let r=Setup.Parameters.r;

    return 2.0*r*r*(   1.0-Math.cos(t)  );
}

//*
//* Determinant, Analytical
//*

var d=function(t)
{
    let r=Setup.Parameters.r;

    return r*r*(   Math.cos(t)-1   );
}



//*
//* Angular velocity, Analytical
//*

var omega=function(t)
{    
    return -0.5;
}

//*
//* Angular frequency, Analytical
//*

var nu=function(t)
{
    return -2.0;
}


//*
//* Curvature, Analytical
//*

var kappa=function(t)
{    
    if (Is_Singular(t))
    {
        return false;
    }

    return 1.0/rho(t);
}


//*
//* Curvature ratio, Analytical
//*

var rho=function(t)
{   
    if (!Is_Singular(t) && Is_Det_Singular(t))
    {
        return false;
    }
    let r=Setup.Parameters.r;

    return -2*r*Math.sqrt(   2.0*(1-Math.cos(t))   );
}


//*
//* Natural Angle, Analytical
//*

var theta=function(t)
{
    //let tole=1.0E-2;
    
    if (Is_Singular(t))
    {
        return false;
    }
            
    let tt=T(t);

    if (!tt) { return false; }
    
    return Math.atan2(tt[0],tt[1]);
}

