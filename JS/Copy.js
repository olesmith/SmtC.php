"use strict";

function Copy_To(src_id,dest_id)
{
    
    let src=Get_Element_By_ID(src_id);
    let dest=Get_Element_By_ID(dest_id);
    console.log(dest_id,src_id);
    
    
    if (!src)
    {
        console.log("No such src element",src_id);

        return;
    }
    if (!dest)
    {
        console.log("No such destination element",dest_id);

        return;
    }

    dest.value=src.innerText;
}



function Copy_innerHtml(src_id,dest_id,create_tag='div')
{    
    let src=Get_Element_By_ID(src_id);
    let dest=Get_Element_By_ID(dest_id);
    
    if (!src)
    {
        console.log("No such src element",src_id);

        return;
    }
    if (!dest)
    {
        console.log("No such destination element",dest_id);

        return;
    }
    //src.style.display="initial";
    
    let contents=src.innerHTML;

    let li=document.createElement(create_tag);
    li.innerHTML=contents;
    //console.log("COPY",src);

    src.remove();
    dest.appendChild(li);
}
