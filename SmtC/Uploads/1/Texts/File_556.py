#!/usr/bin/python3

from Vector import *
from Matrix import *


##!
##!
##!


def Gauss_Jacobi(A,b,x0,epsilon=1.0E-6,max_iterations=100,test=False):
    n=len(A)
    
    C,g=Gauss_Jacobi_C(A,b)


    xs=[x0]
    x=list(x0)

    convergence=False
    iteration=0
    while (iteration<max_iterations):
        iteration+=1

        
        x_new=[]
        for i in range(n):
            xi=g[i]
            for j in range(n):
                xi+=C[i][j]*x[j]

            x_new.append(xi)
        
        dx=Vectors_Sub(x,x_new)
        norm=Vector_Norm_Inf(dx)/Vector_Norm_Inf(x)

        xs.append(x_new)
        x=x_new
        

        if (norm<epsilon):
            convergence=True
            break

    
    #Calculate Resuidual vector and norm
    r=Matrix_Mult_Vector(A,x)
    r=Vectors_Sub(r,b)

    norm=Vector_Norm_Inf(r)/Vector_Norm_Inf(b)

    if (test):
        Gauss_Jacobi_Latex("Gauss_Jacobi.tex",A,b,C,g,xs,epsilon)
        
    return x,norm
      
##!
##! Calculate alpha vector for verifying convergence.
##!


def Gauss_Jacobi_Conv_Criteria(A):
    n=len(A)
        
    alpha=[]
    for i in range(n):
        alpha.append(0.0)
        for j in range(n):
            if (i!=j):
                alpha[i]+=abs(A[i][j])
        alpha[i]/=A[i][i]

    return alpha
        
##!
##! Populate C iteration matrix: Ax=b <=> x=Cx+g
##!


def Gauss_Jacobi_C(A,b):
    n=len(A)
    
    C=Matrix_Zero(n)
    g=list(b)

    for i in range(n):
        if (abs(A[i][i])>0.0):
            g[i]=b[i]/A[i][i]
        
            for j in range(n):
                if (i!=j):
                    C[i][j]=-A[i][j]/A[i][i]
    
    
    return C,g
      

##!
##!
##!


def Gauss_Jacobi_Latex(texname,A,b,C,g,xs,epsilon):
    n=len(A)

    latex=Gauss_Jacobi_Latex_PRE(A,b,C,g,xs)

    latex=latex+Gauss_Jacobi_Latex_Iterations(A,b,xs,epsilon)
    latex=latex+Gauss_Jacobi_Latex_POST(A,b,xs,epsilon)


    #Last is approx solution
    #x=xs[ len(xs)-1 ]
    latex=Latex_Environment("small",latex)
    latex=Latex_Text(latex)
    
    
    print( "\n".join(latex) )
    Latex_Save(texname,latex)

    return xs


##!
##!
##!


def Gauss_Jacobi_Latex_Iterations(A,b,xs,epsilon):
    n=len(A)

    latex=[]
    
    quad=";~~"

    norm=100.0 #something big,positive
    for iteration in range(   len(xs)   ):
        sub="{"+str(iteration)+"}"
        latex_eq=[
            "\\underline{x}_"+sub+"=",
            Vector_Latex(xs[ iteration ]),
            quad,
        ]
            
        #Calculate Resuidual vector and norm
        r=Matrix_Mult_Vector(A,xs[ iteration ])
        r=Vectors_Sub(r,b)

        r_norm=Vector_Norm_Inf(r)/Vector_Norm_Inf(b)
        latex_eq=latex_eq+[
            "\\underline{r}_"+sub+"=",
            "\\underline{\\underline{A}}~\\underline{x}_"+sub+"-",
            "\\underline{b}=",
            Vector_Latex(r,frmt="%.2E"),
            quad,
            "||",
            "\\underline{r}_"+sub,
            "||=",
            ("%.2E" % r_norm),
            quad,
        ]

        latex=latex+["Iteration "+str(iteration)+":"]
        latex=latex+Latex_Math(latex_eq)
        latex_eq=[]
        if (iteration>0):
            dx=Vectors_Sub(xs[ iteration ],xs[ iteration-1 ])
            
            norm=Vector_Norm_Inf(xs[ iteration-1 ])
            if (norm>0.0):
                norm=Vector_Norm_Inf(dx)/norm
        

            sub1="{"+str(iteration-1)+"}"
            
            latex_eq=latex_eq+[
                "\\underline{d}_"+sub+"=",
                "\\underline{x}_"+sub+"-",
                "\\underline{x}_"+sub1+"=",
                Vector_Latex(dx,frmt="%.2E"),
                quad,
                "||",
                "\\underline{d}_"+sub,
                "||=",
                ("%.2E" % norm)
            ]


        
            latex=latex+Latex_Math(latex_eq)

    return latex


