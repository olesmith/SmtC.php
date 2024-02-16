"use strict";

function Curve_Control_Animation_N_Row(setup)
{
    return [
        "n:",
        Curve_Control_Animation_N_Row_Input(setup),
        Curve_Control_Animation_N_Row_Span(setup),
    ];
}

function Curve_Control_Animation_N_Row_Span(setup)
{
    let span=Child_Create('span',{
        "id": Curve_Animation_CSS_ID("N"),
    });
    span.id=Curve_Animation_CSS_ID("N");
    span.innerText="0";
    
    return span
}

function Curve_Control_Animation_N_Row_Input(setup)
{
    let input=Child_Create('input');

    input.name="N";
    input.size="3";
    input.value=window.anim_n;

    input.addEventListener
    (
        'change',
        function(event)
        {
            window.anim_n=event.srcElement.value;
            window.isanimating=false;
            
            //console.log(anim_n);
            Curve_Animation_Anim_N_To_Span();
        }
    );
    
        
    return input;
}
