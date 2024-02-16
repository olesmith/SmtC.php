#!/usr/bin/python3

from math import *

eps=1.0E-16

##!
##! Sums infinite series sum a(n,p)
##!

def Series_Sum(a,p):
    s=0.0

    NMax=10000
    
    run=True
    n=0
    while (n<NMax):
        n+=1
        
        an=a(n,p)
        s+=an

        if (abs(an)<eps):
            ##print("Convergence",n,s,an,eps)
            run=False

    return s

    
def ap(n,p):
    n=1.0*n
    return 1.0/(n**p)

def pi_p(p):
    return pi**p

def TikZ_Draw(ps,color):
    tikz=[]

    for p in ps:
        tikz.append( "("+str(p[0])+","+str(p[1])+")"   )

        
    return "\\draw[color="+color+"]\n\t"+" --\n\t".join(tikz)

def Factorial(n):
    prod=1.0
    while (n>0):
        prod*=n
        n-=1

    return prod

#print("p\tsum\t\t\tf")

N=100
p1=2.0
p2=20.0
dp=0.1

ss=[]
fs=[]

table=[]

for n in [2,4,6,8,10,12,14,16,18]:
    p1=n
    p2=n+2
    p=1.0*p1
    for i in range(10):
        if (i>0): p=p1+dp*i
        
        s=Series_Sum(ap,p)
        f=pi_p(p)/s

        ss.append(   [p,s]   )
        fs.append(   [p,f]   )

        text="{pt:.2f}\t{st:.8f}\t{ft:.8f}"
        text=text.format(pt=p,st=s,ft=f)
        table.append(text)
        p+=dp

#print("\n".join(table))


#print(TikZ_Draw(ss,"blue"))

#print(TikZ_Draw(fs,"orange"))

fteos=[
    [2,6.0],
    [4,90.0],
    [6,945.0],
    [8,9450.0],
    [10,93555.0],
    [12, Factorial(15)/(    691.0*(2.0**11)   )],
    [14, 3.0*Factorial(13)/(    (2.0**11)   )],
    [16,
     (15.0/3617.0)
     *
     (Factorial(17)/2.0**14)
    ],
    [18,
     (   Factorial(7) /43867.0*15.0   )
     *
     (   Factorial(19)/(2.0**20)   )
    ],
]

print("p\tf\t\ySum\t\tTeo\t\tErr")
for i in range(len(fteos)):
    p=fteos[i][0]
    f=fteos[i][1]
    
    s_teo=pi_p(p)/f
    s_num=Series_Sum(ap,p)

    res=abs(    (s_teo-s_num)/s_teo   )
    
    fteos[i].append(s_teo)
    fteos[i].append(s_num)
    fteos[i].append(res)

for i in range(len(fteos)):
    text="%d\t%.6f\t%.6f\t%.6f\t%.6e" % (fteos[i][0],fteos[i][1],fteos[i][2],fteos[i][3],fteos[i][4])
    
    print(text)
