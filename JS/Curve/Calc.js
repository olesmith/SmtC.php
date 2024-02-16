"use strict";


function Curve_Calc(setup)
{
    let curve={};

    curve[ "R" ]=Curve_Calc_R();
    
    curve[ "dR" ]=false;
    if (typeof dR === 'function')
    {
        curve[ "dR" ]=Curve_Calc_R(dR);
    }
    
    curve[ "d2R" ]=false;
    if (typeof d2R === 'function')
    {
        curve[ "d2R" ]=Curve_Calc_R(d2R);
    }
    
    curve[ "T" ]=false;
    //curve[ "N" ]=false;
    if (typeof T === 'function')
    {
        curve[ "T" ]=Curve_Calc_R(T);
        //curve[ "N" ]=Curve_Calc_R(N);
    }

    curve[ "Evolute" ]=false;
    if (typeof Evolute === 'function')
    {
        curve[ "Evolute" ]=Curve_Calc_R(Evolute);
    }

    curve[ "Rolling" ]=false;
    if (typeof Rolling === 'function')
    {
        curve[ "Rolling" ]=Curve_Calc_R(Rolling);
    }

    curve=Curve_Calc_Functions(setup,curve);

    return curve;
}

//*
//* Calculate dt from limits.
//*
function Curve_Calc_dt()
{    
    return (Setup.Parameters.t2-Setup.Parameters.t1)/(1.0*Setup.Parameters.N);
}

//*
//* Calculate t from n.
//*

function Curve_Calc_t(n)
{
    let dt=Curve_Calc_dt();
    
    return Setup.Parameters.t1+n*dt;
}




//* Calls vector function f for all parameter values.
//* IE: R, dR, d2R and C (evolute)
//* Returns list of vectors, R(t).

function Curve_Calc_R(f=false,singulars=false)
{
    if (!f) { f=R; }
    
    let dt=Curve_Calc_dt();

    let t=Setup.Parameters.t1;

    let rs=[];
    for (let n=0;n<=Setup.Parameters.N;n++)
    {
        rs.push(f(t));
        t+=dt;
    }

    return rs;
}



function Curve_Calc_Functions(setup,curve)
{
    let func;
    
    //Velocity    
    func="v";
    curve[ func ]=false;
    if (typeof v === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(v);
    }

    //Determinant    
    func="d";
    curve[ func ]=false;
    if (typeof d === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(d);
    }

    //Angular velocity    
    func="omega";
    curve[ func ]=false;
    if (typeof omega === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(omega);
    }

    //Angular frequency    
    func="nu";
    curve[ func ]=false;
    if (typeof nu === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(nu);
    }
    
    //Curvature    
    func="kappa";
    curve[ func ]=false;
    if (typeof kappa === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(kappa);
    }
    
    //Curvature ratio    
    func="rho";
    curve[ func ]=false;
    if (typeof rho === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(rho);
    }
    
    //Natural Angle    
    func="theta";
    curve[ func ]=false;
    if (typeof theta === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(theta);
    }
     
    
    //Arc length    
    func="s";
    curve[ func ]=false;
    if (typeof s === 'function')
    {    
        curve[ func ]=Curve_Calc_Function(s);
    }

    return curve;
}



//* Calls function f for all parameter values.
//* IE: R, dR, d2R and C (evolute)
//* Returns list of vectors, [t,v(t)].

function Curve_Calc_Function(f)
{    
    let dt=Curve_Calc_dt();

    let t=Setup.Parameters.t1;
    
    
    let vs=[];
    for (let n=0;n<=Setup.Parameters.N;n++)
    {
        let ft=f(t);
        //if (ft)
        //{
            vs.push(   [t,ft]   );
        //}
        
        t+=dt;
    }

    return vs;
}


//Generic calculating functions.


//*
//* Numerical first derivative, do not make eps too small.
//* Symmetric derivative, o(eps^2).
//*

var dR=function(t,eps=1.0e-4)
{    
    let dr=Vector(
        [
            R(t+eps),
            -1,
            R(t-eps)
        ]
    );

    return Vector(  [ 1.0/(2.0*eps),dr ])
}


//*
//* Numerical second derivative, calls dR twice.
//*

var d2R=function(t,eps=1.0e-4)
{    
    let d2r=Vector(
        [
            dR(t+eps),
            -1,
            dR(t-eps)
        ]
    );

    return Vector(  [ 1.0/(2.0*eps),d2r ])
}


var dR_Hat=function(t)
{    
    let drt=dR(t);
    
    //console.log(drt,dR(t));
    return Vector_Hat(drt);
}

var Is_Singular=function(t,tole=1.0E-6)
{
    let res=false;
    
    if (Math.abs(v(t))<tole)
    {
        res=true;
    }

    return res;
}

var Is_Det_Singular=function(t,tole=1.0E-6)
{
    let res=false;
    
    if (Math.abs(d(t))<tole)
    {
        res=true;
    }

    return res;
}

var Evolute=function(t)
{
    if (Is_Singular(t))
    {
        return R(t);
    }
    
    return Vector
    (
        [
            1,R(t),
            nu(t),dR_Hat(t)
        ]
    );
}

var T=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    let vt=v(t);
    
    return Vector( [1.0/vt, dR(t)]);
}

var N=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    
    return Vector_Hat(T(t));
}

//*Frenet system, R,T,N.

var F=function(t)
{
    return [
        R(t),T(t),N(t),
    ];
}


var dT=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    return Vector( [omega(t), T(t)]);
}


var dN=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    return Vector( [-omega(t), N(t)]);
}

var v2=function(t)
{
    let dr=dR(t);

    return Vector_Length2(dr);
}

var v=function(t)
{
    return Math.sqrt(v2(t));
}

//*
//* Determinant
//*

var d=function(t)
{
    let drn=dR_Hat(t);
    let d2r=d2R(t);

    return Vector_Dot(drn,d2r);
}


//*
//* Angular velocity
//*

var omega=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    return d(t)/v2(t);
}

//*
//* Angular frequency, 1/omega
//*

var nu=function(t)
{
    if (Is_Det_Singular(t))
    {
        return false;
    }

    let v2t=v2(t);
    
    return v2(t)/d(t);
}

//*
//* Curvature ratio
//*

var rho=function(t)
{
    if (Is_Det_Singular(t))
    {
        return false;
    }
    
    return Math.pow(v2(t),1.5)/d(t);
}

//*
//* Curvature
//*

var kappa=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    return d(t)/Math.pow(v2(t),1.5);
}



//*
//* Natural Angle, Numerical
//*

var theta=function(t)
{
    if (Is_Singular(t))
    {
        return false;
    }
    
    let tt=T(t);
    
    return Math.atan2(tt[0],tt[1]);
}

