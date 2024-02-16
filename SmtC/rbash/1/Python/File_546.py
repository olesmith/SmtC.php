#!/usr/bin/python3

from Vector import *
from Matrix import *

from Gauss_Pivotation import *

##!
##! Use Gauss_Matrix to calculate inverse.
##!

def Matrix_Inverse(A):
    X=Matrix_Identity( len(A) )

    Gauss_Matrix_Test(A,X)

    return X

##!
##! Run Gauss_Matrix and do tests.
##!

def Gauss_Matrix_Test(A,B=[]):
    #Save for residual calc
    AA=Matrix_Copy(A)
    BB=Matrix_Copy(B)

    #Solution ends up in B
    det=Gauss_Matrix(A,B)

    
    #B is our solution, calc residual
    R_B=Matrices_Mult(AA,B)
    R_B=Matrices_Sub(R_B,BB)
    
    residual=Matrix_Norm(R_B)/Matrix_Norm(BB)
    print("Gauss_Matrix_Test, Residual: %.6e" %  residual)

    return det


##!
##! Performas forward, then backward elimination
##!

def Gauss_Matrix(A,B=[]):
    #Solution ends up in B, A becomes identity
    det=Gauss_Matrix_Forward(A,B)

    if (abs(det)>0.0):
        Gauss_Matrix_Backward(A,B)

    return det



##!
##! Forward elimination.
##!

def Gauss_Matrix_Forward(A,B=[]):
    det=1.0
    for i in range( len(A) ):
        pivote=Gauss_Pivote_Get(A,i)

        if (pivote!=i):
            if (B):
                Matrix_Rows_Swap(B,i,pivote)
                
            Matrix_Rows_Swap(A,i,pivote)
            det*=-1.0
        
        if (A[i][i]==0.0):
            print("Gauss_Matrix_Forward: Matrix Singular at ",i,"x",i)
            return 0.0
            
        det*=A[i][i]
        fact=1.0/A[i][i]
        
        #Always work on b first
        if (B):
            Matrix_Row_Mult(B,i,fact)
            
        Matrix_Row_Mult(A,i,fact)

        for j in range( i+1,len(A) ):
            if (B):
                Matrix_Row_Operation(B,j,-A[j][i],i)
                
            Matrix_Row_Operation(A,j,-A[j][i],i)

    return det

##!
##! Backward elimination.
##!

def Gauss_Matrix_Backward(A,B=[]):
    for i in range(len(A)-1,-1,-1):
        for j in range(i):
            if (B):
                Matrix_Row_Operation(B,j,-A[j][i],i)
                
            Matrix_Row_Operation(A,j,-A[j][i],i)
            

###!
###!
#### Testing #####
###!
###!

if (__name__=='__main__'):
    A=Matrix_Vandermonte([1.0,-1.0,2.0,-2.0])
    

    print ("A=")
    Matrix_Print(A)

    A_inv=Matrix_Inverse(A)

    print ("A^{-1}=")
    Matrix_Print(A_inv)
