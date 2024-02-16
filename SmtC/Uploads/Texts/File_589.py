#!/usr/bin/python3

from math import *

from Vector import *
from Matrix import *
from Gauss_Pivotation import *

##!
##! Implement Newtons method for nonlinear systems.
##!

##!
##! F: Function (def) returning the list of functions to be zeroed.
##! J: Function (def) returning the Jacobian.
##! x: Starting x, list.
##!

def Newton(F,J,x,eps1=1.0E-6,eps2=1.0E-6,max_iter=100):
    xs=[]
    ss=[]
    res=0

    k=1
    while (res==0 and k<=max_iter):
        res,x=Newton_Iteration(F,J,x,eps1,eps2)
        xs.append(x)

        k+=1
    return res,xs

##!
##! Do one Newton iteration
##!

def Newton_Iteration(F,J,x,eps1,eps2):
    Fx=F(x)

    res=0
    if (Vector_Norm_Inf(Fx)<eps1):
        res=1
    else:
        Jx=J(x)
        s=Vector_Mul(Fx,-1.0)
        Gauss_Pivotation(Jx,s)

        x=Vectors_Add(x,s)
        if (Vector_Norm_Inf(s)<eps2):
            res=2

    return res,x


##!
##! Gather Latex for Newton iterations
##!

def Newton_Latex(info,F_Latex,J_Latex,F,J,x,eps1,eps2):
    res,xs=Newton(F,J,x,eps1,eps2)
    
    latex=[
        Latex_Title("Newtons Method"),
        [
            "$\\bullet$",
            "\\textbf{"+info+"}",
        ],
        Latex_Math([
            "\\Vector{F}(\\underline{x})=",
            Vector_Latex(
                F_Latex(),options=""
            ),
            ";\\quad",
            "\\Vector{x}_0=",
            Vector_Latex(x),
        ]),
        Latex_Math([
            "\\Matrix{J}(\\underline{x})=",
            Matrix_Latex(
                J_Latex(),options=""
            )
        ]),
        Latex_Inline([
            "\\varepsilon_1="+("%.2e" % eps1)+",",
            "\\varepsilon_2="+("%.2e" % eps2)+".",            
        ]),
    ]
    
    table=[
        [
            "$k$",
            "$\\Vector{s}_k$",
            "$\\Vector{x}_k$",
            "$\\Matrix{J}(\\Vector{x}_k)$",
            "$\\Vector{F}(\\Vector{x}_k)$",
        ]
    ]
    
    for k in range(len(xs)):
        table.append(
            Newton_Latex_Iteration(F,J,x,xs,k)
        )

    latex=latex+Latex_Table(table)

    niterations=len(xs)
    eps1_val=Vector_Norm_Inf(
        Vectors_Sub(xs[niterations-1],xs[niterations-1])
    )
    eps2_val=Vector_Norm_Inf(
        F(xs[niterations-1])
    )

    if (eps2_val<=eps2):
        latex.append("Convergence.")
    elif (eps1_val<=eps1):
        latex.append("No further progress.")
    else:
        latex.append("Divergence.")

    latex=latex+[
        Latex_Math([
            "\\Vector{x}^*=",
            Vector_Latex(xs[niterations-1]),
            ";\\quad",
            "||\\Vector{s}^*||=",
            ("%.2e" % eps1_val),
            ";\\quad",
            "||\\Vector{F}(\\Vector{x}^*)||=",
            ("%.2e" % eps2_val)
        ])
    ]

    return latex+["\\clearpage\n\n"]
            
##!
##! Gather Latex row for one Newton iteration
##!

def Newton_Latex_Iteration(F,J,x,xs,k):
    s=[]
    if (k>0):
        s=Vectors_Sub(xs[k],xs[k-1])
    else:
        s=Vectors_Sub(x,xs[k])

    
    return [
        str(k+1),
        Latex_Inline([
            Vector_Latex(s,frmt="%.10f"),
        ]),
        Latex_Inline([
            Vector_Latex(xs[k],frmt="%.10f"),
        ]),
        Latex_Inline([
            Matrix_Latex(J(xs[k]),frmt="%.10f"),
        ]),
        Latex_Inline([
            Vector_Latex(F(xs[k]),frmt="%.2e"),
        ]),
    ]


#Ruggiero, Example 5, p. 199.
def F1(x):
    return [
        x[0]+x[1]-3.0,
        x[0]**2+x[1]**2-9.0,
    ]


def J1(x):
    return [
        [
            1.0,1.0
        ],
        [
            2.0*x[0],2.0*x[1]
        ],
    ]
    
def F1_Latex():
    return [
        "x_0+x_1-3",
        "x_0^2+x_1^2-9",
    ]
    
