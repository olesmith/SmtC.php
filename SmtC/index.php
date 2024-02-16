<?php


global $Setup_Path;

include_once("Accessor.php");
Accessor_Create
(
   array
   (
   ),
   $Setup_Path
);

include_once("Application/Application.php");
include_once("Modules/Common.php");

//traits
include_once("App/Mobile.php");
include_once("App/Top.php");
include_once("App/Start.php");
include_once("App/Profiles.php");
include_once("App/CLI.php");

class SmtC extends Application
{
    use
        App_Mobile,
        App_Top,
        App_Start,
        App_Profiles,
        App_CLI;
    
    var $DB=True;
    
    var $Sigma="&Sigma;";
    var $Mu="&mu;";
    var $Pi="&pi;";
    
    var $UserProfiles=array
    (
       "Friend","Coordinator",
    );
    
    var $LanguageKeys=array
    (
       "",
    );
    var $Start_Icon='far fa-hand-point-right';
    var $Email_Icon='fas fa-envelope';
    
    var $User_Create_Icon="fa fa-user-plus";
    var $Tops_Icon="fas fa-folder-open";
    var $Texts_Alt_Icon="fas fa-folder-minus";
    var $Texts_Icon="fas fa-folder-plus";
    var $Text_Icon="fas fa-hand-point-right";
    var $Latex_Icon="far fa-file-code";
    var $PDF_Icon="far fa-file-pdf";
    var $Children_Icon="fas fa-child";


    //*
    //* SmtC constructor, main object.
    //*

    function __construct($args=array())
    {
        $this->ApplicationObj=$this;
        $this->MyLanguage_Detect();
        
        $this->App_CSS_Add();
        parent::Application($args);
        
        $this->URL_CommonArgs=
            array
            (
                //"Friend"     => $this->Friend("ID"),
            );
        
    }
    
    //*
    //* Adds app specific css/js to $this->MyApp_Interface_Head_CSS_OnLine.
    //*

    function App_CSS_Add()
    {        
        array_push
        (
            $this->MyApp_Interface_Head_Scripts_OnLine,
            "JS/SmtC.js",
            "JS/MathJax.js",
            "JS/Children.js",
            "JS/Html.js",
            "JS/Arrays.js",
            "JS/Hashes.js",
            "JS/Vectors.js",

            
            "JS/Curve/Setup.js",
            "JS/Curve/Control.js",
            "JS/Curve/Control/Parameters.js",
            
            "JS/Curve/Control/Animation/Delay.js",
            "JS/Curve/Control/Animation/N.js",
            "JS/Curve/Control/Animation/t.js",
            "JS/Curve/Control/Animation/Button.js",
            
            "JS/Curve/Control/Animation.js",

            
            "JS/Curve/Calc.js",

            
            "JS/Curve/Osculating.js",
            "JS/Curve/Frenet.js",
            "JS/Curve/Rolling.js",
            "JS/Curve/Curves.js",
            
            "JS/Curve/Functions.js",
            
            "JS/Curve/Animation.js",
            "JS/Curve.js",

            
            "JS/SVG/Create.js",
            "JS/SVG/Attributes.js",
            "JS/SVG/Draw.js",
            "JS/SVG/Add.js",

            
            "JS/SVG/WCS.js",
            "JS/SVG/Mesh.js",
            
            "JS/SVG/Curve.js",
            "JS/SVG/Mark.js",
            "JS/SVG.js"
        );
        
        array_push
        (
            $this->MyApp_Interface_Head_Scripts,
            $this->MyApp_Load_Highlight()
        );
        
        array_push
        (
            $this->MyApp_Interface_Head_CSS_OnLine,
            "SmtC.css"
        );
    }

    //*
    //* The URI's to add for all links.
    //*

    function MyApp_Common_URIs()
    {
        return
            array
            (
                "App"      => "SmtC",
                "Friend"     => $this->CGI_GETint("Friend"),
            );
    }
    
    //*
    //* SCRIPT/LINK for prism.
    //*

    function MyApp_Load_Prism()
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                    
                    ),
                    array
                    (
                        "src" => "/prism/prism.js",
                        "type" => 'text/javascript',
                    )
                ),
                $this->HtmlTag
                (
                    "LINK",
                    "",
                    array
                    (
                        "REL" => 'stylesheet',
                        "HREF" => "/prism/themes/prism.css",
                    )
                ),
            );
    }
    
    //*
    //* SCRIPT/LINK for hightlight.
    //*

    function MyApp_Load_Highlight($style="default")
    {
        $html=
            array
            (
                $this->HtmlTag
                (
                    "LINK",
                    "",
                    array
                    (
                        "REL" => 'stylesheet',
                        "HREF" => "/highlight/styles/".$style.".min.css",
                    )
                ),
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                    
                    ),
                    array
                    (
                        "src" => "/highlight/highlight.js",
                        "type" => 'text/javascript',
                    )
                ),
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                        "hljs.highlightAll();",
                    )
                ),
            );

        foreach (array("latex","css","haml","javascript","c","python") as $language)
        {
            array_push
            (
                $html,
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array(),
                    array
                    (
                        "src" => "/highlight/languages/".$language.".min.js",
                        "type" => 'text/javascript',
                    )
                )
            );
        }
        
        return $html;
    }
}


function SmtC_Args()
{
    global $Setup_Path,$Upload_Path;

    
    return
        array
        (
            "AppName" => "SmtC",
            "PublicAllow" => TRUE,
            "SessionsTable" => "Sessions",
            "MayCreateSessionTable" => TRUE,
            "__MyApp_Interface_Mobile__" => True,
            "__MyApp_Interface_Mobile_Default__" => 1,


            "Mail" => TRUE,
            "Logging" => TRUE,
            "Authentication" => TRUE,
            "DB" => TRUE,

            "Log_Path" => "/usr/local/SmtC/Logs",
            "ItemData" => array(),
            "ActionPaths" => array
            (
                $Setup_Path
            ),
            "ActionFiles" => array("Actions.php"),
      
            "Upload_Path" => $Upload_Path,
            "Temp_Path" => "tmp",
            "SetupPath" => $Setup_Path,

            "AppLoadModules" => array
            (
                #"Units",
            ),

            "LogGETVars" => array
            (
                #"Unit"
            ),

            "LogPOSTVars" => array
            (
                "Edit","EditList","Save","Update","Generate","Transfer",
            ),

            "ValidProfiles" => array
            (
                "Public",
                "Friend",
                "Coordinator",
                "Admin",
            ),
            //"CGIVars" => "SigaZ_CGIVars_Get",

            //Email defunct...
            "Password_Changed_Email" => False,
        );
}


function SmtC()
{
    $application=new SmtC(SmtC_Args());
    $application->MyApp_Run(array());
}

?>
