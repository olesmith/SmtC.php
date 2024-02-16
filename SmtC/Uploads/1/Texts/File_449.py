def Fixed_Point(f,phi,x0,eps=1.0E-6,maxiteration=100):
    #List of x-values
    
    x=x0
    xs=[   [x,f(x)]  ]
    
    stop=False
    iteration=0
    while (not stop):
        x1=phi(x)
        f1=f(x1)
        
        if ( abs(f1)<eps   ): stop=True
        if ( abs(x1-x)<eps   ): stop=True
        if ( iteration>maxiteration ): stop=True
        
        x=x1
        xs.append(   [x1,f1]   )
        iteration+=1

    return xs
