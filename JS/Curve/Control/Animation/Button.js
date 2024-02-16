"use strict";


function Curve_Control_Animation_Button_Row(setup)
{
    return [
        "Animation:",
        Curve_Control_Animation_Button_Row_Input(setup)
    ];
}

function Curve_Control_Animation_Button_Row_Input(setup)
{
    return Html_Toggles
    (
        "Animation_Start",
        "","span",false,
        {
            "id": Curve_Animation_CSS_ID("Button"),
            "Mark_Func": function()
            {
                window.animate=true;
            },
            "UnMark_Func": function()
            {
                window.animate=false;
            },
            "Mark_Text": "Start",
            "UnMark_Text": "Stop",
        }
    );
}

//*
//* Find Start/Stop button and click visual child (span).

function Curve_Control_Animation_Button_Click()
{
    let span=Element_By_ID
    (
        Curve_Animation_CSS_ID("Button")
    );

    if (span)
    {
        let element=false;
        for (let child of span.children)
        {
            if (!child.style.display || child.style.display!="none")
            {
                element=child;
            }
        }

        if (element)
        {
            element.click();
        }
        else
        {
            console.log("Child SPAN not found");
        }
    }
    else
    {
        console.log("No SPAN",Curve_Animation_CSS_ID("Button"));
    }
}
