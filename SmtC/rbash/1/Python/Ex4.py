from Gauss import *


print ("A=")
A=Matrix_Vandermonte([2.0,3.0,4.0,1.5])

Matrix_Print(A)

b=[7.0,8.0,9.0,1.0]



det=Gauss_Test(A,b)
det=Gauss_Test(A,b,1)

