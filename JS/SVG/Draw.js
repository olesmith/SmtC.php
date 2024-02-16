"use strict";


class MySVG_Draw extends MySVG_Attributes
{
    //
    // Generate circle tag
    //
    
    SVG_Draw_Circle(c,r,options={},classes=[])
    {
        let elm=false;
        if (!isNaN(r))
        {
            elm=
                this.SVG_Create
                (
                    'circle',
                    Hashes_Merge
                    (
                        options, 
                        {
                            "cx": c[0],
                            "cy": -c[1],

                            "r": r,
                            "class": classes,
                        }
                    )
                    
                );
        }
        else
        {
            //console.log("NAN",r,options,classes);
        }

        return elm;
    }
    
    //
    // Generate text tag
    //
    
    SVG_Draw_Text(p,text,options={},classes=[],scale=0.0125)
    {
        let y=-p[1];
        return this.SVG_Create
        (
            'text',
            Hashes_Merge
            (
                options,
                {
                    "x": p[0],
                    "y": y,
                    "transform": "translate("+p[0]+","+y+") scale("+scale+")",
                    "class": classes,
                    "stroke-width": 0.02,
                }
            ),
            text
        );
    }
    
    //
    // Generate line tag
    //
    
    SVG_Draw_Line(p1,p2,options={},classes=[])
    {
        return this.SVG_Create
        (
            'line',
            Hashes_Merge
            (
                options,
                {
                    "x1": p1[0],
                    "y1": -p1[1],
                    "x2": p2[0],
                    "y2": -p2[1],
                    //"fill": "none",
                    "class": classes,
                }
            )
        );
    }
    
    //
    // Generate polyline tag
    //

    SVG_Draw_Polyline(pts,options={},classes=[])
    {
        let texts=[];
        for (let n=0;n<pts.length;n++)
        {
            let x=pts[n][0];
            let y=-pts[n][1];
            
            texts.push(x+","+y);
        }
        
        let pline=this.SVG_Create
        (
            'polyline',
            Hashes_Merge
            (
                {
                    "points": texts.join(" "),
                },
                options
            )
        );
        
        return pline;
    }
        
        
    //
    // Generate node with text (two tags, circle text)
    //
    
    SVG_Draw_Image(p,url,h,w,options)
    {
        return this.SVG_Create
        (
            'image',
            Hashes_Merge
            (
                options,
                {
                    "x": p[0],
                    "y": -p[1],
                    "height": h,
                    "width": w,
                    "href": url,
                }
            )
        );
    }
    
    //
    // Generate node with text (two tags, circle text)
    //
    
    SVG_Draw_Node(p,n,size,options,classes=[])
    {
        let g=this.SVG_Create('g',{ "class": classes.join(" "),});
        g.setAttributeNS("","N",n);
        
        this.SVG_Add_Point(g,p,options,classes);

        if (n)
        {
            this.SVG_Add_Text
            (
                g,
                p,
                n,
                options,
                classes
            );
        }

        return g;
    }
    

    //
    // Generate pont as circle tag
    //
    
    SVG_Draw_Point(p,options={},classes=[])
    {
        return this.SVG_Draw_Circle
        (
            p,this.Point_Size,options,classes
        );
    }
    
    //
    // return elements with segment,arrow and text
    //

    SVG_Draw_Vector(p,v,options={},classes=[],text=false)
    {
        let angle=-Vector_Angle(v,true);
        let len=Vector_Length(v);
        
        //q=p+v
        let q=Vector([p,v]);
        
        let g=this.SVG_Create("g",{"class": classes});

        let x=p[0];
        let xx=-p[0];
        let y=p[1];
        let yy=-p[1];

       
        
        this.SVG_Add_Line(g,p,q,options,classes);
        this.SVG_Add_Vector_Arrow(g,q,v,options,classes);

        if (text)
        {
            let pt=Vector_Convex(p,v,1.1);
            this.SVG_Add_Text(g,pt,text,options,classes);
        }

        //console.log(text);

        return g;
    }

    
    //
    // return elements with segment,arrow and text
    //

    SVG_Draw_Vector_Arrow(p,v,options,classes)
    {
        let vscale=0.05;
        let nscale=0.5*vscale;

        let n=Vector_Hat(v);

        v=Vector_Unit(v,vscale);
        n=Vector_Unit(n,nscale);

        //let q=Vector([p,v]);
        return this.SVG_Draw_Polyline
        (
            [
                p,
                Vector([ 1.0,p, -1.0,v,  1.0,n ]),
                Vector([ 1.0,p, -1.0,v, -1.0,n]),
                p
            ],
            Hashes_Merge
            (
                options,
                {
                    "class": classes,
                }
            )
        );
    }
}
