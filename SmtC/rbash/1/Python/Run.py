#!/usr/bin/python3

from Isolate        import Isolate_Root
from Bisection      import Bisection
from False_Position import False_Position
from Fixed_Point    import Fixed_Point
from Newton_Raphson import Newton_Raphson
from Secant         import Secant
 
import re

##!
##! Runs function f(x) through relevant algorithms.
##!

def Function_Run(f,a,b=False,df=False,phi=False,fname="",x0=False,eps=1.0E-6,maxiterations=100):

    formats=["%03d","%.6f","%.6e"]
    
    estimates=[    "\t".join(["Iter","x","","f(x)","","Algorithm"])   ]
    if (b):
        ################################
        algorithm="Bisection"
        xs=Bisection(f,a,b,eps)

        if (xs):
            print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
            estimates.append(  Function_Estimate(algorithm,xs)  )


        
        ################################
        algorithm="False_Position"
        xs=False_Position(f,a,b,eps)
        
        if (xs):
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

        if (not x0):
            x0=0.5*(a+b)
        
        xs=Fixed_Point(f,phi,x0,eps)
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


    
    if (df):
        ################################
        algorithm="Newton Raphson"
        
        if (not x0):
            x0=0.5*(a+b)
            
        xs=Newton_Raphson(f,df,x0,eps)
        print(   Function_Values_Text(xs,formats,fname,algorithm,eps )   )
        estimates.append(  Function_Estimate(algorithm,xs)  )


    print("\n\n"+"\n".join(estimates))

##!
##! Print tables as text
##!

def Function_Values_Text(xs,formats,fname,algorithm,eps):
        table=Function_Values_Table(xs,formats,fname,algorithm,eps)

        lines=[]
        for i in range(len(table)):
            lines.append( "\t".join(table[i]))
            
        return "\n".join(lines)

    
##!
##! Generate as a table (matrix)
##!

def Function_Values_Table(xs,formats,fname,algorithm,eps):
    table=[
        [    fname,algorithm , str(eps),str(len(xs)-1)+" iterations"    ],
        [    "n", "x","\tf(x)"    ],
    ]

    for n in range(len(xs)):
        cells=[formats[ 0 ] % (n)]
        
        for i in range(len(xs[n])):
            cell=formats[ i+1 ] % (xs[n][i])
                
            cells.append(cell)
                            
            table.append(  cells   )
            
    return table
      
def Function_Estimate(algorithm,xs):
    estimate_format="%d\t%.6f\t%.6e\t%s"

    x=xs[ len(xs) -1 ]

    return estimate_format % (len(xs) -1,x[0],x[1],algorithm)
