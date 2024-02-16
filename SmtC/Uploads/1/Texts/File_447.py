
##!
##! Isolate a root on interval [a,b], if possible.
##!

def Isolate_Root(f,a,b,NMax=10):
    N=2
    while (N<NMax):
        #Make sure we do division of reals
        dx=1.0*(b-a)/(1.0*N)

        x=a
        fx=f(x)
        
        x1=x+dx
        for i in range(N):
            fx1=f(x1)
            if (fx*fx1<0.0):
                #Found! Return with the good news
                return x,x1
            x=x1
            x1+=dx
            fx=fx1

        N+=1

    #Suitable interval not found
    print("Invalid interval: ["+str(a)+","+str(b)+"]")
    
    return None,None
