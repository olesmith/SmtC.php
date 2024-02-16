import re,os,sys,socket
from datetime import datetime

##!
##!

def TikZ_Point(p):
    return "("+str(p[0])+","+str(p[1])+")"


##!
##! Nodes of list of nodes: [ [x,y,text],...].
##!

def TikZ_Nodes(nodes,options=""):
    tikz=[]
    for n in range(len(nodes)):
        tikz=tikz+TikZ_Node(nodes[n],options)

    return tikz

##!
##! Nodes of list of node: [x,y,text].
##!

def TikZ_Node(node,options=""):
    return [
        "\\node["+options+"] at",
        "("+str(node[0])+","+str(node[1])+")",
        "{",
        node[2],
        "};\n",
    ]

##!
##!
##!

def TikZ_Save(texname,tikz,options="",preamble=False):
   
    f=open(texname,"w" )

    n_bytes=0
    for line in tikz:
        f.write("%s\n" % line)
        n_bytes+=len(line)
        
    f.close()
    tell=True
    if (tell):
        print(n_bytes,"bytes written to:",texname)

    

 
##!
##!
##!

def TikZ_Run(texname,tikz,options="",preamble=False,gen_svg=True,clean=True):

    TikZ_Save(texname,tikz,options,preamble)

    command="tikz2pdf"
    if (gen_svg): command="tikz2svg"
    
    command=" ".join([
        "/usr/local/bin/"+command,
        texname,
        ">",
        texname+".log",
        "&2>1"
    ])


    res=os.system(command)
    print(command+":",res)

    return res
