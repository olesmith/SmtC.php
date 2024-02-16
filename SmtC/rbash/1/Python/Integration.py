#!/usr/bin/python3

from math import *

from Latex import *

##!
##! Trapezoid formula: 2 calls to f(x).
##!

def Trapezoid(f,x0,x1):
    return 0.5*(x1-x0)*(f(x0)+f(x1))

##!
##! Repeat Trapezoid:
##!
##! Divide in [x0,xn] in n intervals and sum contributions from Trapezoid.
##! 2*n calls to f(x).
##!

def Trapezoids_1(f,x0,xn,n=100):

    h=(xn-x0)/(1.0*n)
    
    trapez=0.0
    x=x0
    for i in range(n):
        trapez+=Trapezoid(f,x,x+h)
        x+=h

    return trapez


##!
##! Repeated Trapezoids:
##!
##! Divide in [x0,xn] in n intervals and sum.
##! n+1 calls to f(x).
##!

def Trapezoids_Repeated(f,x0,xn,n=100):

    h=(xn-x0)/(1.0*n)
    
    trapez=0.5*f(x0)
    x=x0+h
    for i in range(1,n):
        trapez+=f(x)
        x+=h
        
    trapez+=0.5*f(xn)
    
    return h*trapez
    
##!
##! Simpsons 1/3 rule. 3 calls to f(x).
##! 3 calls to f(x).
##!

def Simpson(f,x0,x2):
    x1=0.5*(x0+x2)
    simp=f(x0)+4.0*f(x1)+f(x2)
    
    return simp*(x2-x1)/3.0

##!
##! Repeat Simpson:
##!
##! Divide in [x0,x1] em n intervals and sum Simpson().
##! 3*n calls to f(x).
##!

def Simpsons_1(f,x0,x2,n=100):

    h=(x2-x0)/(1.0*n)
    
    simpson=0.0
    x=x0
    for i in range(n):
        simpson+=Simpson(f,x,x+h)
        x+=h

    return simpson
    
##!
##! Repeated Simpson.
##! 2*n-1 calls to f(x).
##!

def Simpsons_Repeated(f,x0,x2n,n=100):
    
    dx=(x2n-x0)/(1.0*n)
    h=dx*0.5

    simpson=f(x0)+f(x2n)
    
    x=x0+h
    for i in range(n):
        simpson+=4.0*f(x)
        x+=dx
    
    x=x0+dx
    for i in range(1,n):        
        simpson+=2.0*f(x)
        x+=dx


    return h*simpson/3.0


##!
##! Test the four integration approximations with n subintervals.
##!

def Integration_Test(f,F,x0,x1,n):
    value=F(x1)-F(x0)
    
    value_t=Trapezoids_1(f,x0,x1,n)
    value_t_r=Trapezoids_Repeated(f,x0,x1,n)

    value_s=Simpsons_1(f,x0,x1,n)
    value_s_r=Simpsons_Repeated(f,x0,x1,n)

    r_t=abs( (value_t-value)/value )
    r_t_r=abs( (value_t_r-value)/value )
    r_s=abs( (value_s-value)/value )
    r_s_r=abs( (value_s_r-value)/value )
        
    return [
        n,
        "%.6f" % value_t,
        "%.2e" % r_t,
        "%.6f" % value_t_r,
        "%.2e" % r_t_r,
        "%.6f" % value_s,
        "%.2e" % r_s,
        "%.6f" % value_s_r,
        "%.2e" % r_s_r,
    ]

##!
##! Test the four integration approximations with n subintervals for n=1,...,N.
##!

def Integration_Tests(f,F,x0,x1,N=20):
    table=[
        [
            "$n$",
        
            "$I_{trapez}$","${\\varepsilon}_{trapez}$",
            "$I_{trapez}^{repeat}$","${\\varepsilon}_{trapez}^{repeat}$",
            "$I_{simp}$","${\\varepsilon}_{simp}$",
            "$I_{simp}^{repeat}$","${\\varepsilon}_{simp}^{repeat}$",
        ]
    ]
    
    for n in range(1,20):
        table.append(
            Integration_Test(f,F,x0,x1,n)
        )

    return table

##!
##! Test and generate Latex
##!

def Integration_Tests_Latex(fname,f,F,x0,x1,N=20):
    latex=[
        Latex_Math([
            "I=\\int_{"+str(x0)+"}^{"+str(x1)+"}"+fname+"~dx",
            "=",
            str(F(x1)-F(x0))
        ]),
        Latex_Table(
            Integration_Tests(f,F,x0,x1,20)
        ),
        "\\clearpage\n\n",
    ]

    return Latex_Text(latex)


 
if (__name__=="__main__"):
    
    def f1(x):
        return e**x

    def F1(x):
        return e**x

    def f2(x):
        return e**(3.0*x)

    def F2(x):
        return 1.0/3.0*e**(3.0*x)

    def f3(x):
        return e**(-3.0*x)

    def F3(x):
        return -1.0/3.0*e**(-3.0*x)

    x0=0.0
    x1=1.0

    latex=Integration_Tests_Latex("e^x",f1,F1,x0,x1,20)
    latex=latex+Integration_Tests_Latex("e^{3x}",f2,F2,x0,x1,20)
    latex=latex+Integration_Tests_Latex("e^{-3x}",f3,F3,x0,x1,20)

    Latex_Print(latex)
    
    Latex_Save("Integration.tex",latex)
