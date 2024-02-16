from Vector import *
from Matrix import *


##!
##!
##!

def Gauss_Pivotation(A,b=[]):
    det=Gauss_Forward_Pivotation(A,b)
    print ("Gauss Forward, det",det)

    if (abs(det)>0.0):
        Gauss_Backward(A,b)
    
    return det

##!
##!
##!

def Gauss_Forward_Pivotation(A,b=[]):
    det=1.0
    for i in range( len(A) ):
        pivote=Gauss_Pivote_Get(A,i)

        if (pivote!=i):
            if (b):
                tmp=b[i]
                b[i]=b[pivote]
                b[pivote]=tmp
                
            Matrix_Rows_Swap(A,i,pivote)
            det*=-1.0
        
        if (A[i][i]==0.0):
            print("Gauss_Forward: Matrix Singular at ",i,"x",i)
            Matrix_Print(A)
            return 0.0
            
        det*=A[i][i]
        fact=1.0/A[i][i]

        #Always work on b first
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
##!
##!

def Gauss_Pivote_Get(A,i):
    pivote=i
    piv=abs(A[i][i])
    for j in range( i+1,len(A) ):
        if ( abs(A[j][i])>piv ):
            pivote=j
            piv=abs(A[j][i])

    return pivote
