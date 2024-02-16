"use strict";


function Curve_Control_Animation_Delay_Row(setup)
{
    return [
        "Delay:",
        Curve_Control_Animation_Delay_Row_Input(setup)
    ];
}


function Curve_Control_Animation_Delay_Row_Input(setup)
{
    let input=Child_Create('input');
    input.id="Input_Delay";
    input.name="Delay";
    input.size="3";
    input.value=setup.Animation[ "Delay" ];

    input.addEventListener
    (
        'change',
        function(event)
        {
            Curve_Animation_Delay_Set(event.srcElement.value);
        }
    );
    
    
    
    return input;
}
