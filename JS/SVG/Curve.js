"use strict";


class MySVG_Curve extends MySVG_Mesh
{   
    //
    // Create and return curve as svg lines tag.
    //

    SVG_Curve_Draw(clss,pts,options,text="")
    {
        let roptions=Hash(options);
        roptions[ "fill" ]=roptions[ "stroke" ];

        clss.push(clss);
        
        roptions[ 'class' ]=clss;

        let g=this.SVG_Create('g',roptions);
        
        let point_size=this.Point_Size;
        
        let dp=[-3*point_size,-2*point_size];

        if (pts)
        {
            let point=pts[0];


            //console.log(point,Point_Is(point));
            
            if (Point_Is(point))
            {
                let text_point=Vector([point,dp]);
                
                this.SVG_Add_Text
                (
                    g,
                    text_point,
                    text,
                    {
                    },
                    []
                );
            }

            for (let n=1;n<pts.length;n++)
            {
                if (Points_Are(pts[n-1],pts[n]))
                {
                    this.SVG_Add_Line
                    (
                        g,
                        pts[n-1],pts[n],
                        {"N": n,},
                        "N_"+n
                    );
                }
            }
        }

 
        return g;
    }

    //
    // Add curve as svg lines.
    //

    SVG_Curve_Add(svg,clss,pts,options,text="")
    {
        svg.append
        (
            this.SVG_Curve_Draw(clss,pts,options,text)
        );        
    }

}
