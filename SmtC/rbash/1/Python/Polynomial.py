#!/usr/bin/python3

##!
##! Represent a polynomia by a simple list.
##!

##!
##! Print a polynomia (text)
##!

def Polynomia_Print(P):
    print(  Polynomia_Text(P) )
        
##!
##! Polynomia to text.
##!

def Polynomia_Text(P,frmt="%.6f"):
    texts=[]
    for i in range( len(P) ):
        text=frmt % P[i]
        if (i==0):   text=text+''
        elif (i==1): text=text+'x'
        else:        text=text+'x**'+str(i)

        if (i<len(P)-1 and P[i]>0.0):
            text="+"+text

        if (abs(P[i])>0):
            texts.append(text)

    texts=list(reversed(texts))
    
    return " ".join(texts)
        
##!
##! Polynomia to latex.
##!

def Polynomia_Latex(P,frmt="%.6f"):
    latex=[]
    for i in range( len(P) ):
        if (abs(P[i])==0):
            continue
        
        text=""
        if (P[i]!=1.0 or i==0):
            text=(frmt % P[i])
            if (i>0):
                text=text+"\\cdot "
            
        if (i==0):   text=text+''
        elif (i==1): text=text+'x'
        else:        text=text+'x^{'+str(i)+'}'

        if (i<len(P)-1 and P[i]>0.0):
            text="+"+text

        latex.append(text)

    return " ".join(reversed(latex))
        
##!
##! Simplistic way of calculating polynomial value.
##!

def Polynomia_Calc_Dumb(P,x):
    value=0.0
    for i in range( len(P) ):
        value+= P[i]*x**i
        
    return value

##!
##! More efficient way of calculating polynomial value, less operations.
##!

def Polynomia_Calc(P,x):
    value=0.0
    for i in range(len(P)-1,-1,-1 ):
        value=value*x+P[i]
        
    return value

##!
##! Calculate polynomial values on a list of xs.
##!

def Polynomia_Calcs(P,xs):
    value=[]
    for x in xs:
        values.append(
            [x,Polynomia_Calc(P,x)]
        )
        
    return values

##!
##! Draw polynomia values using TikZ.
##!

def Polynomia_TikZ_Draw(P,x_min,x_max,N):
    dx=(x_max-x_min)/(1.0*N)
    
    tikz=[]

    x=x_min
    for n in range(N+1):
        y=Polynomia_Calc(P,x)
        
        tikz.append(   "("+str(x)+","+str(y)+")"   )
        x+=dx

    tikz=[
        "\\draw   "+
        "--\n\t".join(tikz)+";",
    ]

    
    return tikz

##!
##! Add two polynomias.
##!

def Polynomias_Add(P,Q):
    degree=max( len(P),len(Q) )
    R=[]
    for i in range( degree ):
        R.append(0.0)
        if (i<len(P)):
            R[i]+=P[i]
            
        if (i<len(Q)):
            R[i]+=Q[i]
            
    return R

##!
##! Multiply polynomia with constant.
##!

def Polynomia_Mult(P,c):
    R=[]
    for i in range( len(P) ):
        R.append(  P[i]*c  )
            
    return R

##!
##! Multiply two polynomias.
##!

def Polynomias_Mult(P,Q):
    degree=len(P)+len(Q)-1
    
    R=[]
    for i in range( degree ):
        R.append(0.0)
        
    for i in range( len(P) ):
        for j in range ( len(Q) ):
            R[i+j]+=P[i]*Q[j]
    return R

##!
##! To keep SmtC happy.
##!

def dummy():
    return 0

###!
###! Testing ###
###!
###!

if (__name__=='__main__'):
    P=[-1.0,1.0,1.0]
    Q=[ 1.0,1.0]
    R=Polynomias_Mult(P,Q)

    latex=[
        "("+Polynomia_Latex(P)+")",
        "\\cdot",
        "("+Polynomia_Latex(Q)+")",
        "=",
        Polynomia_Latex(R),
    ]

    print("\n".join(latex))
    
