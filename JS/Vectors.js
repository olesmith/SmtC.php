"use strict";

function Vector(vs,factor=1.0)
{
    let v=[];
    for (let n=0;n<vs.length;n++)
    {
        if ((typeof vs[n])=='number')
        {
            factor=vs[n];
        }
        else
        {
            for (let m=0;m<vs[n].length;m++)
            {
                if ((typeof v[m])!='number')
                {
                    v[m]=0.0;
                }
                
                v[m]+=factor*vs[n][m];
            }
        }
    }

    return v;
}
function Vector_Convex(v1,v2,t)
{
    let tt=1.0-t;
    let v=[];
    for (let n=0;n<v1.length;n++)
    {
        v[n]=tt*v1[n]+t*v2[n];
    }

    return v;
}


function Vector_Dot(u,v)
{
    let dot=0;
    for (let n=0;n<u.length;n++)
    {
        dot+=u[n]*v[n];
    }

    return dot;
}

function Vector_Length2(v)
{
    return Vector_Dot(v,v);
}

function Vector_Length(v)
{
    let dot=Vector_Dot(v,v);

    return Math.sqrt(dot);
}

function Vector_Angle(v,degrees=false)
{
    let angle=Math.atan2(v[0],v[1])

    if (degrees)
    {
        angle=180/Math.PI*angle;
    }
    
    return angle;
}

function Vector_Angle_SVG(v)
{
    return 90.0-Vector_Angle(v,true);
}


function Point_Is(p)
{
    if
        (
            Array.isArray(p)
            &&
            typeof p[0] === 'number'
            &&
            typeof p[1] === 'number'
        )
    {
        return true;
    }

    return false;
}

function Points_Are(p1,p2)
{
    if (Point_Is(p1) && Point_Is(p2))
    {
        return true;
    }

    return false;
}
function Points_Dist(p1,p2)
{
    let dist=1.0;
    if (Point_Is(p1) && Point_Is(p2))
    {
        let v=Vector([p1,-1,p2]);

        dist=Vector_Len(v);
    }

    return dist;
}

function Vector_Len(v)
{
    return Math.sqrt(   Vector_Dot(v,v)   );
}

function Vector_Unit(v,scale=1.0)
{
    let len=Vector_Len(v);

    return Vector([scale/len,v]);
}


//The hat vector

function Vector_Hat(v)
{
    return [ -v[1],v[0] ];
}


//Rotation vectors, e and f.

function e_i()
{    
    return [ 1,0 ];
}

function e_j()
{
    return [ 0,1 ];
}

//Rotation vectors, e and f.

function e_t(t,omega=false)
{    
    if (omega) { t=omega*t; }
    
    return [ Math.cos(t),Math.sin(t) ];
}

function f_t(t,omega=false)
{
    if (omega) { t=omega*t; }
    
    return [ -Math.sin(t),Math.cos(t) ];
}




//Rotation vectors, p and q.

function p_t(t,omega=false)
{    
    if (omega) { t=omega*t; }
    
    return [ -Math.cos(t),Math.sin(t) ];
}

function q_t(t,omega=false)
{
    if (omega) { t=omega*t; }
    
    return [ -Math.sin(t),-Math.cos(t) ];
}

function Matrix_Transpose(matrix)
{
    let R=matrix.length;
    let S=matrix[0].length;

    let trans=[];
    for (let s=0;s<S;s++)
    {
        let col=[];
        for (let r=0;r<R;r++)
        {
            col.push(matrix[r][s]);
        }

        trans.push(col);
    }

    return trans;
}

function Element_2_Point(element)
{
    let p=null;
    if (element.tagName === "circle")
    {
        p=
        [
            parseFloat(element.getAttributeNS("","cx")),
            parseFloat(element.getAttributeNS("","cy")),
        ];
    }
    //console.log(p);

    return p;
}

