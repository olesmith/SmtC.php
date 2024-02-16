from math import sqrt

from Latex import *

##!
##! Print vector
##!

def Vector_Print(v):
    print (Vector_Text(v))
    
##!
##! Stringify vector
##!

def Vector_Text(v,indent=""):
    text=[]
    for i in range( len(v) ):
        text.append( ("%.6f" % v[i]) )

    return indent+"["+",".join(text)+"]"

##!
##! Stringify vector
##!

def Vector_Latex(v,title="",env="pmatrix",frmt="%.3f"):
    latex=[]
    for i in range( len(v) ):
        comp=str(v[i])
        if (
                isinstance(v[i],int)
                or
                isinstance(v[i],float)
        ):
            comp=frmt % v[i]
        latex.append(comp)

    latex=[" \\\\ ".join(latex) ]

    latex=Latex_Environment(env,latex)
    if (title!=""):
        latex=[
            "\\underline{"+title+"}="
        ]+latex
    

    return latex

##!
##! Add vectors.
##!

def Vectors_Add(v,w):
    if (   len(v)!=len(w)   ):
        print ("Vectors_Add: Vectors does not have same length")
        exit()
        
    u=[]
    for i in range( len(v) ):
        u.append( 1.0*(v[i]+w[i]) )

    return u

##!
##! Subtract vectors.
##!

def Vectors_Sub(v,w):
    if (   len(v)!=len(w)   ):
        print ("Vectors_Add: Vectors does not have same length")
        exit()
        
    u=[]
    for i in range( len(v) ):
        u.append( 1.0*(v[i]-w[i]) )

    return u

        
##!
##! Multiply vector by constant.
##!


def Vector_Mul(v,c):
    u=[]
    for i in range( len(v) ):
        u.append( c*v[i] )

    return u

      
##!
##! Linear combination
##!

def Vector_CL(a1,v1,a2,v2):
    if (   len(v1)!=len(v2)   ):
        print("Vectors_CL: Vectors does not have same length")
        exit();
        
    a1*=1.0
    a2*=1.0
    
    u=[]
    for i in range( len(v) ):
        u.append( a1*v1[i]+a2*v2[i] )

    return u

##!
##! Vector dotproduct.
##!


def Vectors_Dot(v,w):
    if (   len(v)!=len(w)   ):
        print("Vectors_Dot: Vectors does not have same length")
        exit();
        
    dot=0.0
    for i in range( len(v) ):
        dot+=v[i]*w[i]

    return dot

##!
##! Angle between vectors.
##!


def Vectors_Angle(v,w):
    return Vector_Dot(v,w)/(   Vector_Len(v)*Vector_Len(w)   )


##!
##! Vector length
##!

def Vector_Len(v):
    return sqrt(  Vector_SqLen(v)  )

##!
##! Vector square length.
##!

def Vector_SqLen(v):
    return Vector_Dot(v,v)

##!
##! Normalized vector.
##!

def Vector_Normalize(v):
    length=Vector_Len(v)

    e=list(v)
    if (length>0.0):
        e=Vector_Mul( v,1.0/length )
        
    return e

##!
##! Vector p-norm.
##!

def Vector_Norm_p(v,p=2.0):
    norm=0.0
    for i in range( len(v) ):
        norm+= abs(v[i])**p
        
    return norm**(1.0/p)

##!
##! Vector inf norm.
##!

def Vector_Norm_Inf(v):
    norm=0.0
    for i in range( len(v) ):
        if (abs(v[i])>norm):
            norm=abs(v[i])
        
    return norm

##!
##! Projection of v on w
##!

def Vector_Project(v,w):
    #Projects Vector v on Vector w
    e=Vector_Normalize(w)
    dot=Vector_Dot(v,e)
    
    return Vector_Mul(e,dot)

##!
##! Complement v-v projected on w
##!

def Vector_Complement(v,w):
    p=Vector_Project(v,w)

    return  Vector_Sub(v,p)