##!
##! Matrix definitions
##!


def Gauss_Jacobi_Latex_PRE(A,b,C,g,xs):
    alpha=Gauss_Jacobi_Conv_Criteria(A)
    alpha_norm=Vector_Norm_Inf(alpha)

    dominant="No"
    
    if (alpha_norm<1): dominant="Yes"
 
    return [
        "\\begin{center}\\textbf{Gauss Jacobi:}\\end{center}",
        Latex_Math([
            "\\underline{\\underline{A}}~\\underline{x}=",
            Matrix_Latex(A),
            ["\\underline{x}="],
            Vector_Latex(b),
            "=\\underline{b}",
        ]),
        "Iterations:",
        Latex_Math([
            "\\underline{x}_{i+1}="
            "\\underline{\\underline{C}}~\\underline{x}_i+\\underline{g},",
        ]),
        "Where:",
        Latex_Math([
            Matrix_Latex(C,"C"),
            [";\\qquad"],
            Vector_Latex(g,"g"),
            [";\\qquad"],
            Vector_Latex(xs[0],"x_0"),
        ]),
        "Diagonally dominant: "+dominant,
        Latex_Math([
            Vector_Latex(alpha,"\\alpha"),
            [";\\qquad"],
            "||\\underline{\\alpha}||="+( "%0.6f" % alpha_norm ),
        ]),
    ]

##!
##! Result section
##!


def Gauss_Jacobi_Latex_POST(A,b,xs,epsilon):

    latex=[]
    iteration=len(xs)-1
    
    dx=Vectors_Sub(xs[ iteration-1 ],xs[ iteration ])
    norm=Vector_Norm_Inf(dx)/Vector_Norm_Inf(xs[ iteration-1 ])

    if (norm<=epsilon):
        latex.append(
            "Convergence, "+
            str(iteration)+
            " iterations: "+
            ("%.1E" % norm)+
            "<"+
            ("%.1E" % epsilon)
        )
    else:
        latex.append(
            "Unconverged through "+
            str(max_iterations)+
            " iterations"
        )

    #Last is approx solution
    x=xs[ len(xs)-1 ]
        
    #Calculate Resuidual vector and norm
    r=Matrix_Mult_Vector(A,x)
    r=Vectors_Sub(r,b)

    norm=Vector_Norm_Inf(r)/Vector_Norm_Inf(b)

    return latex+[
        Latex_Math([
            "\\underline{\\underline{A}}~\\underline{x}^*-\\underline{b}=",
            Matrix_Latex(A),
            Vector_Latex(x),
            "-",
            Vector_Latex(b),
            "=",
            Vector_Latex(r),
        ]),
        Latex_Math([
            "\\underline{x}^*=",
            Vector_Latex(x,frmt="%.1E"),
            ";\\qquad",
            Vector_Latex(r,"r",frmt="%.1E"),
            ";\\qquad",
            "||r||="+("%.1E" % norm)
        ]),
    ]
    
    
     

###!
###!
###! Testing ###
###!
###!

if (__name__=='__main__'):
    A=[
        [10.0,2.0,1.0],
        [1.0, 5.0,1.0],
        [2.0, 3.0,10.0],
    ]

    b=[7.0,-8.0,6.0]
    x0=[0.7,-1.6,0.6]
    
    Gauss_Jacobi(A,b,x0,max_iterations=100,test=True)
