"use strict";




function Mark_Form_On_Input_Change()
{
    let input=event.srcElement;
    if (input)
    {
        let form=input.form;
        let form_id=form.id;
        let frame_id=form_id+"_Frame";
        
        let frame=Get_Element_By_ID(frame_id);
        if (frame)
        {
            frame.style.borderWidth = "1px";
            frame.style.borderColor = "red";
            frame.style.borderStyle = "solid";
        }

        let buttons=form.querySelectorAll("button");
        for (let n=0;n<buttons.length;n++)
        {
            buttons[n].style.opacity='1.0';
        }
    }
}


function Mark_Form_On_Input_Reset()
{
    let input=event.srcElement;
    if (input)
    {
        let form=input.form;
        let form_id=form.id;
        let frame_id=form_id+"_Frame";
        
        let frame=Get_Element_By_ID(frame_id);
        if (frame)
        {
            frame.style.borderWidth = "initial";
            frame.style.borderColor = "initial";
            frame.style.borderStyle = "initial";
        }

        let buttons=form.querySelectorAll("button");
        for (let n=0;n<buttons.length;n++)
        {
            buttons[n].style.opacity='initial';
        }
    }
}
