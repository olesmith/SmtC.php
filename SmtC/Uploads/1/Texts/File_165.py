#!/usr/bin/python3

from Vector import *
from Matrix import *

from Gauss_Pivotation import *

##!
##! Use Gauss_Matrix to calculate inverse.
##!

def Matrix_Inverse(A,test=False,pivotation=True):
    X=Matrix_Identity( len(A) )

    if (test):
        Gauss_Matrix_Test(A,X,pivotation)
    else:
        Gauss_Matrix(A,X,pivotation)

    return X

##!
##! Run Gauss_Matrix and do tests.
##!

def Gauss_Matrix_Test(A,B=[],pivotation=True):
    #Save for residual calc
    AA=Matrix_Copy(A)
    BB=Matrix_Copy(B)

    #Solution ends up in B
    det=Gauss_Matrix(A,B)

    
    #B is our solution, calc residual
    R_B=Matrices_Mult(AA,B)
    R_B=Matrices_Sub(R_B,BB)

    #Relative error
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

def Gauss_Matrix_Forward(A,B=[],pivotation=True):
    print("Pivotation",pivotation)
    
    det=1.0
    for i in range( len(A) ):
        if (pivotation):
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
    v=[]
    for i in range(1,6):
        v.append(1.0*i)
        v.append(-1.0*i)
        
    A=Matrix_Vandermonte(v)
    test=True
    pivotation=False
    


    AA=Matrix_Inverse(A,test,pivotation)
    
    print ("A=")
    Matrix_Print(A)
    print ("A^{-1}=")
    Matrix_Print(AA)
