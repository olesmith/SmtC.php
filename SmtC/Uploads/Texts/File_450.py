def Secant(f,x0,x1,eps=1.0E-6,maxiteration=100):
    #List of x-values

    xk0=x0
    xk1=x1
    xs=[
        [xk0,f(xk0)],
        [xk1,f(xk1)],
    ]
    
    stop=False
    iteration=0
    while (not stop):
        dfk=(   f(xk1)-f(xk0)   )/(  xk1-xk0  )
        
        xk=xk1-f(xk1)/dfk
        
        if ( abs(f(xk))<eps   ): stop=True
        if ( abs(xk1-xk)<eps   ): stop=True
        if ( iteration>maxiteration ): stop=True
        
        xk1=xk0
        xk0=xk
        xs.append(   [xk,f(xk) ]   )
        iteration+=1

    return xs

