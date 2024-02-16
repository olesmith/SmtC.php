//"use strict";


var MathJax_Loaded=false;

function Load_MathJax()
{
    Register_Time("Load_Math_Jax");
    if (!MathJax_Loaded)
    {
        let script1=document.createElement('script');
        
        script1.innerHTML=
            "MathJax = {"+
            "tex: {"+
            "inlineMath: [ ['$', '$'], ['[;', ';]'] ]"+
            //"inlineMath: [ ['$', '$'], ['[;', ';]'], ['\\(', '\\)'] ]"+
            "},"+
            "svg: {"+
            "fontCache: 'global'"+
            "}"+
            "};";
        script1.setAttribute("type", "text/javascript");
        script1.setAttribute("async",true);        

        let script=document.createElement('script');
        
        script.setAttribute
        (
            "src",
            'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js?config=TeX-AMS-MML_HTMLorMML'
        );
        
        script.setAttribute("type", "text/javascript");
        script.setAttribute("async",true);        

        let config =
            'MathJax.Hub.Startup.onload();'+
            'MathJax.typeset();'+
            '';

        if (window.opera) { script.innerHTML = config; }
        else { script.text = config; }

        document.head.append(script1);
        document.head.append(script);
        

        // success event 
        script.addEventListener
        (
            "load", () =>
            {
                //console.log("MathJax loaded");
            }
        );
        
        // error event
        script.addEventListener("error", (ev) => {
            console.log("Error loading MathJax", ev);
        });

        MathJax_Loaded=true;
    }
    else
    {
        MathJax.typeset();
    }
}

