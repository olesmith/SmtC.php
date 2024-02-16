"use strict";

function Curve_Control_Animation_t_Row(setup)
{
    return [
        "$t$:",
        Curve_Control_Animation_t_Row_Span(setup),
    ];
}

function Curve_Control_Animation_t_Row_Span(setup)
{
    let span=Child_Create('span');
    span.id=Curve_Animation_CSS_ID("t");
    span.innerText=setup.Parameters.t1;
    
    
    return span
}

