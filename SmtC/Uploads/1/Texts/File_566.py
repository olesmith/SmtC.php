#!/usr/bin/python3

from Polynomial import *
from Matrix import *

##!
##! Calculates Lagrange factor no i (x-x_0) ... (x-x_i-1) (x-x_i+1) ... (x-x_n)
##!
##! i index
##! xs list of abscissas,ys list of ordinates.
##!

def Lagrange_Factor(i,xs,x):
    product=1.0
    for j in range( len(xs) ):
        if (i!=j): product*=(x-xs[j])
    
    return product

##!
##! Calculates value of Lagrange Polynomials no i in point x.
##!

def Lagrange_H(i,xs,x):
    return Lagrange_Factor(i,xs,x)/Lagrange_Factor(i,xs,xs[i])

##!
##! Calculates value of Lagrange Interpolation Polynomial in point x
##!

def Lagrange_Y(xs,ys,x):
    sum=0.0
    for i in range( len(xs) ):
        sum+=ys[i]*Lagrange_H(i,xs,x)
        
    return sum

##!
##! Calculates the Lagrange Polynomial as list
##!

def Lagrange_H_P(i,xs):
    pol=[1.0]
    for j in range( len(xs) ):
        if (i!=j):
            pol=Polynomias_Mult(pol,[-xs[j],1.0])

    factor=Polynomia_Calc(pol,xs[i])
    
    return Polynomia_Mult(pol,1.0/factor)


##!
##! Calculates the Lagrange Interpolating Polynomial as list
##!

def Lagrange_P(xs,ys):
    P=[0.0]
    for k in range( len(xs) ):
        P_k=Lagrange_H_P(k,xs)
        P_k=Polynomia_Mult(P_k,ys[k])

        P=Polynomias_Add(P,P_k)
    
    return P

##!
##! Calculates list of Lagrange Polynomials, list of Polynomial lists.
##!

def Lagrange_Ps(xs,ys):
    Ps=[]
    for k in range( len(xs) ):
        P_k=Lagrange_H_P(k,xs)
        P_k=Polynomia_Mult(P_k,ys[k])
        
        Ps.append(P_k)
    
    return Ps

##!
##! Tests La Grange pol, comparing values and xs/ys.
##!

def Lagrange_P_Test_Table(P,xs,ys,eps=1.0E-6):
    maxval=-1.0
    for y in ys: maxval=max(maxval,abs(y))

    table=[]
    table.append(["$x$","$y$","$y*$","$|y-y*|$","$r$"])
    res=True
    for i in range( len(xs) ):
        x=xs[i]
        y=ys[i]

        y_pol=Polynomia_Calc(P,x)

        rel_error=abs(y-y_pol)/maxval
        table.append([
            "%.2f" % x,
            "%.2f" % y,
            "%.2f" % y_pol,
            "%.2e" % (y-y_pol),
            "%.2e" % rel_error,
        ])

    return table

##!
##! TikZ of Lagrange.
##!

def Lagrange_TikZ(P,xs,ys,r=1,N=100):
    tikzname="Lagrange_Fig.tikz.tex"
    x_min=min(xs)
    x_max=max(xs)

    dx=x_max-x_min

    x_min-=0.1*dx
    x_max+=0.1*dx
    
    y_min=min(ys)
    y_max=max(ys)

    dy=y_max-y_min

    y_min-=0.05*dy
    y_max+=0.05*dy

    tikz=[
        "%Draw Polynomia",
        Polynomia_TikZ_Draw(P,x_min,x_max,N),
        "",
        "%Draw Given Points",
        "",
    ]
     
    for i in range(len(xs)):
        tikz.append(
            " ".join([
                "\\filldraw",
                Latex_Tikz_Point([xs[i],ys[i]]),
                "circle("+str(r)+"pt)",
                ";"
            ])
        )

    tikz=[
        #"\\begin{center}",
        "\\begin{tikzpicture}",

        "%%clip picture",
        " ".join([
            "\\clip",
            Latex_Tikz_Point([x_min,y_min]),
            "rectangle",
            Latex_Tikz_Point([dx,0.75*dy])+";",
        ]),
        
        "%%X axis",
        " ".join([
        "\\draw[-latex]",
        Latex_Tikz_Point([x_min,0]),
            "--",
            Latex_Tikz_Point([x_max,0]),
            "node[right] {$x$};",
        ]),

        "%%Y axis",
        " ".join([
        "\\draw[-latex]",
            Latex_Tikz_Point([0,y_min]),
            "--",
            Latex_Tikz_Point([0,y_max]),
            "node[above] {$y$};",
        ]),

        
        tikz,
        "\\end{tikzpicture}",
        #"\\end{center}",
        "",
    ]

    tikz=Latex_Text(tikz)

    Latex_TikZ_Run(
        tikzname,
        tikz,
        gen_svg=True
    )

    pdfname=re.sub('(\.tikz)?\.tex$',".pdf",tikzname)

    latex=[]    
    if (os.path.isfile(pdfname)):
        latex=[    
            "\\begin{center}",
            "\\includegraphics{"+pdfname+"}",
            "\\end{center}",
        ]

    return latex
  
##!
##! TikZ of Lagrange.
##!

def Lagrange_Latex(P,xs,ys,r=1,N=100):

    Ps=Lagrange_Ps(xs,ys)
    
    latex=[
        "Interploating Polynomias:",
    ]

    for k in range(   len(Ps)   ):
        latex.append(
            Latex_Math([
                "H_{"+str(k)+"}=",
                Polynomia_Latex(Ps[k]),
            ])
        )

    latex=latex+[
        "Langrange Polynomia:",
        Latex_Math([
            "P_{"+str(len(xs))+"}=",
            Polynomia_Latex(P),
        ])
    ]
       
    latex=latex+[
        Latex_Table(
            Lagrange_P_Test_Table(P,xs,ys)
        )
    ]
    
    latex=latex+Lagrange_TikZ(P,xs,ys)
    
    return Latex_Text(latex)

 
##!
##! To keep SmtC happy.
##!

def dummy():
    return 0

###!
###! Testing ###
###!
###!

if (__name__=='__main__'):
    xs=[-3.0,-2.0,-1.0, 0.0, 1.0, 2.0, 3.0]
    ys=[-4.0,-1.0,-2.0, 2.0, 3.0, 5.0, 1.0]

    P=Lagrange_P(xs,ys)
    latex=Lagrange_Latex(P,xs,ys)
    
    Latex_Run("Lagrange.tex",latex)
    print( "\n".join(latex) )
