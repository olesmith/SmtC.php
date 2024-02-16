"use strict";



function Curve_Functions_Detect(curve)
{
    let funcs=[];
    
    curve[ "v" ]=false;
    if (typeof v === 'function')
    {
        funcs.push("v");
        curve[ "v" ]=Curve_Calc_v(v);
    }
    
    curve[ "d" ]=false;
    if (typeof d === 'function')
    {
        funcs.push("d");
        curve[ "d" ]=Curve_Calc_v(d);
    }
    
    curve[ "omega" ]=false;
    if (typeof omega === 'function')
    {
        funcs.push("omega");
        curve[ "omega" ]=Curve_Calc_v(omega);
    }
    
    curve[ "nu" ]=false;
    if (typeof nu === 'function')
    {
        funcs.push("nu");
        curve[ "nu" ]=Curve_Calc_v(nu);
    }

    return funcs;
}

function Curve_SVG_OOOLD(setup,curve)
{

    let div=document.createElement('div');
    div.style.display="flex";
    div.style.flexDirection="column";
    
    let rdiv=document.createElement('div');

    let table=Curve_Control_Curve_Table(setup);

    rdiv.append(table);
    
    let sdiv=document.createElement('div');
    sdiv.append(svg.svg);

    
    div.append(rdiv);
    div.append(sdiv);
    
    
    element.append(div);

    return curve;
}


function Curve_Control_Curve_Rows_OLD(section,parts,setup)
{
    //old
    let row=[""];
    let rows=[""];
    rows.push(row);
    
    let components=["Curve","Mesh","Vectors"];
    for (let n=0;n<components.length;n++)
    {
        continue;
        row=[components[n]];

        for (let m=0;m<parts.length;m++)
        {
            let part=parts[m];

            let input="";
            if (setup[ section ][ part ] && setup[ section ][ part ][ components[n] ])
            {
                input=Curve_Control_Curve_Part_Stoke
                (
                    section,part,setup,components[n],
                    setup[ section ][ part ][ components[n] ]
                );
            }

            row.push(input);
        }
            
        //let table=Curve_Control_Curve_Part_Rows(section,parts[n],setup);
        rows.push(row);
    }

    
    return table;
}

//From Curve/Curve.js

function Curve_Curves_SVG000(setup,curve,others=true)
{
    let svg=new MySVG(setup.Curve);
    
    svg.SVG_WCS
    (
        svg.svg,
        setup.Curve
    );

    let id=Curve_Curves_Defs_ID(setup);

    let g;

    if (others)
    {
        g=Curve_Curves_SVG_Create_Others(svg,setup,curve,id);
        svg.svg.append(g);
    }

    Curve_Curve_SVG_Defs(svg,setup,curve,id);
    Curve_SVG_Uses(svg,setup[ "Curve" ],id);
    
    if (setup[ "Parameters" ][ "Values" ])
    {
        let opacity=1.0;
        let dopacity=Curve_dOpacity(setup);
        for (let n=0;n<setup[ "Parameters" ][ "Values" ].length;n++)
        {
            opacity-=dopacity;
            
            Curve_Set_Parameter(setup[ "Parameters" ][ "Values" ][ n ]);
            let rcurve=Curve_Calc(setup);
            let rid=id+"_"+n;
            
            Curve_Curve_SVG_Defs(svg,setup,rcurve,rid,opacity,true);
            Curve_SVG_Uses(svg,setup[ "Curve" ],rid,rid);
        }
    }

    //??
    svg.svg.focus();
    
    return svg.svg
}

function Curve_Curve_SVG_Defs000(svg,setup,curve,id,opacity=1.0,hide=false)
{
    let defs=svg.SVG_Create('defs');
    
    let g=Curve_Curve_SVG_Create(svg,setup,curve,id,opacity);
    if (hide) { g.style.display="none"; }

    defs.append(g);
    
    svg.svg.append(defs);
}

function Curve_Curve_SVG_Create000(svg,setup,curve,id,opacity=1.0)
{
    let g=svg.SVG_Create('g',{ "id": id,});

    g.classList.add("Comp",id);

    let g_derivatives=Curve_Curve_SVG_Create_Derivatives(svg,setup,curve,opacity);
    let g_meshes=Curve_Curve_SVG_Create_Meshes(svg,setup,curve,opacity);

    g.append(g_derivatives);
    g.append(g_meshes);


    return g;
}

