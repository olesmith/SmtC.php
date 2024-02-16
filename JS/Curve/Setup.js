"use strict";

let curve_id=Curve_Setup_ID();


//*
//* Unique ID to defining Text.
//*

function Curve_Setup_ID()
{
    let id=GET2Hash("Text");
    if (!id)
    {
        id=GET2Hash("ID");
    }

    return id;
}

let stroke_width="0.025";

let r_col="0000ff";
let dr_col="1DECA2";
let d2r_col="709CAD";
let frenet_col="CD25A9";
let evolute_col="F4760A";
let rolling_col="F02323";
let rho_col="0AD5F4";
let kappa_col="4A49E2";
let nu_col="CDE61A";

let other_col="ffffff";

let cols=
{
    "WCS": "aaaaaa",
    
    "R": r_col,
    "dR": dr_col,
    "d2R": d2r_col,
    "Frenet": frenet_col,
    "Evolute": evolute_col,
    "Rolling": rolling_col,
    "Osculating": rho_col,

    
    "v": dr_col,
    "d": d2r_col ,
    
    "omega": evolute_col ,
    "nu": nu_col,
    
    "kappa": kappa_col,
    "rho": rho_col,
    
    "theta": frenet_col,
    "s": rolling_col,
};

var Setup=
{
    "stroke-width": stroke_width,
    
    "Animation":
    {
        "Delay": 0.1, //seconds!! 
    },
    
    "Parameters":
    {
        "Title": "Properties",
        "Name": "Time Parameter: $t_1 \\leq t \\leq t_2$",
        
        "t1": 0,
        "t1_Title": "$t_1$:",
        
        "t2": 1,
        "t2_Title": "$t_2$:",
        
        "N": 100,
        "N_Title": "$N$:",
    },
    
    "Curve":
    {
        "ID": 'Undefined_'+curve_id,
        "Name":  'Undefined',
        "Title": 'Undefined',

        "Margin_Scale": 1.025,
        "Point_Size":   0.05,
        
        "Components":
        [
            "R","dR","d2R",
            "Frenet",
            "Evolute",
            "Rolling",
            "Osculating",
        ],

        "Uses": [],

        "X": "x",
        "Y": "y",
        
        "height": 400,
        "width":  400,
        
        "BG_Color": 'black',
                
        "WCS":
        {
            "class": "WCS",
            "Options":
            {
                "class": "WCS",
                "fill": '#'+cols[ "WCS" ],
                "stroke": '#'+cols[ "WCS" ],
                "stroke-width": 0.03,
            },
        },
        
        "R":
        {
            "Name": "Curve",
            "Symbol": "$\\underline{r}(t)$",
            "Hide": false,
            
            "stroke": '#'+cols[ "R" ],
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "dR":
        {
            "Name": "1st Derivative",
            "Symbol": "$\\underline{r}'(t)$",

            "stroke": '#'+cols[ "dR" ],
            "point-size": 0.05,
            "Options":
            {
            },
            "Hide": true,
        },
        
        "d2R":
        {
            "Name": "2nd Derivative",
            "Symbol": "$\\underline{r}''(t)$",

            "stroke": '#'+cols[ "d2R" ],
            "point-size": 0.05,
            "Options":
            {
            },
            "Hide": true,
            
        },
        "Evolute":
        {
            "Name": "Evolute",
            "Symbol": "$\\underline{c}(t)$",
            
            "Hide": false,
            "stroke": '#'+cols[ "Evolute" ],

            "point-size": 0.05,
            "Options":
            {
            },
        },


        
        "Frenet":
        {
            "Name": "Frenet",
            "Symbol": "$(\\underline{t}(t),\\underline{n}(t))$",
            
            "Hide": false,
            "point-size": 0.05,
            "stroke": '#'+cols[ "Frenet" ],
            "Options":
            {
            },
        },
        "Osculating":
        {
            "Name": "Osculating",
            "Symbol": "$\\underline{O}(t)$",
            
            "Hide": true,
            "stroke": '#'+cols[ "Osculating" ],
            
            "point-size": 0.05,
            
            "Options":
            {
            },
        },
    },
    "Functions":
    {
        "ID": 'Undefined_F_'+curve_id,
        "Name":  'Undefined',
        "Title": 'Undefined',
        
        "Components":
        [
            "v","d","omega","nu","kappa","rho",
            "theta","s",
        ],
        
        //"Uses": [],

        //"Margin_Scale": 1.025,
        "Point_Size":   0.05,
        
        "X": "t",
        "Y": "f(t)",
        
        "height": 400,
        "width":  400,
        
        "BG_Color": 'black',
        
        "WCS":
        {
            "Options":
            {
                "class": "WCS",
                "fill": '#'+cols[ "WCS" ],
                "stroke": '#'+cols[ "WCS" ],
                "stroke-width": 0.03,
            },
        },
        
        "v":
        {
            "Name": "Velocity",
            "Symbol": "$v(t)$",
            "Hide": false,
            "stroke": '#'+cols[ "v" ],
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "d":
        {
            "Name": "Determinant",
            "Symbol": "$d(t)$",
            "Hide": false,
            "stroke": '#'+cols[ "d" ],
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "omega":
        {
            "Name": "Angular Vel.",
            "Symbol": "$\\omega(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "omega" ],
            
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "nu":
        {
            "Name": "Ang. Freq.",
            "Symbol": "$\\nu(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "nu" ],
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "theta":
        {
            "Name": "Nat. Angle",
            "Symbol": "$\\theta(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "theta" ],
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "kappa":
        {
            "Name": "Curvature",
            "Symbol": "$\\kappa(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "kappa" ],
            
            "point-size": 0.05,
            "Options":
            {
            },
        },
        "rho":
        {
            "Name": "Curv. Ratio",
            "Symbol": "$\\rho(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "rho" ],
            "Options":
            {
            },
        },
        "s":
        {
            "Name": "Arc length",
            "Symbol": "$s(t)$",
            "Hide": true,
            "stroke": '#'+cols[ "s" ],
            
            "point-size": 0.05,
            "Options":
            {
            },
        },
    }
};

