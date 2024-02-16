#!/usr/bin/python3

from  Run import Function_Run

from math import *


def f1(x):
    return x-cos(x)

def df1(x):
    return 1+sin(x)

def phi1(x):
    return cos(x)

Function_Run(f1,0,pi,df1,phi1,"x-\\cos(x)")
