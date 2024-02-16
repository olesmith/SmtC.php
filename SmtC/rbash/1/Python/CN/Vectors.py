from math import *

#from Scalar   import *

def Format_Real(t):
    return "%.6f" % t

class Vector(list):
    
    ##!
    ##! Creator
    ##!
    
    def __init__(v,w=[]):
        if (w.__class__.__name__=="int"):
            v.__Calloc__(w)
            
        else:
            v.__Calloc__( len(w) )
            for i in range( len(w) ):
                v[i]=1.0*w[i]
        
    ##!
    ##! Fill with 0.0's
    ##!
    
    def __Calloc__(v,size):
        for i in range(size):
            v.append(0.0)
        
    ##!
    ##! Overload + (add operator)
    ##!
    
    def __add__(v,w):
        
        u=Vector(v)
        for i in range(len(v)):
            u[i]+=w[i]
        return u
 
    ##!
    ##! Overload += (iadd operator)
    ##!
    
    def __iadd__(v,w):
        return v+w

    ##!
    ##! Overload - (sub operator)
    ##!
    
    def __sub__(v,w):
        u=Vector(v)
        for i in range(len(v)):
            u[i]-=w[i]
        
        return u
 
    ##!
    ##! Overload -= (isub operator)
    ##!
    
    def __isub__(v,w):
        return v-w
 
    ##!
    ##! Overload - (neg operator, oposite)
    ##!
    
    def __neg__(v):
        return v*(-1.0)

    
    ##!
    ##! Overload * (mul operator).
    ##! Depending on w.__class__ .__name__ acts accordingly.
    ##!
    
    def __mul__(v,w):
        if (w.__class__.__name__=="Vector"):
            dot=0.0
            for i in range( len(v) ):
                dot+=v[i]*w[i]
            return dot
        
        if (w.__class__.__name__=="Matrix"):
            u=Vector()
            u.__Alloc__( len(w) )
            
            for i in range( len(w) ):
                u[i]=0.0
                for j in range( len(v) ):
                    u[i]+=w[j][i]*v[j]
                    
            return u
        
        #We should be e number from now on
        if (w.__class__.__name__=="int"):
            w*=1.0
            
        if (w.__class__.__name__=="float"):
            u=Vector(v)
            for i in range( len(v) ):
                u[i]*=w
            return u

        print("Vector.__mul__: Invalid second argument: ",w.__class__.__name__)
        
    ##!
    ##! Overload +* (imul operator)
    ##!
    
    def __imul__(v,w):
        return v*w
    
    ##!
    ##! Overload * (rmul operator
    ##! if first arg is float, call * on reversed pair w,v
    ##!
    
    def __rmul__(v,w):
        if (v.__class__.__name__=='float'):
            return w*v

        return v*w
 
    ##!
    ##! Overload / (div operator).
    ##! Depending on w.__class__ .__name__ acts accordingly
    ##!
    
    def __div__(v,b):
        #We should be e number from now on
        if (b.__class__.__name__=="int"):
            w*=1.0
            
        if (b.__class__.__name__=="float"):
            u=Vector(v)
            for i in range( len(v) ):
                u[i]/=b
            return u

        print ("Vector.__div__: Invalid second argument: ",b.__class__.__name__)
         
    ##!
    ##! Overload /= (idiv operator)
    ##!
    
    def __idiv__(v,b):
        return v/b

    
    ##!
    ##! Overload stringify (text - str operator)
    ##!
    

    def __str__(v):
        vs=map(Format_Real,v)
        return "(" + ",".join(vs) + ")"
 
    ##!
    ##! Make html from vector.
    ##!
    
    def __html__(v):
        vs=map(Format_Real,v)
        return "(" + ",<BR>".join(vs) + ")"
 
    ##!
    ##! Calculate dot product.
    ##!
    
    def DotProduct(v,w):
        return v*w
     
    ##!
    ##! Square length
    ##!
    
    def Length2(v):
        return v.DotProduct(v)
     
    ##!
    ##! Length
    ##!
    
    def Length(v):
        return sqrt( v.Length2() )
     
    ##!
    ##! Normalize vector to length=1.0
    ##!
    
    def Normalize(v,length=1.0):
        if (v.Length()>0.0):
            v*=length/v.Length()

        return v
     
    ##!
    ##! Transverse vector (R2)
    ##!
    
    def Transverse2(v,length=1.0):
        return Vector([ -length*v[1],length*v[0] ])
                   
    ##!
    ##! Determinant (R2)
    ##!
        
    def Determinant2(v,w):
        return v[0]*w[1]-w[0]*v[1]
     
    ##!
    ##!
    ##!
    
    def Max(v,vv):
        if (len(v)==0): v=Vector( len(vv) )

        for i in range( len(vv) ):
            v[i]=Max(v[i],vv[i])
                
        return v
                 
    ##!
    ##! Find abs max
    ##!
    
    def Abs_Max(v,vv):
        if (len(v)==0): v=Vector( len(vv) )

        for i in range( len(vv) ):
            v[i]=Max(   abs(v[i]),abs(vv[i])  )
                
        return v
                 
    ##!
    ##! Find min
    ##!
    
    def Min(v,vv):
        if (len(v)==0): v=Vector( len(vv) )
        
        for i in range( len(vv) ):
            v[i]=Max(v[i],vv[i])
                
        return v
                 
    ##!
    ##! Rotate (R2)
    ##!
    
    def Rotate2(v,theta):
        return Vector([
            cos(theta)*v[0]-sin(theta)*v[1],
            sin(theta)*v[0]+cos(theta)*v[1],
        ])
    
    ##!
    ##! Vector angle, in R2.
    ##!
    
    
    def Angle2(v):
        if (v[0]>0.0):
            ang=atan(v[1]/v[0])
        elif (v[0]<0.0):
            if (v[1]>=0.0):
                ang=atan(v[1]/v[0])+pi
            else:
                ang=atan(v[1]/v[0])-pi
        elif (v[0]==0.0):
            if (v[1]>0.0):
                ang=pi/2.0
            else:
                ang=-pi/2.0
        else:
            return None
        
        while (ang<0.0):
            ang+=2.0*pi
            
        return ang
         
    ##!
    ##! Vector radian angle, in R2.
    ##!
    
    def Radian2(v):
        rad=int( 180.0*v.Angle2()/pi )
        while (rad>360):
            rad-=360
        while (rad<0):
            rad+=360

        return rad
 
    ##!
    ##! Sum vector coordinates
    ##!
    
    def Sum(v):
        res=0.0
        for i in range( len(v) ):
            res+=v[i]

        return res
 
    ##!
    ##! Multiply vector coordinates
    ##!
    
    def Product(v):
        prod=1.0
        for i in range( len(v) ):
            prod*=v[i]

        return prod
    
            
