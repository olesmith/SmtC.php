"use strict";


class MySVG_Add extends MySVG_Draw
{
    //
    // 
    //

    SVG_Add_Circle(svg,c,r,options={},classes=[])
    {
        if (!isNaN(r))
        {
            svg.append
            (
                this.SVG_Draw_Circle(c,r,options,classes)
            );
        }
    }
    
    //
    // 
    //

    SVG_Add_Text(svg,p,text,options={},classes=[],text_scale=false)
    {
        let roptions=Hash(options);
        
        let rclasses=Array_Copy(classes);
        rclasses.push("Text");

        if (options.stroke && !options.fill)
        {
            roptions.fill=options.stroke;
        }

        if (!text_scale)
        {
            
            text_scale=this.Text_Scale;
        }
        //console.log(text_scale);
        
        svg.append
        (
            this.SVG_Draw_Text
            (
                p,text,roptions,rclasses,text_scale
            )
        );
    }
    
    //
    // 
    //

    SVG_Add_Line(svg,p1,p2,options={},classes=[])
    {
        svg.append
        (
            this.SVG_Draw_Line(p1,p2,options,classes)
        );
    }
    
    // 
    // 
    //

    SVG_Add_Polyline(svg,pts,options={},classes=[])
    {
        svg.append
        (
            this.SVG_Draw_Polyline(pts,options,classes)
        );
    }
    
    //
    // Add image.
    //
    
    SVG_Add_Image(svg,p,url,h,w,options)
    {
        svg.append
        (
            this.SVG_Draw_Image(p,url,h,w,options)
        );
    }
    
    //
    // Add node with text (g tag, with two child tags, circle text)
    //
    
    SVG_Add_Node(svg,p,n,size,options={},classes=[])
    {
        svg.append
        (
            this.SVG_Draw_Node(p,n,size,options,classes)
        );
    }
    
    //
    // 
    //
    
    SVG_Add_Point(svg,p,options={},classes=[])
    {
        let roptions=Hash(options);
        
        if (!roptions[ "stroke-width" ])
        {
            roptions[ "stroke-width" ]="0.01";
        }
        if (!roptions[ "fill" ] && options[ "stroke" ])
        {
            roptions[ "fill" ]=options[ "stroke" ];
        }
        
        let rclasses=Array_Copy(classes);
        rclasses.push("Point");
        
        svg.append
        (
            this.SVG_Draw_Point(p,roptions,classes)
        );
    }
    
    //
    // add g element with segment,arrow and text
    //

    SVG_Add_Vector(svg,p,v,options={},classes=[],text=false)
    {
        svg.append
        (
            this.SVG_Draw_Vector(p,v,options,classes,text)
        );
    }
    
    //
    // add polyline element: the arrow
    //

    SVG_Add_Vector_Arrow(svg,p,v,options={},classes)
    {
        svg.append
        (
            this.SVG_Draw_Vector_Arrow(p,v,options,classes)
        );
    }
}
