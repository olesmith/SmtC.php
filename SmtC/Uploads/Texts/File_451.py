def Newton_Raphson(f,df,x0,eps=1.0E-6,maxiterations=100):
    #List of x-values
    
    x=x0
    xs=[    [x,f(x)]   ]
    
    stop=False
    iteration=0
    while (not stop):
        #Next x
        fx=f(x)
        x1=x-fx/df(x)
        
        if ( abs(fx)<eps   ): stop=True
        if ( abs(x1-x)<eps   ): stop=True
        if ( iteration>maxiterations ): stop=True

        #Update
        x=x1
        xs.append(   [x,fx]   )
        iteration+=1

    return xs
