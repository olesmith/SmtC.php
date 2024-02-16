#!/usr/bin/python3

from math import *

##!
##! Calculate factorial
##!

def Factorial(n):
    if (n<0): return 0.0
    
    value=1
    for i in range(n):
        value*=(i+1)

    return value

##!
##! Calculate value of taylor polynomium
##! with coeficients a(i): Must be a function def.
##!

def Pol_Taylor(a,x,n):
    value=0
    xi=1.0

    for i in range(n+1):
        #value+=a(i)*(x**i): ineficient
        
        value+=a(i)*xi
        xi*=x

    return value

##!
##! Prints table of function/taylor polynomials (0...N)
##! values in fixed point, x.
##! f and a must de functions (def).
##!
##! Usage: Function_Taylor_Table_X(f5,a5,10,0.5)
##!

def Function_Taylor_Table_X(f,a,N,x):
    for n in range(N):
        val_ana=f(x)
        val_tay=Pol_Taylor(a,x,n)

        #absolute error
        error=val_ana-val_tay
        
        #relative error
        error=abs(error/val_ana)

        print( "%d\t%.6f\t%.6f\t%.6f\t%.6e" % (n,x,val_ana,val_tay,error) )

##!
##! Returns list of [x,p_n(x)] values of
##! Taylor polynomium with coefficents a(n)
##!

def Taylor_Pol_Values(a,n,x1,x2,N,maxval=None,dN=1):
    dx=(x2-x1)/(1.0*N)

    x=x1

    fxs=[]
    for i in range(N+1):
        pt=Pol_Taylor(a,x,n)

        #probably diverges for larger x-values
        if (maxval and pt>maxval): break
        
        fxs.append([x,pt])

        x+=dx

    return fxs


##!
##! Returns list of [x,p_n(x)] values of
##! Taylor polynomium with coefficents a(n)
##!

def Function_Values(f,x1,x2,N):
    dx=(x2-x1)/(1.0*N)

    x=x1

    fxs=[]
    for i in range(N+1):
        fxs.append([x,f(x)])

        x+=dx

    return fxs


