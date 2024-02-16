#!/usr/bin/python3

import os
from math import *

from Latex import *
from TikZ import *
from Integration import *

##!
##! Calculate arc lengths in each (N+1) point.
##!

def TS_Calc(f,t0,t1,N):
    dt=(t1-t0)/(1.0*N)

    t=t0
    s=0.0

    ts=[[t0,0.0]]
    for n in range(N):
        tt=t+dt

        ds=Trapezoid(f,t,tt)
        s+=ds

        ts.append([tt,s])

        t=tt
        
    return ts

##!
##! Calculate inverse values, t(s), natural parametrization.
##!

def STs_Calc(ts):
    N=len(ts)
    
    s0=ts[0][1]
    s1=ts[len(ts)-1][1]

    ds=(s1-s0)/(1.0*N)

    #First point, s=s0
    sts=[
        [ ts[0][0],s0 ]
    ]
    
    s=s0+ds
    for n in range(1,N):
        ss=s+ds

        t=ST_Calc(ts,s,ss)

        sts.append([ t,s ])

        s=ss

    #Last point, s=s1
    sts.append(
        [ ts[-1][0],s1 ]
    )
    
    return sts
        
##!
##! Calculate inverse value, t(s), natural parametrization.
##! Locates intervl, so that s
##!

def ST_Calc(ts,s,ss):
    N=len(ts)-1

    for n0 in range(N+1):
        n1=n0+1
        if ( s>=ts[n0][1] and s<=ts[n1][1]):
            t0,s0=ts[n0][0],ts[n0][1]
            t1,s1=ts[n1][0],ts[n1][1]

            dt=t1-t0
            eta=(s-s0)/(s1-s0)

            return t0+eta*dt

    print("no t(s)",s,ss)

    return ts[len(ts)-1][1]


#Document with latex/tikz code

##!
##! Produce latex table with t-s values.
##!

def TS_Latex_Tables(a,b,ts,st,max_rows=40):
    N=len(ts)-1
    
    thead=[
        "$n$","$t_n$","$ds(t_n)$","$s(t_n)$",
    ]
    latex=[
        Latex_Title("Ellipse, Natural Parametrization"),
        "Equation:",
        Latex_Math([
            "\\left(\\frac{x}{a}\\right)^2",
            "+",
            "\\left(\\frac{y}{b}\\right)^2",
            "=1",
        ]),
        "Parametrization:",
        Latex_Math([
            "\\begin{pmatrix}",
            "   x(t)\\\\y(t)",
            "\\end{pmatrix}=",
            "a"
            "\\begin{pmatrix}",
            "   \\cos{t}\\\\ \\epsilon \\sin{t}",
            "\\end{pmatrix},",
        ]),
        Latex_Inline(["\\epsilon=\\frac{b}{a}."]),

        "Take: $a="+str(a)+"$, $b="+str(b)+"$.",
        Latex_Title(
            "Arc Length by Numerical Integration: $N="+
            str(N)+
            "$ Intervals"
        ),
        
    ]
    table=[thead]
    
    for n in range(len(ts)):
        ds="-"
        if (n+1<len(ts)):
            ds=ts[n+1][1]-ts[n][1]
        
        table.append([
            str(n),str(ts[n][0]),
            str(ds),
            str(ts[n][1]),
        ])
        
        if (len(table)>max_rows):
            latex.append(
                Latex_Table(table)
            )

            #New list!
            table=list([thead])
    
    if (len(table)>1):
        latex.append(
            Latex_Table(table)

        )


    tikzname="Ellipse_TS.tikz.tex"
    
    #Generate tikz fig and include as PDF, if existent.
    tikz=TS_TikZ_Draw(ts,st)
    
    TikZ_Save(
        tikzname,
        TS_TikZ_Draw(ts,st)
    )
    
    latex.append(
        TikZ_Includegraphics(tikzname)
    )

    return latex


##!
##! Produce latex table with t's for equidistant s-values.
##!

