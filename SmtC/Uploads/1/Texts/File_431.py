#!/usr/bin/python3

from math import *

##!
##! sin(x)
##!

def f4(x):
    return sin(x)

def a4(n):
    if (   (n%2)==1   ):
        value=1.0/(1.0*Factorial(n))
        
        if (   (n%4)==1   ):
            return value
        else:
            return -value
    else:
        return 0.0
    
