#!/usr/bin/python3

from math import *

from Pol_Taylor import *


#Function_Taylor_Table_X(f1,a1,10,0.5)

##!
##! Tikz function f in interval x1-x2.
##!

def Function_Values_TikZ(fxs,options="",title=None):
    pts=[]
    for i in range(len(fxs)):
        pt="("+str(fxs[i][0])+","+str(fxs[i][1])+")"
        
        pts.append(pt)

    if (title):
        pts[ len(fxs)-1 ]+=" node[right] {\\tiny{$"+title+"$}}"
        
    return "\\draw["+options+"]\n"+"   --\n".join(pts)+";"


    
##!
##! Tikz function f and tylor polynomias in interval x1-x2.
##!

def Taylor_Polynomials_TikZ(f,a,n,x1,x2,ymax,dn=1):
    tikz=[]

    color="blue"

    color1=[255,165,0]
    color2=[0,255,255]
    
    tikz.append("%%Function f to approximate by taylor polynomias")
    
    fxs=Function_Values(f,x1,x2,N)
    tikz_f=Function_Values_TikZ(fxs,color+",very thick")
    tikz.append(tikz_f)
    
    dcolor=1.0*dn/(1.0*n)

    letters=[
        "a","b","c","d","e","f",
        "h","i","j","k","l","m",
        "n","o","p","q","r","s",
        "t","u","v","x","y","z",
    ]

    color=0
    for i in range(0,n+1,dn):
        col=Colors_Mix(color,color1,color2)
        color_name="drw"+letters[i]
        
        color_define="".join([
            "\\definecolor{"+color_name+"}{RGB}",
            "{"+str(col[0])+","+str(col[1])+","+str(col[2])+"}",
        ])
        
        tikz.append(color_define)
        
        fxs=Taylor_Pol_Values(a,i,x1,x2,N,ymax)

        options="color="+color_name
        tikz_f=Function_Values_TikZ(fxs,options,"n="+str(i))
        
        tikz.append("%%Taylor polynomia no "+str(i))
    
        tikz.append(tikz_f)

        color+=dcolor

    return tikz



def Colors_Mix(p,col1,col2):
    col=[]
    for i in range(len(col1)):
        col.append( round(p*col1[i]+(1.0-p)*col2[i]) )

    return col

##!
##! e^x
##!

def f1(x):
    return e**x

def a1(n):
    return 1.0/(1.0*Factorial(n))

##!
##! cos(x)
##!

def f2(x):
    return cos(x)

def a2(n):
    if (   (n%2)==0   ):
        value=1.0/(1.0*Factorial(n))
        
        if (   (n%4)==0   ):
            return value
        else:
            return -value
    else:
        return 0.0


x1=0.0
x2=2*pi
ymax=1.5

N=100

#Coordinate system
Min=[-0.25,   -1.25]
Max=[ 2.25*pi, 1.5]

D=[Max[0]-Min[0],Max[1]-Min[1]]

tikz=[
    " ".join([
        "\\clip",
        "("+str(Min[0])+","+str(Min[1])+")",
        "rectangle",
        "("+str(1.1*D[0])+","+str(1.1*D[1])+");"
    ]),
    
    " ".join([
        "\\draw[-latex]",
        "("+str(Min[0])+","+str(0.0)+")",
        "--",
        "("+str(Max[0])+","+str(0.0)+")",
        "node[right] {$x$};"
    ]),
    
    " ".join([
        "\\draw[-latex]",
        "("+str(0.0)+","+str(Min[1])+")",
        "--",
        "("+str(0.0)+","+str(Max[1])+")",
        "node[above] {$y$};"
    ]),
]

tikz=tikz+Taylor_Polynomials_TikZ(f2,a2,20,x1,x2,ymax,2)

print(  "\n".join(tikz) )
