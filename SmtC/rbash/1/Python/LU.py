#!/usr/bin/python3

import os

from Vector import *
from Matrix import *
from Latex import *

from Gauss_Pivotation import *


##!
##! Performas factorization.
##!

def LU_Fact(A,test,pivotation):
    #Matrix woth L (below) and U from and above (diagonal)
    LU=Matrix_Copy(A)
    
    #Solution ends up in B, A becomes identity
    P,det=LU_Forward(LU,pivotation)

    
    L=Matrix_Lower(LU)
    U=Matrix_Upper(LU)

    if (test):
        LU=Matrices_Mult(L,U)
        print( Matrix_Latex(P,"P"))
        print( Matrix_Latex(L,"L"))
        print( Matrix_Latex(U,"U"))
        PA=Matrices_Mult(P,A)

        print( Matrix_Latex(LU,"LU"))
        print( Matrix_Latex(PA,"PA"))

        R=Matrices_Sub(LU,PA)

        print( Matrix_Latex(R,"R"))

        print(
            "Determinant:",
            (
                "%.6f" % det
            ),
            "Residuo:",
            (
                "%.6e" % (Matrix_Norm(R)/Matrix_Norm(A))
            )
        )
        
    return L,U,P,det






##!
##! Forward elimination.
##!

def LU_Forward(A,pivotation=True):
    #Permutation Matrix
    P=Matrix_Identity(len(A))
    
    det=1.0
    for i in range( len(A) ):
        if (pivotation):
            pivote=Gauss_Pivote_Get(A,i)

            if (pivote!=i):
                Matrix_Rows_Swap(A,i,pivote)
                det*=-1.0

                PP=Matrix_Permutation(len(A),i,pivote)
                P=Matrices_Mult(PP,P)
                PA=Matrices_Mult(PP,A)
                
        if (A[i][i]==0.0):
            print("LU_Forward: Matrix Singular at diag ",i)
            return 0.0,P
        
        piv_value=A[i][i]
        det*=piv_value
        
        for j in range( i+1,len(A) ):
            fact=A[j][i]/piv_value

            Matrix_Row_Operation(A,j,-fact,i,i+1)
            A[j][i]=fact
            
        
    return P,det

##!
##! Forward elimination, maintaing list of matrics: P,L,U..
##!

def LU_Factorize_Trace(A,pivotation=True):
    n=len(A)
    
    #Permutation Matries
    PS=[]
    LS=[]
    LSs=[]
    US=[]
    
    det=1.0
    for i in range( len(A) ):
        LSs.append([])
        
        P=Matrix_Identity(len(A))
    
        if (pivotation):
            pivote=Gauss_Pivote_Get(A,i)

            if (pivote!=i):
                Matrix_Rows_Swap(A,i,pivote)
                det*=-1.0

                P=Matrix_Permutation(len(A),i,pivote)

        PS.append(P)
                
        if (A[i][i]==0.0):
            print("LU_Forward: Matrix Singular at diag ",i)
            return 0.0,P
        
        piv_value=A[i][i]
        det*=piv_value

        LI=Matrix_Identity(n)
        
        for j in range( i+1,len(A) ):
            fact=A[j][i]/piv_value

            Matrix_Row_Operation(A,j,-fact,i,i+1)
            A[j][i]=fact
            
            LIJ=Matrix_Identity(n)
            LIJ[j][i]=fact
            LSs[i].append(LIJ)
            
            LI[j][i]=fact
            
        #LI=Matrix_LU_Lower(A,i)
        LS.append(LI)
        
        UI=Matrix_LU_Upper(A,i)      
        US.append(UI)
            
        
    return LS,US,PS,LSs

##!
##! Show LU factorization as multiplication of matrices
##!

def LU_Latex(A,pivotation):
    n=len(A)
    
    latex=[]

    latex=latex+Latex_Math([
        Latex_Matrix_Name("A"),
        "=",
        Matrix_Latex(A)
    ])

    LS,US,PS,LSs=LU_Factorize_Trace(A,pivotation)

    latex.append("\\begin{itemize}")
    
    L=Matrix_Identity(n)
    for i in range(n-1):

        latex.append("\\item $n="+str(i)+"$:")

        #Show permutation matrix.
        if (pivotation):
            latex=latex+Latex_Math([
                Latex_Matrix_Name("P_{"+str(i)+"}"),
                "=",
                Matrix_Latex(PS[i])
            ])

        #LIs as a product.
        if (len(LSs)>0):
            rlatex=Matrices_Latex(LSs[i],"L'",i+1)
            latex=latex+Latex_Math(
               [ Latex_Matrix_Name("L_{"+str(i)+"}")]+
                ["="]+
                rlatex+
                ["="]
            )

            LL=Matrices_Mult_List(LSs[i])
            latex=latex+Latex_Math([
                Matrix_Latex(LL)
            ])

        #Product LU
        L=Matrices_Mult(L,LS[i])
        PL=Matrices_Mult(PS[i],L)
        
        latex=latex+Latex_Math([
            Latex_Matrix_Name("L_{"+str(i)+"}"),
            "=",
            Matrix_Latex(L),
            ",\\qquad",
            Latex_Matrix_Name("U_{"+str(i)+"}"),
            "=",
            Matrix_Latex(US[i])
        ])


        AI=Matrices_Mult(PL,US[i])
        
        latex=latex+Latex_Math([
            #Latex_Matrix_Name("P_{"+str(i)+"}"),
            Latex_Matrix_Name("L_{"+str(i)+"}"),
            Latex_Matrix_Name("U_{"+str(i)+"}"),
            "=",
            Matrix_Latex(L),
            Matrix_Latex(US[i]),
            "=",
            Matrix_Latex(AI),
        ])

        latex=latex+Latex_Math([
            Latex_Matrix_Name("A"),
            "=",
            Latex_Matrix_Name("P_{"+str(i)+"}"),
            Latex_Matrix_Name("L_{"+str(i)+"}"),
            Latex_Matrix_Name("U_{"+str(i)+"}"),
        ])
        
    latex.append("\\end{itemize}")
    latex.append("\\clearpage")
    
    return latex


###!
###!
#### Testing #####
###!
###!

if (__name__=='__main__'):
    v=[]
    for i in range(1,6):
        v.append(1.0*i)
        
    A1=[
        [3.0,-4.0, 1.0],
        [1.0, 2.0, 2.0],
        [4.0, 0.0,-3.0],
    ]
    A2=[
        [3.0, 2.0, 4.0],
        [1.0, 1.0, 3.0],
        [4.0, 3.0, 2.0],
    ]

    A3=Matrix_Vandermonte([4,3,2,1])
    #test=True
    pivotation=False
    

    latex=[
        LU_Latex(A1,pivotation),
        LU_Latex(A2,pivotation),
        LU_Latex(A3,pivotation),
    ]
    latex=Latex_Itemize(latex,options="- Ex. 1",env="enumerate")
    
    latex=Latex_Text(["\\textbf{LU without Pivotation}."]+latex)
    
    latex=Latex_Save(
        os.getcwd()+"/LU.tex",
        latex
    )

    print(   "\n".join(latex)   )
