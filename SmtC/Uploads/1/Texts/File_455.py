#!/usr/bin/python3

from  Run import Function_Run

from math import *


def f2(x):
    return x*(x*x-3.0)

def df2(x):
    return 3.0*x*x-3.0

def phi2(x):
    return x*3/3.0

Function_Run(f2,1,2,df2,phi2,"x(x^2-3)")
