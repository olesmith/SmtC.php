"use strict";


function Curve_Control_Parameters_Values(setup)
{
    return setup[ "Parameters" ][ "Values" ];
}
    
function Curve_Control_Parameters_Table(setup)
{
    let section="Parameters";
    let subsection="Properties";

    let properties=setup[ section ][ subsection ];

    let trs=[];
    trs.push([Curve_Control_Table_Title(setup[ section ][ "Title" ])]);
    
    for (let key in properties)
    {
        let property=properties[ key ];

        let tr=[];

        tr.push(property[ "Name" ]+":");
        tr.push(property[ "Symbol" ]);
        tr.push(setup[ section ][ key ]);
        
        trs.push(tr);
    }

    let values=Curve_Control_Parameters_Values(setup);

    if (values)
    {
        let color=setup[ "Curve" ][ "R" ][ "stroke" ];
        let opacity=1.0;
        let dopacity=Curve_dOpacity(setup);
        
        let cell=Child_Create('div',"");
        for (let p=0;p<values.length;p++)
        {
            let clss="P_"+p;
            
            let sclss=clss+" Show";
            let hclss=clss+" Hide";
            
            let toggle=Html_Toggles
            (
                clss,
                "&nbsp;"+values[p]+"&nbsp;",
                "g",
                true,
                {
                    "Mark_Func": function()
                    {
                        Hide_Elements_By_Class(clss,"inline","g");
                    },
                    "UnMark_Func": function()
                    {
                        Show_Elements_By_Class(clss,"inline","g");
                    },
                }
            );

            toggle.style.opacity=opacity;

            toggle.addEventListener
            (
                'mouseover',
                function(event)
                {
                    SVGs_Mark(p,false);
                }
            );
            
    
            toggle.addEventListener
            (
                'mouseout',
                function(event)
                {
                    SVGs_Mark(p,true);
                }
            );
            
            opacity-=dopacity;
            cell.append(toggle);
        }
        
        trs.push([cell]);
    }
    
    return Html_Table(trs);
}
