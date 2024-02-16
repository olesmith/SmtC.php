#!/usr/bin/python3

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
    P,As,Ps,det=LU_Forward(LU,pivotation)

    
    L=Matrix_Lower(LU)
    U=Matrix_Upper(LU)

    latex=[]
    if (test):
        LU=Matrices_Mult(L,U)

        #A with Permutations
        PLU=Matrices_Mult(P,LU)
        
        #Residual Matrix: LU-PA
        R=Matrices_Sub(A,PLU)
    
        latex=Latex_Text([
            Latex_Environment(
                "small",
                [
                    "\\textbf{LU with Factorization}",
                    LU_Latex_Leading(det,A),
                    
                    #Details of L matrix multiplications
                    L_Latex(A,L,U,As,Ps),
                    
                    LU_Latex_Result(det,A,P,L,U,LU,PLU,R),
                ]
            )
        ])
        
        #Latex_Save("/LU_Pivotation.tex",latex)

    print(   "\n".join(latex)   )

        
    return L,U,P,det



##!
##! Forward elimination.
##!

def LU_Forward(A,pivotation=True):
    #Permutation Matrix
    P=Matrix_Identity(len(A))
    As=[]
    Ps=[]
    
    det=1.0
    for i in range( len(A) ):
        if (pivotation):
            pivote=Gauss_Pivote_Get(A,i)

            if (pivote!=i):
                Matrix_Rows_Swap(A,i,pivote)
                det*=-1.0

                PP=Matrix_Permutation(len(A),i,pivote)
                P=Matrices_Mult(P,PP)
                
        if (A[i][i]==0.0):
            print("LU_Forward: Matrix Singular at diag ",i)
            return 0.0,P
        
        piv_value=A[i][i]
        det*=piv_value
        
        for j in range( i+1,len(A) ):
            fact=A[j][i]/piv_value

            Matrix_Row_Operation(A,j,-fact,i,i+1)
            A[j][i]=fact

        AA=Matrix_Copy(A)
        As.append(AA)
        Ps.append(P)
        
    return P,As,Ps,det



##!
##! LU Leading section
##!

def LU_Latex_Leading(det,A):
    
    return Latex_Math(
        [
            Latex_Matrix_Name("A"),
            "=",
            Matrix_Latex(A)
        ]+
        [
            ",\\qquad",
            "\\det{"+Latex_Matrix_Name("A")+"}=",
            ("%.6f" % det)
        ]
    )

##!
##! Latex equations of LU-factorization
##!

