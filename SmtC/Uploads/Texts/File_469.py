#!/usr/bin/python3

import re,sys

from Vector import *
from Latex import *
from TikZ import *

##!
##! Print Matrix_Text(A)
##!

def Matrix_Print(A):
    print (Matrix_Text(A))

##!
##! Generate Matrix as text.
##!

def Matrix_Text(A):
    text=[]
    for i in range( len(A) ):
        text.append(   Vector_Text(A[i],"   ")   )

    return "[\n"+",\n".join(text)+"\n]"

##!
##! Generate Matrix as latex.
##!

def Matrix_Latex(A,title="",env="pmatrix*",frmt="%.3f",options="r"):
    latex=[]
    for i in range( len(A) ):
        comps=[]
        for j in range(len(A[i])):
            comp=str(A[i][j])
            if (
                    isinstance(A[i][j],int)
                    or
                    isinstance(A[i][j],float)
            ):
                comp=frmt % A[i][j]
            comps.append(comp)

        latex.append("   "+" & ".join(comps)+"\\\\")

    latex=Latex_Environment(env,latex,options)
    if (title!=""):
        latex=[
            "\\underline{\\underline{"+title+"}}="
        ]+latex
        
    
    return latex

##!
##! Generate list of matrices as latex.
##!

def Matrices_Latex(As,name=None,n=0,env="pmatrix",frmt="%.3f"):
    latex=[]
    names=[]
    for i in range(len(As)):
        if (name):
            
            names.append(
                Latex_Matrix_Name(name+"_{"+str(i+n)+"}")
            )
        
        latex.append(
            Matrix_Latex(As[i],"",env,frmt)
        )

    if (name): names.append("=")
    
    return names+latex

##!
##!
##!

def Matrix_Copy(A):
    B=[]
    for i in range( len(A) ):
        B.append([])
        for j in range( len(A[i]) ):
            B[i].append(A[i][j])

    return B

##!
##!
##!

def Matrix_Zero(m,n=0):
    if (n==0): n=m
    
    O=[]
    for i in range(m):
        O.append([])
        for j in range(n):
            O[i].append(0.0)

    return O

##!
##!
##!

def Matrix_LC2(A,a,B,b):
    C=Matrix_Zero(len(A),len(A[0]))
    for i in range( len(A) ):
        for j in range( len(A[i]) ):
            C[i][j]=a*A[i][j]+b*B[i][j]

    return C

##!
##!
##!

def Matrix_Scale(i,c,n):
    D=Matrix_Identity(n)
    D[i][i]=c
    
    return D

##!
##!
##!

def Matrix_Row_Oper(i,j,c,n):
    D=Matrix_Identity(n)
    D[i][j]=c
    
    return D



##!
##!
##!

def Matrix_Identity(n):
    I=Matrix_Zero(n)
    for i in range(n):
        I[i][i]=1.0

    return I


##!
##!
##!

def Matrix_Permutation(n,i,j):
    P=Matrix_Identity(n)
    
    P[i][i]=0.0
    P[j][j]=0.0

    P[i][j]=1.0
    P[j][i]=1.0

    return P


def Matrix_Transpose(A):
    m=len(A)
    n=len(A[0])
    m=len(A)
    AT=Matrix_Zero(n,m)
    
    for i in range(m):
        for j in range(n):
            AT[j][i]=A[i][j]


    return AT

##!
##! Lower (should be square, but...)
##!

def Matrix_Lower(A):
    L=Matrix_Zero(len(A),len(A[0]))
    for i in range(len(A)):
        L[i][i]=1.0
        for j in range(0,i):
            L[i][j]=A[i][j]

    return L

##!
##! Upper (should be square, but...)
##!

def Matrix_Upper(A):
    U=Matrix_Zero(len(A),len(A[0]))
    for i in range(len(A)):
        for j in range(i,len(A[0])):
            U[i][j]=A[i][j]

    return U
      
##!
##! Extracts Upper matrix from (stored) A.
##!

