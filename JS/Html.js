"use strict";



//* 
//* Create HTML table for DOM insert.
//* 

function Html_Table(matrix,options={},style={})
{
    options=Hashes_Merge
    (
        {
            "class": 'table',
            "align": 'center',
        },
        options
    );
    
    let table=Child_Create('table',"",options,style);    

    let ncols=0;
    for (let m=0;m<matrix.length;m++)
    {
        if (ncols<matrix[m].length) { ncols=matrix[m].length; }
    }
    
    for (let m=0;m<matrix.length;m++)
    {
        let tr=Children_Create("tr","td",matrix[m]);

        let nrows=tr.childElementCount;

        //Set colspan on last row, if necessary.
        if (nrows<ncols)
        {
            let td=tr.children[ nrows-1];
            if (td)
            {
                td.colSpan=(ncols-nrows+1);
            }
            else
            {
                console.log(td);
            }
        }
        
        table.append(tr);
    }

    return table;
}

//* 
//* Create HTML table for DOM insert.
//* 

function Html_Flex_Table(matrix,options={},style={})
{
    let table_style=Hashes_Merge
    (
        style,
        {
            "class": 'flex-container',
            "display": 'flex',
            "flexDirection": 'column',
        }
    );
    
    let tr_style=
        {
            "class": 'flex-container',
            "flexDirection": 'row',
        };
    let td_style=
        {
            "class": 'flex-item',
            //"flexDirection": 'row',
        };
    
    let table=Child_Create('div',"",options,table_style);
    

    for (let m=0;m<matrix.length;m++)
    {
        let row=Children_Create("div","span",matrix[m],{},td_style);
        
        Element_Set_Style(row,tr_style);
        
        table.append(row);
    }

    return table;
}

//* 
//* Create HTML toggles.
//* 

function Html_Toggles(clss,html,dest_tag="g",do_hide=false,hash={})
{
    let defaults={
        "Color":     "blue",
        "Tag":       "span",
        "Inner_Tag": "span",

        "Mark_Text": html,
        "UnMark_Text": html,
        
        "Mark_Func" : function()
        {
            Hide_Elements_By_Class(clss,"inline",dest_tag);
        },
        "UnMark_Func" : function()
        {
            Show_Elements_By_Class(clss,"inline",dest_tag);
        },
    };
    
    for (let key in defaults)
    {
        if (!hash[ key ] && defaults[ key ])
        {
            hash[ key ]=defaults[ key ];
        }
    }

    let color=hash[ "Color" ];
    let tag=hash[ "Tag" ];
    let inner_tag=hash[ "Inner_Tag" ];
    
    let toggles=Child_Create(tag);
    if (hash[ "id" ])
    {
        toggles.id=hash[ "id" ];
    }
    
    //let mark_func=hash[ "Mark_Func" ]

    let mark=Html_Toggle_Mark
    (
        clss,
        hash[ "Mark_Text" ],
        dest_tag,color,inner_tag,
        hash[ "Mark_Func" ]
    );
    
    let unmark=Html_Toggle_UnMark
    (
        clss,
        hash[ "UnMark_Text" ] ,
        dest_tag,color,inner_tag,
        hash[ "UnMark_Func" ]
    );

    if (do_hide)
    {
        mark.style.display='none';
    }
    else
    {
        unmark.style.display='none';
    }
 
    toggles.append(mark);
    toggles.append(unmark);

    if (do_hide)
    {
        //console.log("click");
        mark.click();
    }
    
    return toggles;
}

//* 
//* Create HTML toggle show.
//* 

function Html_Toggle_Mark(clss,html,dest_tag,color,tag,func)
{
    let mark=Child_Create(tag);
    
    mark.addEventListener
    (
        'click',
        function(clss)
        {
            func();

            Show_Elements_By_Class("Hide "+clss,"inline");
            Hide_Elements_By_Class("Show "+clss,"inline");
        }.bind(this,clss)
    );
    
    mark.innerHTML=html;
    mark.classList.add("Show",clss);
    mark.style.color =color;

    return mark;
}

//* 
//* Create HTML toggle hide.
//* 

function Html_Toggle_UnMark(clss,html,dest_tag,color,tag,func)
{
    let unmark=Child_Create(tag);
    
    unmark.addEventListener('click',func);
    unmark.addEventListener
    (
        'click',
        function(clss)
        {
            func();
            
            Show_Elements_By_Class("Show "+clss,"inline");
            Hide_Elements_By_Class("Hide "+clss,"inline");
        }.bind(this,clss)
    );
    
    unmark.innerHTML=html;
    unmark.classList.add(clss,"Hide");    
    unmark.style.color =color;
    unmark.style.opacity =0.75;

    return unmark;
}
