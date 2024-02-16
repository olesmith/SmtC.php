from Isolate import Isolate_Root

def False_Position(f,a,b,eps=1.0E-6):
    #Sequence (list) of x-values
    xs=[]
    
    a,b=Isolate_Root(f,a,b)

    if (not a and not b):
        return xs
    
    fa,fb=f(a),f(b)
    
    stop=False
    while (not stop):
        x=(a*fb-b*fa)/(fb-fa)
        fx=f(x)
    
        if (fa*fx<0.0):
            b,fb=x,fx
        else:
            a,fa=x,fx
            
        #Add to sequence
        xs.append(   [x,fx]   )
        
        if (abs(fx)<eps): stop=True

    return xs