def Matrix_LU_Lower(A,i):
    n=len(A)

    UI=Matrix_Identity(len(A))

    for ii in range(0,i+1):
        for jj in range(ii+1,n):
            print (jj,ii,A[jj][ii])
            
            UI[jj][ii]=A[jj][ii]

    return UI
     
##!
##! Extracts Upper matrix from (stored) A.
##!

def Matrix_LU_Upper(A,i):
    n=len(A)

    UI=Matrix_Copy(A)
    for ii in range(0,i+1):
        for jj in range(ii+1,n):
            UI[jj][ii]=0.0
    
    return UI

##!
##!
##!

def Matrix_Vandermonte(v):
    V=[]
    for i in range( len(v) ):
        V.append([])
        
        for j in range( len(v) ):
            V[i].append(v[j]**i)

    return V



##!
##!
##!

def Matrices_Add(A,B):
    if (   len(A)!=len(B)   ):
        print("Matrices_Add: Matrices does not have same no of rows")
        exit()

    C=[]
    for i in range( len(A) ):
        C.append(  []  )
        if (   len(A[i])!=len(B[i])   ):
            print("Matrices_Add: Matrices does not have same no of columns")
            exit()

        for j in range( len(A[i]) ):
            C[i].append(   1.0*(A[i][j]+B[i][j])   )
            
    return C

##!
##!
##!


def Matrices_Sub(A,B):
    if (   len(A)!=len(B)   ):
        print("Matrices_Add: Matrices does not have same no of lines")
        exit()

    C=[]
    for i in range( len(A) ):
        C.append(  []  )
        if (   len(A[i])!=len(B[i])   ):
            print("Matrices_Add: Matrices does not have same no of columns")
            exit()

        for j in range( len(A[i]) ):
            C[i].append(   1.0*(A[i][j]-B[i][j])   )
            
    return C

##!
##!
##!

def Matrix_Mult_Scalar(A,a):
    C=[]
    for i in range( len(A) ):
        C.append(  []  )
        for j in range( len(A[i]) ):
            C[i].append(   a*A[i][j]  )
            
    return C

##!
##!
##!

def Matrix_Mult_Vector(A,v):
    if (   len(A[0])!=len(v)   ):
        print("Matrices_Mult_Vector: Matrices and Vector has incompatible dimensions")
        exit()
    w=[]
    for i in range( len(A) ):
        sum=0.0
        for j in range( len(A[i]) ):
            sum+=A[i][j]*v[j]

        w.append(sum)
    return w

##!
##!
##!

def Matrices_Mult(A,B):
    if (   len(A[0])!=len(B)   ):
        print ("Matrices_Mult: Matrices has incompatible dimensions")
        exit()

    n=len(A)
    m=len(B[0])
    
    C=Matrix_Zero(n,m)    
    for i in range( n ):
        for j in range( m ):
            C[i][j]=0.0
            for k in range( len(B) ):
                C[i][j]+=A[i][k]*B[k][j]
        
    return C

##!
##! Matrix p-norm.
##!

def Matrix_Norm(A,p=2.0):
    norm=0.0
    for i in range( len(A) ):
        for j in range( len(A[i]) ):
            norm+= abs(A[i][j]**p)
        
    return norm**(1.0/p)

##!
##! Matrix p-distance
##!

def Matrix_Dist(A,B,p=2.0):
    C=Matrices_Sub(A,B)
        
    return Matrix_Norm(C,p)

##!
##!
##!

def Matrix_Row_Mult(A,i,a):
    for k in range( len(A[i]) ):
        A[i][k]*=a
        

##!
##!
##!

def Matrix_Rows_Swap(A,i,j,start=0):
    if (i==j): return
    
    for k in range( start,len(A[i]) ):
        tmp=A[i][k]
        A[i][k]=A[j][k]
        A[j][k]=tmp

##!
##!
##!

def Matrix_Row_Operation(A,i,c,j,start=0):
    if (i==j): return
    
    for k in range( start,len(A[i]) ):
        A[i][k]+=c*A[j][k]

##!
##!
##!


def Matrix_Determinant(A):
    return Matrix_Gauss_Forward(A)

