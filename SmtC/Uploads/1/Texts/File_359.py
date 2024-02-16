
from math import *

def Function_Table(N,xl,xu,f):
    dx=(xu-xl)/N
    x=xl
    for n in range(N+1):
        y=f(x)
        print ("{:.0f}\t{:.4f}\t{:.4f}".format(n,x,y))
        x=x+dx

##!
##! Cosh(x)
##!
def f1(x):
    return 0.5*(pow(e,x)+pow(e,-x))

##!
##! Sinh(x)
##!
def f2(x):
    return 0.5*(pow(e,x)-pow(e,-x))

print("Cosh")
Function_Table(20,-2.0,2.0,f1)

print("Sinh")
Function_Table(20,-2.0,2.0,f2)