function Curve_Curve_SVG_Create_Meshes0000(svg,setup,curve,opacity=1.0)
{
    let g=svg.SVG_Create('g',{"class": "Meshes"});
    
    //R last
    let curves=["Rolling","Evolute","R"];

    //Mesh and curve
    for (let n=0;n<curves.length;n++)
    {
        if (curve[ curves[n] ])
        {
            let options=Hash(setup.Curve[ curves[n] ]);

            if (opacity<1.0)
            {
                options[ "opacity" ]=opacity;
            }
            
            svg.SVG_Curve_R
            (
                g,curves[n],
                curve[ curves[n] ],
                options
            );
        }
    }

    return g;
}



function Curve_Curve_SVG_Create_Derivatives0000(svg,setup,curve)
{
    let g=svg.SVG_Create('g',{"class": "Derivatives"});
    
    //With vectors
    let curves=["dR","d2R"];
    for (let n=0;n<curves.length;n++)
    {
        if (curve[ curves[n] ])
        {
            svg.SVG_Curve_Vectors
            (
                g,curves[n],
                curve[ "R" ],curve[ curves[n] ],
                setup.Curve[ curves[n] ]
            );
        }
    }

    return g;
}

function Curve_Curves_SVG_Create_Others000(svg,setup,curve,id)
{
    let g=svg.SVG_Create('g',{});
    
    //Frenet
    if (curve[ "T" ])
    {
        svg.SVG_Curve_Frenet
        (
            g,
            "Frenet",
            setup[ "Curve" ][ "Frenet_P" ],
            curve[ "T" ],curve[ "N" ],
            setup[ "Curve" ][ "Frenet" ]
        );
    }

    
    //Osculating circles
    if (curve[ "Evolute" ])
    {
        svg.SVG_Curve_Osculating
        (
            g,
            "Osculating",
            curve[ "Evolute" ],
            curve[ "rho" ],
            setup[ "Curve" ][ "Osculating" ]
        );
    }
    
    //Rolling circles
    if (curve[ "Rolling" ])
    {
        svg.SVG_Curve_Rolling
        (
            g,
            "Rolling",
            setup.Curve[ "Rolling" ][ "R" ],
            curve[ "Rolling" ],
            setup[ "Curve" ][ "Rolling" ]
        );
    }

    return g;
}


//From Curve.js




//*
//* Having the curve svg in a svg defs-tag,
//* with id id, create at the least on use field.
//* Additional uses are specified view Curve of Functions "Uses".
//*

function Curve_SVG_Uses000(svg,setup,id,use_id=false)
{
    if (!use_id) { use_id=id; }

    use_id=setup[ "ID" ]+"_use";
    
    let use;
    use=svg.SVG_Create
    (
        'use',
        {
            "x": 0,
            "y": 0,
            "xlink:href": "#"+id,
            "id": use_id,
        }
    );
    
    svg.svg.append(use);
    let uses=setup[ "Uses" ];
    
    for (let n=0;n<uses.length;n++)
    {
        use=svg.SVG_Create
        (
            'use',
            {
                "x": uses[n][0],
                "y": uses[n][1],
                "xlink:href": "#"+id,
            }
        );
        svg.svg.append(use);
    }
}

function Curves_Mark_Curves_old(n,svg_id,clss="Curve")
{
    let svg=document.getElementById(svg_id+"_defs");
    if (!svg)
    {
        console.log("No such SVG element",svg_id+"_defs");

        return;
    }
     
    let no=0;
    for (let m=0;m<=Setup.Parameters.N;m++)
    {
        let elements=svg.getElementsByClassName(clss+"_"+m);
        for (let k=0;k<elements.length;k++)
        {
            //let opcaity=1.0;
            if (m<=n)
            {
                elements[k].style.opacity='1.0';
                //elements[k].style.display='inline';
                no+=1;
            }
            else
            {                
                elements[k].style.opacity='0.5';
                //elements[k].style.display='none';
            }
        }
    }
}


