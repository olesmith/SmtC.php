#!/usr/bin/python3

from math import *

##!
##! cos(x)
##!

def f3(x):
    return cos(x)

def a3(n):
    if (   (n%2)==0   ):
        value=1.0/(1.0*Factorial(n))
        
        if (   (n%4)==0   ):
            return value
        else:
            return -value
    else:
        return 0.0
    
