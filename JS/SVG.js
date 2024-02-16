"use strict";

class MySVG extends MySVG_Curve 
{
    //*
    //* SVG constructor
    //*
    
    constructor(setup)
    {
        super();
        
        this.SVG_Min_Max(setup);
        
        this.SVG_Init(setup);
    }

    //*
    //* Initial creation of svg field.
    //*
    
    SVG_Init(setup)
    {
        this.svg=
            this.SVG_Create
            (
                'svg',
                {
                    "id":  setup.ID,
                    "width":  setup.width+"px",
                    "height": setup.height+"px",
                    "viewBox": this.SVG_ViewBox(setup),
                    "preserveAspectRatio": 'none',
                    "style":
                    {
                        "border": "1px solid black",
                        "background-color": setup.BG_Color,
                    },
                    "onclick": this.SVG_Onclick(setup),
                }
            );
        
        // let defs=this.SVG_Defs();

        //this.svg.append(defs);
        //this.SVG_Port_Draw(setup);
    }
    
    //*
    //* Detect Min e Max from setup. Clipping area.
    //*
    
    SVG_Min_Max(setup)
    {
        let min=setup.Min;
        let max=setup.Max;

        //Sane min/maxs: min<max.
        for (let i=0;i<2;i++)
        {
            if (min[i]>max[i])
            {
                let tmp=min[i];
                min[i]=max[i];
                max[i]=tmp;
            }
        }

        //Now correct for multiplying y-vales with -1
        let min_x=min[0];
        let max_x=max[0];
        
        let min_y=-max[1];
        let max_y=-min[1];

        this.Min=[min_y,min_y];
        this.Max=[max_x,max_y];
        this.Box=Vector([this.Max,-1,this.Min]);
        
        this.Size=Vector_Length(this.Box);

        this.Margin_Scale=1.1;
        if (setup[ "Margin_Scale" ])
        {
            this.Margin_Scale=setup[ "Margin_Scale" ];
        }

        //console.log(this.Margin_Scale);
        
        this.Point_Size=0.0025*this.Size;
        if (setup[ "Point_Size" ])
        {
            this.Point_Size=setup[ "Point_Size" ];
        }

        //console.log("Point_Size",this.Point_Size);
        this.Text_Scale=0.001*this.Size;
    }
    
    
    SVG_Port(setup)
    {
        let t=1-this.Margin_Scale;
        let plow=Vector_Convex(this.Min,this.Max,t);
        
        let tt=1-t;
        let phigh=Vector_Convex(this.Min,this.Max,tt);

        let v=Vector([phigh,-1,plow]);
        
        let port=
        {
            "x": plow[0],
            "y": plow[1],
          
            "dx": v[0],
            "dy": v[1],
        };
        return port;
    }
    
    SVG_ViewBox(setup)
    {
        let port=this.SVG_Port(setup);
        return port.x+" "+port.y+" "+port.dx+" "+port.dy;
    }

    
    //*
    //* Draw viewbox rectangle - for testing.
    //*
    
    SVG_Port_Draw(setup)
    {
        let port=this.SVG_Port(setup);

        let p1=[port.x,port.y];
        let p2=[port.x+port.dx,port.y+port.dy];
        
        this.SVG_Add_Point(this.svg,p1,{"stroke": 'red'});
        this.SVG_Add_Point(this.svg,p2,{"stroke": 'red'});
    }
    

    //
    // Defs: Vector
    //

    SVG_Defs()
    {
        let defs=this.SVG_Create('defs');

        let options=
            {
                //"stroke": "yellow",
                //"stroke-width": 0.02,
            };
        
        let O=[0,0];
        let i=[1,0];

        let eps=0.05;
        let p1=[1-eps,eps];
        let p2=[1-eps,-eps];
        
        let g=this.SVG_Create
        (
            'g',
            {
                "id": "VVV",
            }
        );
        
        //let line=this.SVG_Draw_Line(O,i,options);
        let line=this.SVG_Draw_Polyline([O,i,p1,p2,i],options);
        g.append(line);

        defs.append(g);

        return defs;
    }
    
    //
    // Join component options
    //

    SVG_Curve_Component_Options(options,comp)
    {
        let roptions=Hash(options[ comp ]);

        let keys=["stroke","stroke-width"];
        for (let n=0;n<keys.length;n++)
        {
            if (options[ keys[n] ] && !roptions[ keys[n] ])
            {
                roptions[ keys[n] ]=options[ keys[n] ];
            }
        }

        return roptions;
    }
    
    

    //
    // Add osculating circles
    //

    SVG_Curve_Osculating(svg,clss,cs,rhos,options={})
    {
        let g=this.SVG_Create('g',{ "class": "Comp "+clss,});
        if (options[ "Hide" ])
        {
            g.style.display='none';
        }

        let roptions=this.SVG_Curve_Component_Options(options,"Circle");
        
        for (let n=0;n<cs.length;n++)
        {          
            if (Point_Is(cs[n]) && rhos[n])
            {
                let classes=[clss];
                classes.push("N_"+n);

                this.SVG_Add_Circle
                (
                    g,
                    cs[n],//center
                    Math.abs(rhos[n][1]), //radius
                    Hashes_Merge
                    (
                        roptions,
                        {
                            "fill": 'none',
                            //"style": "display: none;"
                        }
                    ),
                    classes
                );                
            }
        }

        svg.append(g); 
    }

    
    //*
    //* Onclick js call
    //*
    
    SVG_Onclick(setup)
    {
        //return "window.animate=!window.animate;";
        return "Curve_Control_Animation_Button_Click();";
    }
}


//*
//* Creates SVG rotate treansformation.
//*


function SVG_Transform_Rotate(p,angle)
{
    return "rotate("+angle+")"; //,"+p[0]+","+p[1]+")";
}
