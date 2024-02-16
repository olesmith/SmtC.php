#!/usr/bin/python3

from Isolate        import Isolate_Root
from Bisection      import Bisection
from False_Position import False_Position
from Fixed_Point    import Fixed_Point
from Newton_Raphson import Newton_Raphson
from Secant         import Secant
 
import re
   
def Function_Run(f,a,b=False,df=False,phi=False,fname="",eps=1.0E-6,maxiterations=100):

    formats=["%03d","%.6f","%.6e"]
    
    estimates=[    "\t".join(["Iter","x","","f(x)","","Algorithm"])   ]
    if (b):
        ################################
        algorithm="Bisection"
        xs=Bisection(f,a,b,eps)

        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


        
        ################################
        algorithm="False_Position"
        xs=False_Position(f,a,b,eps)
        
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps)   )
        estimates.append(  Function_Estimate(algorithm,xs)  )

        ################################
        algorithm="Secant"

            
        xs=Secant(f,a,b,eps)
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


    
    if (phi):
        ################################
        algorithm="Fixed_Point"

        x0=0.3*(a+b)
        
        xs=Fixed_Point(f,phi,x0,eps)
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


    
    if (df):
        ################################
        algorithm="Newton Raphson"
        
        x0=0.5*(a+b)
            
        xs=Newton_Raphson(f,df,x0,eps)
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


    print("\n\n"+"\n".join(estimates))

def Function_Values_Text(xs,formats,fname,algorithm,eps):
        sep="-"*7
        
        titles1=[    fname,algorithm , str(eps),str(len(xs)-1)+" iterations"    ]
        titles2=[    "n", "x","\tf(x)"    ]

        titles="\t".join(titles1)
        titles=re.sub('.',"-",titles)
        
        lines=[
            titles,
            "\t".join(titles1),
            titles,
            "\t".join(titles2),
            titles,
        ]

        for n in range(len(xs)):
            line=[formats[ 0 ] % (n)]
            for i in range(len(xs[n])):
                cell=formats[ i+1 ] % (xs[n][i])
                
                line.append(cell)
                            
            lines.append(  "\t".join(line)    )
            
        return "\n".join(lines)
    
def Function_Estimate(algorithm,xs):
    estimate_format="%d\t%.6f\t%.6e\t%s"

    x=xs[ len(xs) -1 ]

    return estimate_format % (len(xs) -1,x[0],x[1],algorithm)
