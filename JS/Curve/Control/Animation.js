"use strict";


function Curve_Control_Animation_Table(setup)
{        
    return Html_Table
    (
        Curve_Control_Animation_Rows(setup)
    );
}

function Curve_Control_Animation_Rows(setup)
{        
    return [
        [Curve_Control_Table_Title("Animation")],
        
        Curve_Control_Animation_Delay_Row(setup),
        Curve_Control_Animation_N_Row(setup),
        Curve_Control_Animation_t_Row(setup),
        Curve_Control_Animation_Button_Row(setup)
    ];
}