##!
##! Multiplies list of matrices
##!

def Matrices_Mult_List(As):
    if (len(As)==0): return []
    
    C=As[0]
    for i in range(   1,len(As)   ):
        C=Matrices_Mult(C,As[i])
        
    return C

##!
##! Latex product of matrices.
##!

def Matrices_Latex_Product(As):
    latex=[]
    nmax=2

    mult="*"
    
    rlatex=[]
    for i in range(  len(As)   ):
        if (i>=len(As)-1): mult="="
        
        rlatex.append(
            Matrix_Latex(As[i])+[mult]
        )

        if (len(rlatex)>=nmax):
            latex=latex+Latex_Math(rlatex)
            rlatex=list()

    if (len(rlatex)>0):
        latex=latex+Latex_Math(rlatex)
        
    return latex

##!
##! Latex product of matrices as equation: ()*()...=().
##!

def Matrices_Latex_Product_Eqs(As):
    if (len(As)==1):
        return [
            Matrices_Latex_Product(As)
        ]
    
    return [
        Matrices_Latex_Product(As),
        Latex_Math(
            Matrix_Latex(
                Matrices_Mult_List(As)
            )
        )
    ]



##!
##! Generate Row operation matrix, C_ij(c)
##!

def Matrix_C_ij_TikZ():
    Cij=[
        ["1","\\cdots","0","\\cdots","0","\\cdots","0"],
        ["\\vdots","\\ddots","\\vdots","","\\vdots","","\\vdots"],
        ["0","\\cdots","1","\\cdots","0","\\cdots","0",],
        ["\\vdots","","\\vdots","\\ddots","\\vdots","","\\vdots",],
        ["0","\\cdots","c","\\cdots","1","\\cdots","0",],
        ["\\vdots","","\\vdots","","\\vdots","\\ddots","\\vdots",],
        ["0","\\cdots","0","\\cdots","0","\\cdots","1",],
    ]

    latex=Latex_Inline([
        "\\underline{\\underline{C}}_{i,j}(c)=",
        Matrix_Latex(Cij),
    ])

    xi=0.10
    xj=xi+1.275
    y=2.1
    dy=0.35
    
    latex=Latex_Text(
        Latex_Environment(
            "tikzpicture",            
            [
                TikZ_Node([0,0,latex]),
                TikZ_Nodes([
                    [ xi,y+dy,"\\small{$i$}" ],
                    [ xi,y,   "$\\downarrow$" ],
                    [ xj,y+dy,"\\small{$j$}" ],
                    [ xj,y,   "$\\downarrow$" ],
                ])
            ]
        )
    )
    
    texname="Matrix_Operation.tex"
    
    print(texname+":")
    print("\n".join(Latex_Text(latex)))
    TikZ_Run(texname,latex,gen_svg=True)
 
    return latex
    
##!
##! Genrate Row operation matrix, C_ij(c)
##!

def Matrix_P_ij_TikZ():
    Pij=[
        ["1","\\cdots","0","\\cdots","0","\\cdots","0"],
        ["\\vdots","\\ddots","\\vdots","","\\vdots","","\\vdots"],
        ["0","\\cdots","0","\\cdots","1","\\cdots","0",],
        ["\\vdots","","\\vdots","\\ddots","\\vdots","","\\vdots",],
        ["0","\\cdots","1","\\cdots","0","\\cdots","0",],
        ["\\vdots","","\\vdots","","\\vdots","\\ddots","\\vdots",],
        ["0","\\cdots","0","\\cdots","0","\\cdots","1",],
    ]


    latex=Latex_Inline([
        "\\underline{\\underline{P}}_{i,j}=",
        Matrix_Latex(Pij),
    ])

    xi=-0.10
    xj=xi+1.275
    y=2.1
    dy=0.35

    latex=Latex_Text(
        Latex_Environment(
            "tikzpicture",            
            [
                TikZ_Node([0,0,latex]),
                TikZ_Nodes([
                    [ xi,y+dy,"\\small{$i$}" ],
                    [ xi,y,   "$\\downarrow$" ],
                    [ xj,y+dy,"\\small{$j$}" ],
                    [ xj,y,   "$\\downarrow$" ],
                ])
            ]
        )
    )
    
    texname="Matrix_Permutation.tex"
    
    print(texname+":")
    print("\n".join(Latex_Text(latex)))
    
    TikZ_Run(texname,latex,gen_svg=True)
    
    return []
    