def ST_Latex_Tables(ts,st,max_rows=40):
    thead=[
        "$n$","$s_n$","$s_n-s_{n-1}$","$t_n$",
    ]
    
    latex=[
        Latex_Title("Natural Parametrization, Equidistante $s(t_i)$"),
    ]
    table=[thead]
    
    for n in range(len(st)):

        ds="-"
        if (n>0):
            ds=str(st[n][1]-st[n-1][1])
        
        table.append([
            str(n),
            str(st[n][1]),
            str(ds),
            str(st[n][0]),
        ])
        
        if (len(table)>max_rows):
            latex.append(
                Latex_Table(table)
            )

            #New list!
            table=list([thead])
    
    if (len(table)>1):
        latex.append(
            Latex_Table(table)

        )



    #Generate and save tikz fig
    tikzname="Ellipse_Natural.tikz.tex"
    TikZ_Save(
        tikzname,
        TS_TikZ_Ellipse_Natural(2*a,2*b,st)
    )
    
    #Include tikz fig  as PDF, if existent.
    latex.append(
        TikZ_Includegraphics(tikzname)
    )

    return latex

##!
##! Generate TikZ of ellipse natural parametrization.
##!

def TS_TikZ_Ellipse_Natural(a,b,st):
    
    tikz=[
        TikZ_Coordinate_System(
            [ -1.2*a,-1.2*b ],
            [  1.2*a, 1.2*b ],
            "-latex","$x(t)$","$y(t)$"
        ),
        "\\draw (0,0) ellipse("+str(a)+" and "+str(b)+");"
    ]

    n=0
    for p in st:
        pt=Ellipse(p[0],a,b)
        ptt=Ellipse(p[0],1.1*a,1.1*b)

        tikz=tikz+[
            "\\filldraw[blue]",
            TikZ_Point(pt)+" circle(1pt);",
            "\\node[blue] at ",
            TikZ_Point(ptt)+" {\\tiny{$t_{"+str(n)+"}$}};",
        ]

        n+=1
        

    return tikz

    
##!
##! Generate TikZ drawing of ts: segments and points.
##!

def TS_TikZ_Draw(ts,st):

    p_last=ts[ len(ts)-1 ]

    s="%.6f" % p_last[1]
    
    tikz=[
        TikZ_Coordinate_System(
            [ ts[0][0],ts[0][1] ],
            [ ts[len(ts)-1][0],ts[len(ts)-1][1] ],
            "-latex","$t$","$s(t)$"
        ),
        
        TikZ_Points(ts,draw_points=True),
        TikZ_Node(p_last,"right","$s="+s+"$"),
    ]

    delta=0.25

    n=0
    for p in st:
        pleft=[-delta,p[1]]
        pbottom=[p[0],-delta]
        tikz=tikz+TikZ_Points(
            [
                pleft,p,pbottom
            ],
            "dotted,blue"
        )+TikZ_Node(
            pbottom,
            "below,blue",
            "\\tiny{$"+str(n)+"$}"
        )

        n+=1
    
    return tikz

a=1.0
b=2.0
l=b/a
eps1=l**2-1.0

def Ellipse(t,aa=None,bb=None):
    if (aa==None): aa=a
    if (bb==None): bb=b
    return [aa*cos(t),bb*sin(t)]

def v_Ellipse(t):
   return a*sqrt(  1+eps1*cos(t)**2 )



####! Parameters

NP=40
N=20
t0=0.0
t1=2.0*pi
dt=(t1-t0)/(1.0*N)

####! Do the job!

ts=TS_Calc(v_Ellipse,t0,t1,N)
st=STs_Calc(ts)

latex=[]

latex=latex+TS_Latex_Tables(a,b,ts,st,max_rows=40)
latex=latex+["\\clearpage"]
latex=latex+ST_Latex_Tables(ts,st,max_rows=40)

Latex_Save("Ellipse.tex",latex)

    