def LU_Latex_Result(det,A,P,L,U,LU,PLU,R):
    return [
        "Results:",
        Latex_Math([
            Latex_Matrix_Name("P"),
            "=",
            Matrix_Latex(P),
            
        ]),
        
        Latex_Math([
            Latex_Matrix_Name("L"),
            "=",
            Matrix_Latex(L),
            
        ]),
        Latex_Math([
            Latex_Matrix_Name("U"),
            "=",
            Matrix_Latex(U)
        ]),
        Latex_Inline([
            Latex_Matrix_Name("L")+
            Latex_Matrix_Name("U"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(L),
            Matrix_Latex(U),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(LU)
        ]),

        Latex_Inline([
            Latex_Matrix_Name("A")+"'",
            "=",
            Latex_Matrix_Name("P")+
            "("+
            Latex_Matrix_Name("L")+
            Latex_Matrix_Name("U")+
            ")",
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(P),
            Matrix_Latex(LU),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(PLU)
        ]),
        Latex_Inline([
            Latex_Matrix_Name("R"),
            "=",
            Latex_Matrix_Name("A")+
            "-",
            Latex_Matrix_Name("P")+
            Latex_Matrix_Name("L")+
            Latex_Matrix_Name("U"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(A),
            "-",
            Matrix_Latex(PLU),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(R,frmt="%.2E")
        ]),
        [
            "Residual: $||"+Latex_Matrix_Name("R")+"||="+
            (
                "%.6E" % (Matrix_Norm(R)/Matrix_Norm(A))
            )+
            "$.\n"
        ]
    ]

##!
##!
##!

def L_Latex(A,L,U,As,Ps):
    n=len(A)

    items=[]
    for i in range(n-1):
        items.append([
            "Iteration $i="+str(i)+"$:\n",
            Li_Latex(A,L,U,i),
            Li_Latex_Result(A,L,As[i],Ps[i],i),
        ])
        
    LLs=LU_LLs(L)

    return [
        Latex_Itemize(items),
        "\\textbf{Accumulated}:\n",
        L_Latex_Names(n,sup=""),
        Matrices_Latex_Product_Eqs(LLs)
    ]

##!
##! Latex showing Li multipliaction
##!

def Li_Latex(A,L,U,i):    
    Ls=LU_Ls(L)

    n=len(A)
    
    return [
        Li_Latex_Names(i,n,sup="'"),
        Matrices_Latex_Product_Eqs(Ls[i]),
    ]

##!
##! Latex showing Li, Ui, Pi and Li*Ui
##!

def Li_Latex_Result(A,L,U,Pi,i):
    
    Li,Ui=LU_LU_i(U,i)

    Ai=Matrices_Mult(Li,Ui)
    PAi=Matrices_Mult(Pi,Ai)
    return [
        Latex_Inline([
            Li_Latex_Name(i,name="P"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Pi),
        ]),
        
        Latex_Inline([
            Li_Latex_Name(i,name="L"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Li),
        ]),
        
         Latex_Inline([
            Li_Latex_Name(i,name="U"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Ui)
        ]),

        ##Products
        Latex_Inline([
            Li_Latex_Name(i,name="A"),
            "=",
            Li_Latex_Name(i,name="L"),
            Li_Latex_Name(i,name="U"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Li),
            Matrix_Latex(Ui),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Ai),
        ]),

        
        Latex_Inline([
            Li_Latex_Name(i,name="P"),
            Li_Latex_Name(i,name="A"),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(Pi),
            Matrix_Latex(Ai),
            "=",
        ]),
        Latex_Math([
            Matrix_Latex(PAi),
        ]),
    ]

##!
##! Accumulated Lis.
##!

def Li_Product(L,i):
    latex=[]

    n=len(A)

    LL=Matrix_Identity(n)
    
    for ii in range(i):
        Li=LU_i(L,ii)
        LL=Matrices_Mult(Li,LL)
        
    return LL

##!
##! Names - titles to L multiplication equation
##!

def L_Latex_Names(n,sup=""):
    names=[
        Li_Latex_Name(),
        "="
    ]
    
    for i in range(n-1):
        names.append(
            Li_Latex_Name(i,None,sup)
        )

    names.append("=")
    
    return Latex_Inline(names)
   
##!
##! Names - titles to Li multiplication equation
##!

def Li_Latex_Names(i,n,sup=""):
    names=[
        Li_Latex_Name(i),
        "="
    ]
    for j in range( i+1,n):
         names.append(
            Li_Latex_Name(i,j,sup)
         )

    names.append("=")
    
    return Latex_Inline(names)
             
##!
##! Li latex Name
##!

def Li_Latex_Name(i=None,j=None,sup="",name="L"):
    subs=[]
    if (i!=None):
        subs.append(str(i))
        
    if (j!=None):
        subs.append(str(j))

    sub="{"+",".join(subs)+"}"
    
    return Latex_Matrix_Name(name,sub,sup)


##!
##! Matrix L_ij (identity, plus element i,j)
##!

def LU_i_j(L,i,j):
    Lij=Matrix_Identity(len(L))    
    Lij[j][i]=L[j][i]

    return Lij



##!
##! Matrix L_i (identity, plus column element i,i+1,...)
##!

def LU_i(L,i):
    Li=Matrix_Identity(len(L))

    for j in range(i+1,len(L)):
        Li[j][i]=L[j][i]

    return Li



##!
##! Matrix U_i (diagonal+uppers)
##!

def LU_LU_i(U,ii):
    L=Matrix_Identity(len(U))
    
    for i in range(ii+1):
        for j in range(i+1,len(U)):
            L[j][i]=U[j][i]
            U[j][i]=0.0

    return L,U



##!
##! Get Ls from L.
##!

def LU_Ls(L):
    n=len(L)

    Ls=[]
    for i in range(n-1):
        Lis=[]
        for j in range(i+1,n):
            Lis.append(
                LU_i_j(L,i,j)
            )

        Ls.append(Lis)

    return Ls


##!
##! Get LL from L: Acumulated.
##!

def LU_LLs(L):
    n=len(L)
    
    Ls=LU_Ls(L)
    
    LLs=[]
    for i in range(n-1):
        LLs.append(
            Matrices_Mult_List(Ls[i])
        )

    return LLs


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

    A=Matrix_Vandermonte([6,5,4,3,2,1])
    test=True
    pivotation=True
    

    LU_Fact(A,test,pivotation)
    