##!
##! Generate Row operation matrices product, C_ij(c)
##!

def Matrix_Cs_ij_TikZ():

    Cij1=[
        ["1","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","1","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","c_1","\\cdots","1","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","0","\\cdots","0","\\cdots","1","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots",
        ],
        ["0","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","1"],
    ]
    
    Cij2=[
        ["1","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","1","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","0","\\cdots","1","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","c_2","\\cdots","0","\\cdots","1","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots",
        ],
        ["0","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","1"],
    ]
    Cij=[
        ["1","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","1","\\cdots","0","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","c_1","\\cdots","1","\\cdots","0","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots","",
            "\\vdots",
        ],
        ["0","\\cdots","c_2","\\cdots","0","\\cdots","1","\\cdots","0"],
        [
            "\\vdots","",
            "\\vdots","",
            "\\vdots","",
            "\\vdots","\\ddots",
            "\\vdots",
        ],
        ["0","\\cdots","0","\\cdots","0","\\cdots","0","\\cdots","1"],
    ]

    latex=Latex_Inline([
        "\\underline{\\underline{C}}_{i,j_1}(c_1)",
        "\\underline{\\underline{C}}_{i,j_2}(c_2)",
        "=",
        Matrix_Latex(Cij1),
        Matrix_Latex(Cij2),
        "=",
        Matrix_Latex(Cij),
    ])

    
    x1=-6.15
    x2=0.0
    x3=6.5

    xi=0.05
    dxj1=xi+1.35
    dxj2=xi+2.65
    y=2.6
    dy=0.35
    
    latex=Latex_Text(
        Latex_Environment(
            "tikzpicture",            
            [
                TikZ_Node([0,0,latex]),
                TikZ_Nodes([
                    [ x1+xi,y+dy,      "\\small{$i$}" ],
                    [ x1+xi,y,         "$\\downarrow$" ],
                    [ x1+xi+dxj1,y+dy, "\\small{$j_1$}" ],
                    [ x1+xi+dxj1,y,    "$\\downarrow$" ],
                    [ x1+xi+dxj2,y+dy, "\\small{$j_2$}" ],
                    [ x1+xi+dxj2,y,    "$\\downarrow$" ],
                ]),
                TikZ_Nodes([
                    [ x2+xi,y+dy,      "\\small{$i$}" ],
                    [ x2+xi,y,         "$\\downarrow$" ],
                    [ x2+xi+dxj1,y+dy, "\\small{$j_1$}" ],
                    [ x2+xi+dxj1,y,    "$\\downarrow$" ],
                    [ x2+xi+dxj2,y+dy, "\\small{$j_2$}" ],
                    [ x2+xi+dxj2,y,    "$\\downarrow$" ],
                ]),
                TikZ_Nodes([
                    [ x3+xi,y+dy,      "\\small{$i$}" ],
                    [ x3+xi,y,         "$\\downarrow$" ],
                    [ x3+xi+dxj1,y+dy, "\\small{$j_1$}" ],
                    [ x3+xi+dxj1,y,    "$\\downarrow$" ],
                    [ x3+xi+dxj2,y+dy, "\\small{$j_2$}" ],
                    [ x3+xi+dxj2,y,    "$\\downarrow$" ],
                ]),
            ]
        )
    )
    
    texname="Matrix_Operations_Mult.tex"
    
    print(texname+":")
    print("\n".join(Latex_Text(latex)))
    TikZ_Run(texname,latex,gen_svg=True)
 
    return latex
    

if (__name__=='__main__'):
    

    Matrix_C_ij_TikZ()
    Matrix_P_ij_TikZ()
    
    Matrix_Cs_ij_TikZ()
    
