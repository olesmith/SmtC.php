"use strict";

function CheckBox_Group_Toggle_All(classes,display='initial')
{
    Register_Time("CheckBox_Group_Toggle_All");
    let elements=document.getElementsByClassName(classes);
    for (let n=0;n<elements.length;n++)
    {
        if (!elements[n].disabled)
        {
            elements[n].checked=!elements[n].checked;
        }
    }   
}

function CheckBox_Group_Set_All(check_id,classes,display='initial')
{
    Register_Time("CheckBox_Group_Set_All");
                
    let check_element  = Get_Element_By_ID(check_id);

    if (!check_element)
    {
        console.log("CheckBox_Group_Set_All:",check_id,"not found");
        return false;
    }
    
    //check_element.checked=true;
    
    let check=false;
    if (check_element.checked)
    {
        check=true;
    }

    let elements=document.getElementsByClassName(classes);

    for (let n=0;n<elements.length;n++)
    {
        if (!elements[n].disabled)
        {
            elements[n].checked=check;
            Show_Element(elements[n],display);
        }
    }
}
