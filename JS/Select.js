"use strict";


var __Updateds__={};

function Select_Update_Register(element,stat_icon_id="",stat_color='red',stat_icon='fas fa-hand-spock')
{
    let element_name=element.name;
    
    let form_element=element.closest("form");
    if (form_element)
    {
        let buttons=form_element.getElementsByTagName("button");
        for (let n=0;n<buttons.length;n++)
        {
            buttons[n].style.opacity=1;
        }
    }

    
    //element.value=value;
    if (!element.hasAttribute("oldValue"))
    {
        element.setAttribute("oldValue",element.value);
    }

    //Add to vars to update
    __Updateds__[ element_name ]=element.value;

    if (stat_icon_id)
    {
        let stat=Get_Element_By_ID(stat_icon_id);

        if (!stat)
        {
            console.log("No stat filed",stat_icon_id);

            return;
        }

        if (stat.children.length==0)
        {
            
            console.log("No children in",stat_icon_id);

            return;
        }
        
        let icon=stat.children[0];

        if (element.value==0)
        {
            stat_icon="fas fa-exclamation";
            stat_color="red";
        }

        //console.log(stat_icon_id,"Icon",stat_icon,"Color",stat_color);
        icon.className=stat_icon+" fa-lg nowrap";
        icon.style.color=stat_color;
    }
    else
    {
        console.log("Stat icon",stat_icon,"not found");
    }
}


function Select_Updated_Elements_Send(element,update_to_id)
{
    console.log("Send");
    //console.clear();
    if (!__Updateds__) { return; }
    
    //console.log("Select_Updated_Elements_Send");
    let form_element=element.closest("form");
    
    console.log(form_element);
    if (!form_element)
    {
        console.log("Unable to get closest form element");
        return;
    }


    let new_form_info=
        {
            "Form_ID": "Tmp_"+update_to_id,
            "Dest_ID": update_to_id,
            "Buttons": form_element.getElementsByTagName("button"),
        };

    
    let form_new=
        Form_Create_From(form_element,new_form_info,__Updateds__);
   
    for (let relement_id in __Updateds__)
    {
        let relement=Get_Element_By_ID(relement_id);

        let stat_icon_id=
            relement.name.replace(/^Rooms_/,"Stats_");

        let stat=Get_Element_By_ID(stat_icon_id);
        let icon=stat.children[0];
        icon.style.color="grey";
    }

    //Reset updated fields
    __Updateds__={};
    
    //document.body.removeChild(form);
}


//Copy select element value to element_ids.

function Select_Copy_To_Elements(element,element_ids)
{
    console.clear();
    let value=element.value;
    for (let n=0;n<element_ids.length;n++)
    {
        let updated=Select_Copy_To_Element(element,element_ids[n]);
    }

    //for (let relement_id in __Updateds__)
    //{
    //    let relement=Get_Element_By_ID(relement_id);

    //    let oldvalue=relement.getAttribute("oldValue");
    //}
}

function Select_Copy_To_Element(element,element_id,force=true)
{
    let value=element.value;
    
    let relement=Get_Element_By_ID(element_id);
    if (!relement)
    {
        //console.log("No such destination element",element_id);
        return;
    }
    
    let rvalue=relement.value;

    let updated=false;

    
    if (force || rvalue==0)
    {
        let options=relement.options;

        let update=false;
        if (value!=rvalue)
        {
            update=true;     
        }

        if (update)
        {
            let found=false;
            let option_m=-1;
            let option_s=-1;
            
            for (let m=1;m<options.length;m++)
            {
                if (options[m].value==value)
                {
                    found=true;

                    option_m=m;
                }

                if (options[m].selected)
                {
                    option_s=m;
                }
            }

            if (option_m>=0)
            {
                if (options[option_m].disabled)
                {
                    update=false;
                }
                else
                {
                    update=true;
                    for (let m=0;m<options.length;m++)
                    {
                        if (m==option_m)
                        {
                            options[m].selected=true;
                        }
                        else
                        {
                            options[ m ].selected=false;
                        }
                    }
                }
            }

            if (update && found)
            {
                updated=true;

                let stat_icon_id=
                    relement.name.replace(/^Rooms_/,"Stats_");

                console.log(stat_icon_id);
                
                let stat_color='orange';
                let stat_icon="fas fa-check";
                
                Select_Update_Register
                (
                    relement,
                    stat_icon_id,
                    stat_color,
                    stat_icon
                );
                
                
            }
            else
            {
                //console.log("Select_Copy_To_Element: Not valid option",value);
            }
        }
    }

    return updated;
}


function Selects_Union_Select(new_id,dest_id,select_ids,name="entries")
{
    let dest=Get_Element_By_ID(dest_id);
    if (!dest)
    {
        console.log("No such destination element id:",dest_id,"cancelled");

        return;
    }
    
    let options=Selects_Union_Options(select_ids);

    Select_Field_Create(new_id,dest,options,select_ids,name);
}

function Selects_Intersection_Select(new_id,dest_id,select_ids,name="entries")
{
    let dest=Get_Element_By_ID(dest_id);
    if (!dest)
    {
        console.log("No such destination element id:",dest_id,"cancelled");

        return;
    }
    
    let options=Selects_Intersection_Options(select_ids);

    Select_Field_Create(new_id,dest,options,select_ids,name);
}