//From Curve/Functions.js


//Old
function Curve_Animation_Tslll(N)
{
    //let setups=[ Setup.Curve, Setup.Functions ];
    let setup=Setup.Curve;

    let svg_id=setup[ "ID" ];
    let svg=Element_By_ID(svg_id);
    if (svg)
    {        
        let gs=Elements_By_Class("Points",svg,"g");
        for (let n=0;n<gs.length;n++)
        {
            let gss=Elements_By_Class("Comp",gs[n],"g");

           for (let m=0;m<gss.length;m++)
            {
                let node=Elements_By_Class("Node",gss[m],"g");

                let segments=Elements_By_Class("N_"+N,gss[m],"line");
                if (node && segments.length>0)
                {
                    node=node[0];
                    let point=segments[0];
                    if (point)
                    {
                        let circle=node.children[0];
                        console.log(circle);
                        if (circle)
                        {
                            let x=point.getAttributeNS("","x2");
                            let y=point.getAttributeNS("","y2");

                            circle.setAttributeNS("","cx",x);
                            circle.setAttributeNS("","cy",y);
                            console.log(x,y,circle);

                        }
                    }
                }
            }
        }
    }
}


function Curve_SVG_Function000(svg,setup,curve,func)
{
    svg.SVG_Curve_v
    (
        f,func,
        curve[ func ],
        setup[ "Functions" ][ func ]
    );
}

//From Animation.js

function Curve_Animation_Ts_Old(n)
{
    let setups=[ Setup.Curve, Setup.Functions ];

    let res=[];
    for (let m=0;m<setups.length;m++)
    {
        let rres=Curves_Mark_Points
        (
            n,
            setups[m].ID
        );

        res.concat(rres);
        
        if (false)
        {
            Curves_Mark_Curves
            (
                n,
                setups[m].ID
            );
        }
    }
}



function Curve_Curves_Defs_ID(setup)
{
    return setup.Curve.ID+"_defs";
}
function Curves_Mark_Points(n,svg_id,clss="Node")
{
    let res=[];
    
    let svg=document.getElementById(svg_id);
    if (!svg)
    {
        console.log("No such SVG element",svg_id);

        return res;
    }
    
    let def_id=svg_id+"_defs";
    
    let defs=svg.getElementsByTagName('defs');
    if (!defs)
    {
        console.log("No such DEFs element",def_id);

        return res;
    }

    let style_marked=
        {
            "opacity": 1.0,
            "display": "inline",
        };
    
    let attr_marked=
        {
            "marked": 2,
        };
    
     let style_unmarked=
        {
            "opacity": 0.5,
            "display": "none",
        };
    
    let attr_unmarked=
        {
            "marked": 1,
        };

    let n_changed=0;
    for (let k=0;k<defs.length;k++)
    {
        let elements=Elements_By_Class('Node',defs[k],"g");

        for (let e=0;e<elements.length;e++)
        {
            let element=elements[e];

            let marked=1;
            if (!element.hasAttributeNS("","marked"))
            {
                marked=element.getAttributeNS("","marked");
            }
            
            let en=element.getAttributeNS("","N");
            if (en==n)
            {                
                if(element.getAttributeNS("","marked")!=2)
                {
                    Element_Mark(element,{"marked": 2},style_marked);
                    n_changed++;

                }
            }
            else
            {
                if (element.getAttributeNS("","marked")!=1)
                {
                    Element_Mark(element,{"marked": 1},style_unmarked);
                    n_changed++;
                }
            } 
        }
        console.log(defs[k],n_changed,"changes");
    }
    
    
    res.push(defs.length);

    //let no=0;
    //for (let m=0;m<=Setup.Parameters.N;m++)
    //{
    //    //no+=Curves_Mark_Point(svg,m,n,clss);
//
        //console.log(clss,no);
    //}

    return res;
}

function Curves_Mark_Point(def,m,n,clss)
{
    let elements=def.getElementsByClassName(clss+"_"+m);

    let no=0;
    for (let k=0;k<elements.length;k++)
    {    
        if (m==n)
        {
            elements[k].style.display='inline';
            no+=1;
        }
        else
        {                
            elements[k].style.display='none';
        }
    }

    return no;
}


