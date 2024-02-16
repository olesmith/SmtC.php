from Gauss import *

#Ruggiero, Cap 3, Ex 6a

A=[
    [ 3.0,-2.0, 5.0,1.0],
    [-6.0, 4.0,-8.0,1.0],
    [ 9.0,-6.0,19.0,1.0],
    [ 6.0,-4.0,-6.0,15.0],
]

b=[7.0,-9.0,23.0,11.0]



det=Gauss_Test(A,b)
det=Gauss_Test(A,b,1)

