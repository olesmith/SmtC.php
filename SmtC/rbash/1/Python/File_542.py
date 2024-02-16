from Gauss import *

#Ruggiero, Cap 3, Ex 5
A=[
    [2.0, 2.0, 1.0, 1.0],
    [1.0,-1.0, 2.0,-1.0],
    [3.0, 2.0,-3.0,-2.0],
    [4.0, 3.0, 2.0, 1.0],
]

b=[7.0,1.0,4.0,12.0]



det=Gauss_Test(A,b)
det=Gauss_Test(A,b,1)