##!
##!
##!
    
      
def Print(vs):
    for i in range( len(vs) ):
        print (i,"\t",vs[i])
           
##!
##!
##!
   
def Vectors_Max(vs):
    vm=vs[0]
    for i in range( len(vs) ):
        for j in range( len(vs[i]) ):
            vm[ j ]=Max(vm[ j ],vs[ i ][ j ])

    return vm
                   
##!
##!
##!
         
def Vectors_Min(vs):
    vm=vs[0]
    for i in range( len(vs) ):
        for j in range( len(vs[i]) ):
            vm[ j ]=Min(vm[ j ],vs[ i ][ j ])

    return vm
                         
##!
##! Vector determinant if R2
##!
   
def Determinant2(v,w):
    return v.Determinant2(w)
       
##!
##! Rotate vector in R2.
##!
   
def Rotate2(v,t):
    return v.Rotate2(t)
      
##!
##! The e-vetor: [cos(omega t),sin(omaega t)]
##!
   
def E(t,omega=1.0):
    return Vector([cos(omega*t),sin(omega*t)])
         
##!
##! The f-vector: [-sin(omega t),cos(omaega t)]
##!
   
def F(t,omega=1.0):
    return Vector([-sin(omega*t),cos(omega*t)])
         
##!
##! p-vector
##!
   
def P(t,omega=1.0):
    return Vector([-cos(omega*t),sin(omega*t)])
         
##!
##! q-vector.
##!
   
def Q(t,omega=1.0):
    return Vector([-sin(omega*t),-cos(omega*t)])

               
##!
##! Tests to run, when we are main.
##!
   
def Test():
    u=Vector([4,5,6])
    v=Vector([1,2,3])

    u+=v

    d=u
    d*=v
    print(d)
    print(u,"+",v,"=",(u+v))

    print(u,"*",v,"=",u*v)

    print(u,"*",2,"=",u*2)
    
    print (u,"*",v,"=",u*v)
    print("2*",v,"=",2*v)


if (__name__=='__main__'):
    #Only run, if we are the main script
    Test()

    