function Curves_Mark_Curves(n,svg_id,clss="Curve")
{
    let svg=document.getElementById(svg_id+"_defs");
    if (!svg)
    {
        console.log("No such SVG element",svg_id+"_defs");

        return;
    }
    
    let elements=svg.getElementsByClassName(clss+"_"+n);
    for (let k=0;k<elements.length;k++)
    {
        //elements[k].style.opacity='0.5';
    }
}


function Curve_Parameter_Component_Segment000(svg,p,comp,N)
{    
    let curves=Elements_By_Classes(clss,svg,"g");
    if (curves.length==0)
    {
        console.log("No curve elements",clss,svg);
    }
    
    let segment=false;

    for (let n=0;n<curves.length;n++)
    {        
        if (n<curves[n].children.length)
        {
            return curves[n].children[ N ];
        }
    }

    if (!segment)
    {
        console.log("No segment",p,comp,N,curves);
    }
    
    return segment;
}

//From SVG.js

    //
    // Add curve as svg lines.
    //

    SVG_Curve_R(svg,clss,pts,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }
        if (options[ "opacity" ])
        {
            g.style.opacity=options[ "opacity" ];
        }
        
        let comp;

        comp="Mesh";
        if (options[ comp ])
        {
            if (options[ "stroke" ])
            {
                //console.log(options[ "stroke" ]);
            }

            
            this.SVG_Mesh
            (
                g,
                [ clss,comp ],
                pts,
                options[ "point-size" ],
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        comp="Curve";
        if (options[ comp ])
        {
            this.SVG_Curve_Connections
            (
                g,
                [clss,comp],
                pts,
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        
        svg.append(g);
        
    }
    

    //
    // Add velocity function.
    //

    SVG_Curve_v(svg,clss,vs,options={})
    {       
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        if (options[ "Mesh" ])
        {
            this.SVG_Mesh
            (
                g,
                [clss,"Mesh"],
                vs,
                options[ "point-size" ],
                options[ "Mesh" ]
            );
        }
        
        if (options[ "Curve" ])
        {
            this.SVG_Curve_Connections
            (
                g,
                [clss,"Curve"],
                vs,options[ "Curve" ]
            );
        }

        svg.append(g);            
    }
    //
    // Add curve vectors, from rs gointo rs+vs.
    //

    SVG_Curve_Vectors(svg,clss,rs,vs,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        let comp;

        comp="Vectors";
        if (options[ comp ])
        {
            this.SVG_Curve_dR_Vectors
            (
                g,
                [clss,comp],
                rs,vs,
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        comp="Mesh";
        if (options[ comp ])
        {
            this.SVG_Mesh
            (
                g,
                [clss,comp],
                vs,
                options[ "point-size" ],
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        comp="Curve";
        if (options[ comp ])
        {
            this.SVG_Curve_Connections
            (
                g,
                [clss,comp],
                vs,
                this.SVG_Curve_Component_Options(options,comp)
            );
        }

        svg.append(g);  
    }

    //
    // Add curve vectors, from rs gointo rs+vs.
    //

    SVG_Curve_Vectors(svg,clss,rs,vs,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        let comp;

        comp="Vectors";
        if (options[ comp ])
        {
            this.SVG_Curve_dR_Vectors
            (
                g,
                [clss,comp],
                rs,vs,
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        comp="Mesh";
        if (options[ comp ])
        {
            this.SVG_Mesh
            (
                g,
                [clss,comp],
                vs,
                options[ "point-size" ],
                this.SVG_Curve_Component_Options(options,comp)
            );
        }
        
        comp="Curve";
        if (options[ comp ])
        {
            this.SVG_Curve_Connections
            (
                g,
                [clss,comp],
                vs,
                this.SVG_Curve_Component_Options(options,comp)
            );
        }

        svg.append(g);  
    }
    //
    // Add rolling circles
    //

    SVG_Curve_Rolling(svg,clss,r,rs,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        for (let n=0;n<rs.length;n++)
        {          
            if (Point_Is(rs[n]))
            {
                let classes=[clss];
                classes.push("N_"+n);

                this.SVG_Add_Circle
                (
                    g,rs[n],r,
                    Hashes_Merge
                    (
                        options[ "Circle" ],
                        {
                            "fill": 'none',
                            "style": "display: none;"
                        }
                    ),
                    classes
                );                
            }
        }

        svg.append(g); 
    }
    
    //
    // Add frenet system
    //

    SVG_Curve_Frenet(svg,clss,fr,ts,ns,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        let vi=Vector(  [ fr,[1,0] ]   );

        
        this.SVG_Add_Vector
        (
            g,fr,e_i(),
            options[ "Vectors" ],
            [clss],
            "i"
        );
        
        for (let n=0;n<ts.length;n++)
        {          
            if (Point_Is(ts[n]))
            {
                let classes=[clss];
                classes.push("Node","N_"+n);
                
                this.SVG_Add_Vector
                (
                    g,fr,
                    ts[n],
                    options[ "Vectors" ],
                    classes,
                    "t"
                );
                this.SVG_Add_Vector
                (
                    g,fr,
                    Vector_Hat(ts[n]),
                    options[ "Vectors" ],
                    classes,
                    "n"
                );
            }
        }

        svg.append(g); 
    }
     //
    // Add curve as svg lines.
    //

    SVG_Curve_dR_Vectors(svg,clss,rs,drs,options)
    {
        let g=this.SVG_Create('g',{ "class": clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        for (let n=0;n<rs.length;n++)
        {
            if (Points_Are(rs[n],drs[n]))
            {
                let classes=Array_Copy(clss);
                classes.push("Node");
                classes.push("N_"+n);
                
                let v=Vector(  [ rs[n],drs[n] ]   );
                
                this.SVG_Add_Vector
                (
                    g,
                    rs[n],
                    drs[n],
                    options,
                    classes
                );
            }
        }

        svg.append(g);        
    }
    
    //
    // Draw SVG mesh
    //

    SVG_Mesh(svg,clss,pts,size,options)
    {
        let g=this.SVG_Create('g',{ "class": clss,});

        //if (!options[ "stroke-width" ])
        //{
        //    options[ "stroke-width" ]="0.01";
        //}
        
        for (let n=0;n<pts.length;n++)
        {          
            if (Point_Is(pts[n]))
            {
                let classes=Array_Copy(clss);
                classes.push("Node");
                classes.push("N_"+n);
                
                this.SVG_Node(g,pts[n],n,size,options,classes);
            }
            else
            {
                console.log(clss,Point_Is(pts[n]),pts[n]);
            }
        }

        svg.append(g);
    }

 
   //
    // Add curve as svg lines.
    //

    SVG_Curve_Connections(svg,clss,pts,options)
    {
        let g=this.SVG_Create('g',{ "class": clss,});

        for (let n=1;n<pts.length;n++)
        {
            if (Points_Are(pts[n-1],pts[n]))
            {
                let classes=Array_Copy(clss);
                classes.push("Curve_"+n);
            
                this.SVG_Add_Line(g,pts[n-1],pts[n],options,classes);
            }
        }
        
        svg.append(g);
    }

    
    //
    // Add SVG line p1-p2 to this.svg.
    //
    
    SVG_Node(svg,p,n,size,options,classes)
    {
        let g=this.SVG_Create('g',{ "class": classes.join(" "),});
        g.setAttributeNS("","N",n);
        
        this.SVG_Add_Point(g,p,options,classes);

        this.SVG_Add_Text
        (
            g,p,n,
            Hashes_Merge
            (
                {
                    //"style": "display: none;",
                },
                options
            ),
            classes
        );

        svg.append(g);
    }
    
   
    //
    // Add SVG Vector arrow to svg.
    //
    
    SVG_Vector_FromTo(svg,p1,p2,options,classes,text=false)
    {
        if (!options[ "stroke-width" ])
        {
            options[ "stroke-width" ]="0.01";
        }
       
        this.SVG_Add_Line(svg,p1,p2,options,classes);
        let q=Vector([p1,p2]);
        this.SVG_Add_Vector_Arrow(svg,p1,q,options,classes);

        if (text)
        {
            let p=Vector_Convex(p1,p2,1.15);
            this.SVG_Add_Text(svg,p,text,options,classes);
        }
    }
