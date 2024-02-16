
##!
##! Usage:
##!
##! DF_Table(f,df,0.1,1,10)
##!
##! f:  function (def)
##! df: Analytical derivative
##!
##! f:  function (def)
##! df: Analytical derivative
##!

def DF_Table(f,df,xl,xf,N):
    dx=(xf-xl)/(11.0*N)

    x=xl
    for n in range(N+1):
        y=f(x)
        dy=df(x)

        #Numerical derivatives
        dy1=DF_1(f,x)
        dy2=DF_2(f,x)

        error1=abs( (dy-dy1)/dy )
        error2=abs( (dy-dy2)/dy )
        

        print(
            "%d\t%.6f\t%.6f\t%.6f\t%.6f\t%.6f\t%.6e\t%.6e"
            %
            (n,x,y,dy,dy1,dy2,error1,error2)
        )
        x+=dx
