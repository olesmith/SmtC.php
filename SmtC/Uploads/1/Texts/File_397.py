
##!
##! Derivative by definition: unsymmetric, o(epsilon).
##!

def DF_1(f,x,epsilon=1.0e-4):
    return (f(x+epsilon)-f(x))/epsilon

##!
##! Symmetric derivative, o(epsilon^2).
##!

def DF_2(f,x,epsilon=1.0e-4):
    return 0.5*(f(x+epsilon)-f(x-epsilon))/epsilon
