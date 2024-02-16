"use strict";



function Form_Create_From(form_element,new_form_info,input_ids)
{    
    let prev_form=Get_Element_By_ID(new_form_info[ "Form_ID" ]);
    if (prev_form)
    {
        //Remove old form
        document.body.removeChild(prev_form);
    }
    
    let uri=form_element.action;
    let url=uri.replace(/\?\S*/,"");
    let gets=uri.replace(/\S+\?/,"?");

    let hash=String2Hash(gets);

    hash[ "Dest" ]=new_form_info[ "Dest_ID" ];
    hash[ "No_Reload" ]=1;

    let dest_element=Get_Element_By_ID(new_form_info[ "Dest_ID" ]);
    dest_element.style.display='block';
    
 
    let form=document.createElement('form');
    
    for (let n=0;n<new_form_info[ "Buttons" ].length;n++)
    {
        new_form_info[ "Buttons" ][n].style.opacity=0.5;
    }

    form.method=form_element.method;
    
    form.action=url+"?"+Hash2String(hash);
    form.setAttribute("id",new_form_info[ "Form_ID" ]);

    for (let input_id in input_ids)
    {
        let input=Get_Element_By_ID(input_id);

        let new_input=document.createElement('input');
        
        new_input.name=input.name;
        new_input.value=input.value;
        new_input.setAttribute("type", input.getAttribute("type"));
        
        form.append(input);
    }

    document.body.append(form);

    console.log("send Form",hash);
    
    //Send the created form
    Update_URL_2_Element
    (
        "?"+Hash2String(hash),
        new_form_info[ "Dest_ID" ],
        new_form_info[ "Form_ID" ]
    );

    return form;
}
