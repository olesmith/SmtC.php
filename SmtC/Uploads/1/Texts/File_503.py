from Vector import *
from Matrix import *

from Gauss_Pivotation import *

##!
##!
##!


def Gauss_Elimination(A,b=[]):
    det=Gauss_Forward(A,b)
    print("Gauss Forward, det",det)

    if (abs(det)>0.0):
        Gauss_Backward(A,b)

    return det
      

##!
##!
##!


def Gauss_Forward(A,b=[]):
    det=1.0
    for i in range( len(A) ):
        if (A[i][i]==0.0):
            print("Gauss_Forward_1: Matrix Singular at ",i,"x",i)
            Matrix_Print(A)
            return 0.0
            
        det*=A[i][i]
        fact=1.0/A[i][i]
        
        if (b): b[i]*=fact
        Matrix_Row_Mult(A,i,fact)

        for j in range( i+1,len(A) ):
            if (b): b[j]-=A[j][i]*b[i]
            
            Matrix_Row_Operation(A,j,-A[j][i],i)

    return det

    

##!
##!
##!

def Gauss_Backward(A,b=[]):
    for i in range(len(A)-1,-1,-1):
        for j in range(i):
            if (b): b[j]-=A[j][i]*b[i]
            
            Matrix_Row_Operation(A,j,-A[j][i],i)
        
##!
##! Solve and test with Gauss Elimination
##! Partial pivotation, if pivotation>0
##!

def Gauss_Test(A,b=[],pivotation=0):
    #Save for residual calc
    AA=Matrix_Copy(A)
    bb=list(b)
    
    det=0.0
    if (pivotation>0):
        print ("Partial Pivotation")
        Gauss_Pivotation(A,b)
    else:
        print ("No Pivotation")
        Gauss_Elimination(A,b)

    print ("Determinant: %.6e" %  det)
    
    #b is our solution, calc residual
    res_b=Matrix_Mult_Vector(AA,b)
    res_b=Vectors_Sub(res_b,bb)
    
    residual=Vector_Norm_p(res_b)/Vector_Norm_p(bb)
    print("Solution: ")

    
    Matrix_Print(AA)
    Vector_Print(b)
    print("=")
    Vector_Print(bb)
    
    print ("Gauss_Test, Residual: %.6e" %  residual)
    
    return det
    
