from Isolate import Isolate_Root

def Bisection(f,a,b,eps=1.0E-6):
    #List of x-values
    xs=[]
    
    a,b=Isolate_Root(f,a,b)

    if (not a and not b):
        return xs
    
    fa=f(a)
    fb=f(b)
    
    
    stop=False
    while (not stop):
        x=0.5*(a+b)
        fx=f(x)
    
        if (fa*fx<0.0):
            b=x
            fb=fx
        else:
            a=x
            fa=fx
            
        #Add to sequence
        xs.append( [ x, fx ])
        
        if (abs(fx)<eps): stop=True

    return xs
