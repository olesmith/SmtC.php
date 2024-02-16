"use strict";


class MySVG_WCS extends MySVG_Add
{
    //
    // Draw WCS.
    //


    SVG_WCS(svg,setup)
    {
        let p1=setup.Min;
        let p2=setup.Max;
        
        let options=Hashes_Merge
        (
            {
                "stroke": "blue",
                "stroke-width": 0.02,
            },
            setup.WCS[ "Options" ]
        );

        let g=this.SVG_Create('g',options);
        
        let pleft=[p1[0],0];
        let pright=[p2[0],0];
        
        let roptions=
            {
                "stroke": options[ "stroke" ]
            };

        let xaxis=this.SVG_WCS_X(pleft,pright,roptions);
        
        let pbottom=[0,p1[1]];
        let ptop=[0,p2[1]];
        
        let yaxis=this.SVG_WCS_Y(pbottom,ptop,roptions);

        g.append(xaxis);
        g.append(yaxis);
        
        svg.append(g);
    }
    
    //
    // Draw X-axis.
    //


    SVG_WCS_X(pleft,pright,options)
    {
        let text="x";
        if (options[ "X" ])
        {
            text=options[ "X" ];
        }

        return this.SVG_Draw_Vector
        (
            pleft,
            Vector([pright,-1,pleft]),
            options,
            ["X"],
            text
        );
    }
    
    //
    // Draw Y-axis.
    //


    SVG_WCS_Y(pbottom,ptop,options)
    {
        let text="y";
        if (options[ "Y" ])
        {
            text=options[ "Y" ];
        }
        
        return this.SVG_Draw_Vector 
        (
            pbottom,
            Vector([ptop,-1,pbottom]),
            options,
            ["Y"],
            text
        );
    }
    
}
