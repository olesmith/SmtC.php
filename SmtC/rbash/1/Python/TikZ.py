import re,os,sys,socket
from datetime import datetime

from Latex import *

##!
##!
##!

def TikZ_Point(p):
    return "("+str(p[0])+","+str(p[1])+")"

##!
##!
##!

def TikZ_Points(ps,options="",draw_points=False):
    cs=[]
    pts=[]
    for p in ps:
        pts.append(TikZ_Point(p))

        if (draw_points):
            cs.append(
                "\\filldraw "+
                TikZ_Point(p)+
                " circle(1pt);"
            )
            

    return [
        "\\draw["+options+"]",
        " --\n".join(pts),
        ";",
    ]+cs

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

def TikZ_Node(node,options="",text=""):
    if (len(node)>2):
        text=node[2]
        
    return [
        "\\node["+options+"] at "+
        "("+str(node[0])+","+str(node[1])+")"+
        " {"+
        text+
        "};\n",
    ]

##!
##! Draw coordinate system.
##!

def TikZ_Coordinate_System(xy0,xy1,options="-latex",xtitle="$x$",ytitle="$y$"):        
    return [
        "%% Coordinate System",
        TikZ_Points(
            [
                [ xy0[0],0.0 ],
                [ xy1[0],0.0 ],
            ],
            options
        ),
        TikZ_Node(
            [ xy1[0],0.0],
            "right",
            "\\small{"+xtitle+"}"
        ),
        TikZ_Points(
            [
                [ 0.0,xy0[1] ],
                [ 0.0,xy1[1] ],
            ],
            options
        ),
        TikZ_Node(
            [ 0.0,xy1[1] ],
            "above",
            "\\small{"+ytitle+"}"
        ),
        "%% Coordinate System End",

    ]

##!
##! Includegraphics
##!

def TikZ_Includegraphics(tikzname):        
    pdfname=re.sub('(\.tikz)?\.tex',".pdf",tikzname)
    if (not os.path.isfile(pdfname)): return []
    
    return Latex_Environment(
        "center",
        ["\\includegraphics{"+pdfname+"}",]
    )

##!
##!
##!

def TikZ_Save(texname,tikz,options="",preamble=False):
    tikz=Latex_Text(tikz)
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
