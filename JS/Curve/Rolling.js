"use strict";

//*
//* Draws initial rolling circle.
//*

function Curve_Rolling_Initial_Add(svg,g,setup,curve,p)
{
    let gc=svg.SVG_Create('g',{"class": "Node Rolling"});
    svg.SVG_Add_Circle
    (
        gc,
        curve[ "Rolling" ][0],
        Setup.Parameters.r,
        {
            "stroke": "red",
            "fill": 'none',
            //"style": 'opacity: 0.25;',
        }
    );

    svg.SVG_Add_Point
    (
        gc,
        curve[ "Rolling" ][0],
        {
            "stroke": "red",
            "fill": 'red',
            //"style": 'opacity: 0.25;',
        }
    );

    let pp=curve[ "R" ][0];
    let x=pp[0];
    let y=-pp[1];

    if (p==0)
    {
        let size=0.5;
        let dsize=-0.3;

	    let transforms=[
	        SVG_Transform_Rotate
	        (
		        curve[ "R" ][0],
		        Vector_Angle_SVG(curve[ "dR" ][0])
	        ),
	        "translate("+dsize+","+dsize+")",
	    ];

        svg.SVG_Add_Image
        (
            gc,
            pp,
            "/images/poop.png",
            size,size,
            {
                "transform": transforms.join(" "),
            }
        );
    }

    g.append(gc);
}



//*
//* Moves rolling circle to rolling center.
//*


function Curve_Rolling_Animate(g,p,comp,N)
{
    //Rolling circle G element
    let base_g=Curve_Animated_Point_Element
    (
        g,p,"Rolling",N
    );

    if (base_g)
    {
	//Retrieve coordinates of curve point, derivative and  rolling center
        let r=Curve_Animated_Point(g,p,"R",N+1);
        let dr=Curve_Animated_Point(g,p,"dR",N+1);
        let c=Curve_Animated_Point(g,p,"Rolling",N+1);
        
        let c_elements=Element_Children(base_g,"circle");

        //console.log("Rolling circles",c,c_elements);
        for (let n=0;n<c_elements.length;n++)
        {
            c_elements[n].setAttributeNS("","cx",c[0]);
            c_elements[n].setAttributeNS("","cy",c[1]);
        }
        
        let c_images=Element_Children(base_g,"image");

        let angle=90.0-180.0/Math.PI*Math.atan2(dr[0],dr[1])
 
        for (let n=0;n<c_images.length;n++)
        {            
            c_images[n].setAttributeNS("","x",r[0]);
            c_images[n].setAttributeNS("","y",r[1]);

            let transform=c_images[n].getAttributeNS("","transform");

	        //Rotate should be first (improve)
            transform=transform.split(" ");
            transform[0]="rotate("+angle+","+r[0]+","+r[1]+")";

            c_images[n].setAttributeNS("","transform",transform.join(" "));
        }
    }
    else
    {
        console.log("Rolling base G not found");
    }
}