def J1_Latex():
    return [
        ["1","1"],
        ["2x_0","2x_1"]
    ]


#Ruggiero, Exercise 2.a, p. 205.
def F2(x):
    return [
        x[0]**2+x[1]**2-2.0,
        e**(x[0]-1.0)+x[1]**3-2.0,
    ]


def J2(x):
    return [
        [
            2.0*x[0],2.0*x[1]
        ],
        [
            e**(x[0]-1.0),3.0*x[1]**2
        ],
    ]
    
def F2_Latex():
    return [
        "x_0^2+x_1^2-2",
        "e^{x_0-1}+x_1^3-2",
    ]
    
def J2_Latex():
    return [
        ["2x_0","2x_1"],
        ["e^{x_0-1}","3x_1^2"],
    ]
    
#Ruggiero, Exercise 2.b, p. 205.
def F3(x):
    return [
        4.0*x[0]-x[0]**3+x[1],
        -x[0]**2/9.0+x[1]-0.25*x[1]**2+1.0
    ]


def J3(x):
    return [
        [
            4.0-3.0*x[0]**2,1.0
        ],
        [
            -2.0/9.0*x[0],1.0-0.5*x[1]
        ],
    ]
    
def F3_Latex():
    return [
        "4x_0-x_0^3+x_1",
        "-\\frac{1}{9}x_0^2+x_1-\\frac{1}{4} x_1^2+1",
    ]
    
def J3_Latex():
    return [
        ["4-3x_0^2","1"],
        ["-\\frac{2}{9}x_0","1-\\frac{1}{2}x_1"],
    ]
    
#Ruggiero, Exercise 2.c, p. 205.
def F4(x):
    return [
        (2.0*x[0]-x[0]**2+8)/9.0    +   x[1]-0.25*x[1]**2,
        8.0*x[0]-4.0+x[0]**2   +   x[1]**2+1.0
    ]


def J4(x):
    return [
        [
            (2.0-2.0*x[0])/9.0,
            1-0.5*x[1]
        ],
        [
            8.0-8.0*x[0],
            2.0*x[1]
        ],
    ]
    
def F4_Latex():
    return [
        "\\frac{1}{9}(2x_0-x_0^2+8)+\\frac{1}{4}(4x_1-x_1^2)",
        "8x_0-4x_0^2+x_1^2+1",
    ]
    
def J4_Latex():
    return [
        [
            "\\frac{1}{9}(2-2x_0)",
            "1-\\frac{1}{2}x_1"
        ],
        [
            "8-8x_0",
            "2x_1"
        ],
    ]
    
    
#Ruggiero, Exercise 2.d, p. 205 (Rosenbrock).
def F5(x):
    return [
        10.0*(x[1]-x[0]**2),
        1.0-x[0]
    ]


def J5(x):
    return [
        [
            -20.0*x[0],
            10.0
        ],
        [
            -1.0,
            0.0
        ],
    ]
    
def F5_Latex():
    return [
        "10(x_1-x_0^2)",
        "1-x_0",
    ]
    
def J5_Latex():
    return [
        [
            "-20x_0",
            "10",
        ],
        [
            "-1",
            "0",
        ],
    ]
    
    
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

    eps1=eps2=1.0E-6
        
    latex=[]
    
    x1=[1.0,5.0]
    latex=latex+Newton_Latex(
            "Ruggiero, Example 5, p. 199",
            F1_Latex,J1_Latex,
            F1,J1,x1,
            eps1,eps2
    )

    x2=[1.5,2.0]
    latex=latex+Newton_Latex(
            "Ruggiero, Exercise 2.a, p. 205",
            F2_Latex,J2_Latex,
            F2,J2,x2,
            eps1,eps2
    )
    
    x3=[-1,-2.0]
    latex=latex+Newton_Latex(
            "Ruggiero, Exercise 2.b, p. 205",
            F3_Latex,J3_Latex,
            F3,J3,x3,
            eps1,eps2
    )
    
    x4=[-1,-1.0]
    latex=latex+Newton_Latex(
            "Ruggiero, Exercise 2.c, p. 205",
            F4_Latex,J4_Latex,
            F4,J4,x4,
            eps1,eps2
    )
    
    x5=[-1.2,1.0]
    latex=latex+Newton_Latex(
            "Ruggiero, Exercise 2.d (Rosenbrock), p. 205",
            F5_Latex,J5_Latex,
            F5,J5,x5,
            eps1,eps2
    )
    
    latex=latex+["\\lstinputlisting{Newton.py}"]

    latex=Latex_Print(latex)
    
    Latex_Save("Newton.tex",latex)
