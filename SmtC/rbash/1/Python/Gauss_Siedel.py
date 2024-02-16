#!/usr/bin/python3

from Vector import *
from Matrix import *
from Gauss_Jacobi import *


##!
##!
##!


def Gauss_Siedel(A,b,x0,epsilon=1.0E-6,max_iterations=100,test=False):
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
            for j in range(i):
                xi+=C[i][j]*x_new[j]
                
            for j in range(i+1,n):
                xi+=C[i][j]*x[j]

            x_new.append(xi)
        
        dx=Vectors_Sub(x,x_new)
        norm=Vector_Norm_Inf(x)
        if (norm>0.0):
            norm=Vector_Norm_Inf(dx)/norm

        xs.append(x_new)
        x=x_new
        

        if (norm>0.0 and norm<epsilon):
            convergence=True
            break

    
    #Calculate Resuidual vector and norm
    r=Matrix_Mult_Vector(A,x)
    r=Vectors_Sub(r,b)

    norm=Vector_Norm_Inf(r)/Vector_Norm_Inf(b)

    if (test):
        Gauss_Jacobi_Latex("Gauss_Siedel.tex",A,b,C,g,xs,epsilon)

        
    return x,norm


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
    A=[
        [5.0,1.0,1.0],
        [3.0,4.0,1.0],
        [3.0,3.0,6.0],
    ]

    b=[5.0,6.0,0.0]
    x0=[0.0,0.0,0.0]
    
    Gauss_Siedel(A,b,x0,test=True)