function Select_Field_Create(new_id,dest,options,select_ids,name)
{
    let new_select=document.createElement('select');
    new_select.id=new_id;
    
    new_select.onchange=
        function() {
            Select_Copy_To_Elements(this,select_ids)
        };
    
    for (let n=0;n<select_ids.length;n++)
    {
        let select=Get_Element_By_ID(select_ids[n]);
        
        new_select.className=select.className;
        //new_select.style.maxWidth=select.style.maxWidth;
        new_select.style.maxWidth='100px';

        break;
    }

    let n=0;
    for (let value in options)
    {
        let text=options[ value ];
        let new_option=document.createElement('option');
        new_option.text=text;
        new_option.value=value;

        new_select.append(new_option);

        if (value>0) { n++; }
    }
    
    new_select.title=n+" "+name;
    
    dest.append(new_select);
}


function Selects_Union_Options(select_ids)
{
    let options={};
    let noptions={};
    for (let n=0;n<select_ids.length;n++)
    {
        let select=Get_Element_By_ID(select_ids[n]);

        if (select)
        {
            for (let m=0;m<select.options.length;m++)
            {
                let option=select.options[m];

                if (!option.disabled)
                {
                    let value=option.value;
                    let text=option.text;
                    
                    //console.log(select_ids[n],value,text);

                    options[ value ]=text;

                    if (noptions[ value ]==undefined)
                    {
                        noptions[ value ]=1;
                    }
                    else
                    {
                        noptions[ value ]++;
                    }

                    if (value>0)
                    {
                        options[ value ]=text+" - "+noptions[ value ];
                    }
                }
            }
        }
    }

    return options;
}

function Selects_Intersection_Options(select_ids)
{
    let options={};
    let noptions={};

    
    for (let n=0;n<select_ids.length;n++)
    {
        let select=Get_Element_By_ID(select_ids[n]);

        if (select)
        {
            for (let m=0;m<select.options.length;m++)
            {
                let option=select.options[m];

                if (!option.disabled)
                {
                    let value=option.value;
                    let text=option.text;
                    
                    //console.log(select_ids[n],value,text);

                    options[ value ]=text;

                    if (noptions[ value ]==undefined)
                    {
                        noptions[ value ]=1;
                    }
                    else
                    {
                        noptions[ value ]++;
                    }

                    if (value>0)
                    {
                        options[ value ]=text+" - "+noptions[ value ];
                    }
                }
            }
        }
    }

    let roptions={};
    for (let value in noptions)
    {
        if (noptions[ value ]==select_ids.length)
        {
            roptions[ value ]=options[ value ];
        }
    }

    return roptions;
}





function Select_Updated_Elements_Send_OLD(element,update_to_id)
{
    //console.clear();
    if (!__Updateds__) { return; }
    
    //console.log("Select_Updated_Elements_Send");

    let form_element=element.closest("form");
    
    if (!form_element)
    {
        console.log("Unable to get closest form element");
        return;
    }

    
    let uri=form_element.action;
    
    if (form_element)
    {
        let buttons=form_element.getElementsByTagName("button");
        for (let n=0;n<buttons.length;n++)
        {
            buttons[n].style.opacity=0.5;
        }
    }
    
    let update_to_element=Get_Element_By_ID(update_to_id);
    update_to_element.style.display='block';
    
    let form_id="Tmp_".update_to_id;
    let url=uri.replace(/\?\S*/,"");
    let gets=uri.replace(/\S+\?/,"?");
    
    //let ul=document.createElement('ul');
    
    let hash=String2Hash(gets);

    hash[ "Dest" ]=update_to_id;
    hash[ "No_Reload" ]=1;

    let old_form=Get_Element_By_ID(form_id);
    if (old_form)
    {
        //Remove old form
        document.body.removeChild(old_form);
    }

    let form=document.createElement('form');
    
    form.method=form_element.method;
    form.action=url+"?"+Hash2String(hash);

    //console.log("from action",form.action);
    form.setAttribute("id",form_id);
    
    for (let relement_id in __Updateds__)
    {
        let relement=Get_Element_By_ID(relement_id);

        let input=document.createElement('input');
        input.name=relement.name;
        input.value=relement.value;
        input.setAttribute("type", "text");
        
        let stat_icon_id=
            relement.name.replace(/^Rooms_/,"Stats_");

        let stat=Get_Element_By_ID(stat_icon_id);
        let icon=stat.children[0];
        icon.style.color="grey";

        
        //let oldvalue=relement.getAttribute("oldValue");
        form.append(input);
    }

    let input=document.createElement('input');
    input.name="Distribute";
    input.setAttribute("type", "hidden");
    input.value=1;

    //update_to_element.append(ul);
    form.append(input);

    document.body.append(form);

    Update_URL_2_Element
    (
        "?"+Hash2String(hash),
        update_to_id,
        form_id
    );

    //Reset updated fields
    __Updateds__={};
    
    //document.body.removeChild(form);
}

function Select_Reload(select,url)
{
    url=Url2Hash(url)

    let name=select.name;
    let value=select.value;

    url[ name ]=value;
    //let cell_id=url[ "Dest" ];

    delete url.Dest;
    delete url.RAW;
    delete url.NoHorMenu;
    
    url=Hash2Get(url);

    
    console.log(url);
    Load_URL_2_Window(url);
    //Load_URL_2_Element_Do(cell_id,url);
    

    
}
