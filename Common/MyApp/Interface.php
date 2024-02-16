<?php


include_once("Interface/Headers.php");
include_once("Interface/Head.php");
include_once("Interface/Body.php");
include_once("Interface/Tail.php");
include_once("Interface/Doc.php");
include_once("Interface/Messages.php");
include_once("Interface/Titles.php");
include_once("Interface/Icons.php");
include_once("Interface/Logos.php");
include_once("Interface/LeftMenu.php");
include_once("Interface/HorMenu.php");
include_once("Interface/CSS.php");
include_once("Interface/Mobile.php");
include_once("Interface/Reloads.php");

trait MyApp_Interface
{
    use
        MyApp_Interface_Headers,
        MyApp_Interface_Head,
        MyApp_Interface_Body,
        MyApp_Interface_Tail,
        MyApp_Interface_Doc,
        MyApp_Interface_Messages,
        MyApp_Interface_Titles,
        MyApp_Interface_Icons,
        MyApp_Interface_Logos,
        MyApp_Interface_LeftMenu,
        MyApp_Interface_HorMenu,
        MyApp_Interface_CSS,
        MyApp_Interface_Mobile,
        MyApp_Interface_Reloads;

    var $MyApp_Interface_Left_Menu_Post_Html=array();

    //*
    //* .
    //*

    function AllowedProfiles()
    {
        return $this->AllowedProfiles;
    }

    
    //*
    //* Initializes applicatiion interface.
    //*

    function MyApp_Interface_Init()
    {
        if (empty($this->HtmlSetupHash[ "CharSet" ]))
        {
            $this->HtmlSetupHash[ "CharSet"  ]="utf-8";
        }
        
        
        if (empty($this->HtmlSetupHash[ "DocTitle" ]))
        {
            $this->HtmlSetupHash[ "DocTitle"  ]=
                "Please give me a title (HtmlSetupHash->DocTitle)";
        }
        
        if (empty($this->HtmlSetupHash[ "Author" ]))
        {
            $this->HtmlSetupHash[ "Author"  ]=
                "Prof. Dr. Ole Peter Smith, IME, UFG, ole'at'mat'dot'ufg'dot'br";
        }
    }
    
    //*
    //* Generates cookies info message.
    //*
    //*

    function MyApp_Interface_Cookies_Message()
    {
        return
            array
            (
                "This system uses",
                $this->A('http://www.google.com/search?q=cookies',"Cookies,"),
                "please enable them in you browser!",
            );
    }
    //*
    //* Generates support info.
    //*

    function MyApp_Interface_Support()
    {
        $authorlinks=$this->HtmlSetupHash[ "AuthorLinks"  ];
        $authorlinknames=$this->HtmlSetupHash[ "AuthorLinkNames"  ];

        $links=array();
        for ($n=0;$n<count($authorlinks);$n++)
        {
            $name=$authorlinks[$n];
            if (!empty($authorlinknames[$n])) { $name=$authorlinknames[$n]; }
            
            array_push
            (
               $links,$this->A
               (
                  $authorlinks[$n],
                  $name,
                  array
                  (
                     "Target" => "_ext",
                  )
                  
               )
            );
        }

        return
            $this->Htmls_Tag
            (
                "CENTER",
                array
                (
                    $this->Htmls_Table
                    (
                        "",
                        array
                        (
                            array
                            (
                                $this->B("Author:"),
                                $this->HtmlSetupHash[ "Author"  ],
                                join(" - ",$links)
                            ),
                            array
                            (
                                $this->B("Support:"),
                                $this->Htmls_Image_Text
                                (
                                    "support.png",
                                    $this->HtmlSetupHash[ "SupportEmail" ],
                                    $this->ColorCode2Color
                                    (
                                        $this->Layout[ "DarkGrey" ]
                                    ),
                                    $this->ColorCode2Color
                                    (
                                        $this->Layout[ "LightBlue" ]
                                    )
                                ),
                                ""
                            ),
                        ),
                        array("CLASS" => 'supporttable')
                    ),
                )
            );
    }
    
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Thanks()
    {
        $table=
            $this->MyApp_Setup_Files2Hash
            (
                array
                (
                    $this->MyApp_Setup_Root().
                    "/Application/System/",
               
                    $this->MyApp_Setup_Path()
                ),
                array("Thanks.php")
            );

        foreach (array_keys($table) as $tid)
        {
            if
                (
                    !empty($table[ $tid ][2])
                    &&
                    !preg_match('/<A/',$table[ $tid ][2])
                )
            {
                $table[ $tid ][2]=
                    $this->A
                    (
                        $table[ $tid ][2],
                        $table[ $tid ][2],
                        array("TARGET" => '_blank')
                    );
            }
        }

        return
            array
            (
                $this->Htmls_DIV
                (
                    "Collaborators (alfabetical order):",
                    array("CLASS" => 'collaboratorstitle')
                ),
                $this->BR(),
                $this->Htmls_Tag
                (
                    "CENTER",
                    array
                    (
                        $this->Htmls_Table
                        (
                            "",
                            $table,
                            array("CLASS" => 'collaboratorstable'),
                            array(),array(),
                            True,True
                        )
                    )
                )
            );
     }

    
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Phrase()
    {
        return
            $this->Htmls_DIV
            (
                $this->IMG
                (
                    "icons/kierkegaard.png",
                    "Life sure is a Mystery to be Lived, ".
                    "Not a Problem to be Solved",
                    100,400
                ),
                array("ALIGN" => 'center')
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Sponsors_00000($element_id,$type,$n_max)
    {
        if (!method_exists($this,"SponsorsObj")) { return array(); }
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->SponsorsObj()->MyMod_ItemsName(),
                        $this->Htmls_SCRIPT
                        (
                            "Show_Sponsors".
                            "(".
                            $this->JS_Quote($element_id).
                            ",".
                            $this->JS_Quote($type).
                            ",".
                            $this->JS_Quote($n_max).
                            ",".
                            $this->JS_Quote($this->Unit("ID")).
                            ");"
                        )
                    ),
                    array
                    (
                        "ID" => $element_id,
                        //"CLASS" => 'Sponsors',
                    ),
                    array()
                )
            );
    }

    

    
    //*
    //* 
    //*

    function MyApp_Interface_Layout()
    {
        if ($this->MyApp_Interface_Mobile_Is())
        {
            return $this->MyApp_Interface_Mobile_Layout();
        }
        else
        {
            return $this->MyApp_Interface_Layout_Full();
        }
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Layout_Full()
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "BODY",
                    array
                    (
                        $this->Htmls_Tag
                        (
                            "STYLE",
                            array
                            (
                                "*.fcell {overflow: visible;}",
                                ".wrapper {",
                                "   display: grid;",
                                "   grid-template-columns: 1fr 5fr;",
                                "}",
                            )
                        ),
                        $this->Htmls_DIV
                        (
                            array
                            (
                                array
                                (
                                    $this->Htmls_DIV
                                    (
                                        $this->MyApp_Interface_Top_Left(),
                                        array
                                        (
                                            "ID" => "TL",
                                            "CLASS" => array
                                            (
                                                //"applicationtop",
                                                //"applicationleft",
                                                "fcell",
                                                "first",
                                            )
                                        )
                                    ),
                                    $this->Htmls_DIV
                                    (
                                        $this->MyApp_Interface_Top_Right(),
                                        array
                                        (
                                            "ID" => "TR",
                                            "CLASS" => array
                                            (
                                                //"applicationtop",
                                                //"applicationcenter",
                                                "headtable",
                                                "fcell"
                                            ),
                                        )
                                    ),
                                ),

                                array
                                (
                                    $this->Htmls_DIV
                                    (
                                        $this->MyApp_Interface_Middle_Left(),
                                        array
                                        (
                                            "ID" => "ML",
                                            "CLASS" => array
                                            (
                                                //"applicationmiddle",
                                                //"applicationleft",
                                                "leftmenu",
                                                "fcell first",
                                            )
                                        )
                                    ),
                                    $this->Htmls_DIV
                                    (
                                        array
                                        (
                                            $this->MyApp_Interface_Middle_Right(),
                                            $this->MyApp_Interface_Sponsors()
                                        ),
                                        array
                                        (
                                            "ID" => "MC",
                                            "CLASS" =>  array
                                            (
                                                "//applicationmiddle",
                                                //"applicationcenter",
                                                "section",
                                                "ModuleCell",
                                                "fcell",
                                            ),
                                        )
                                    ),
                                    
                                ),

                        
                               
                        
                                array
                                (
                                    $this->Htmls_DIV
                                    (
                                        $this->MyApp_Interface_Bottom_Left(),
                                        array
                                        (
                                            "ID" => "BL",
                                            "CLASS" =>  array
                                            (
                                                //"applicationbottom",
                                                //"applicationleft",
                                                "website-footer-row",
                                                "fcell first",
                                            ),
                                        )
                                    ),
                                    $this->Htmls_DIV
                                    (
                                        $this->MyApp_Interface_Bottom_Right(),
                                        array
                                        (
                                            "ID" => "BC",
                                            "CLASS" =>  array
                                            (
                                                //"applicationbottom",
                                                //"applicationcenter",
                                                "website-footer-row",
                                                "center",
                                                "fcell",
                                            ),
                                        )
                                    ),
                                ),

                            ),
                            array
                            (
                                "CLASS" => 'wrapper',
                            )
                        ),
                    ),
                    array
                    (
                        "ONLOAD" => "Load_Interface();",
                    )
                ),
                "</HTML>"
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Sponsors()
    {
        return array();
        return
            array
            (                
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->SponsorsObj()->MyMod_ItemsName(),
                    ),
                    array
                    (
                        "ID" => "Sponsors",
                        "CLASS" => 'Sponsors',
                    ),
                    array
                    (
                        "position" => 'sticky',
                        "bottom"   => '0',
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    "Show_Sponsors".
                    "(".
                    $this->JS_Quote("Sponsors").
                    ",".
                    $this->JS_Quote(1).
                    ",".
                    $this->JS_Quote(5).
                    ",".
                    $this->JS_Quote($this->Unit("ID")).
                    ");"
                )
            );
    }

    
    //*
    //* 
    //*

    function MyApp_Interface_Top_Left()
    {
        return
            array
            (
                $this->MyApp_Interface_Logo(1),
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Top_Right()
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "HEADER",
                    array
                    (
                        array
                        (
                            $this->MyApp_Interface_Body_Top_Center_Titles(),
                        ),
                    )
                )
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Middle_Left()
    {
        return
            array
            (
                $this->MyApp_Interface_LeftMenu(),
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Middle_Right()
    {
        $action=$this->CGI_GET("Action");

        $html=array();
        if ($action=="Start")
        {
            $html=$this->MyApp_Handle_Start_Generate();
        }
        else
        {
            $dest_id="ModuleCell";
            $html=
                array
                (
                    $this->Htmls_SCRIPT
                    (
                        $this->JS_Load_Once
                        (
                            array_merge
                            (
                                $this->CGI_URI2Hash(),
                                array
                                (
                                    "RAW" => 1,
                                    "Dest" => $dest_id,
                                )
                            ),
                            $dest_id
                        )
                    ),
                );            
        }
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $html,
                    ),
                    array
                    (
                        "ID" => "ModuleCell",
                    )
                ),
            );
    }


    //*
    //* 
    //*

    function MyApp_Interface_Bottom_Left()
    {
        return
            array
            (
                $this->Img
                (
                    $this->HtmlSetupHash[ "TailIcon_Left" ],
                    "Owl",
                    "100"
                )
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Bottom_Right()
    {
        return
            array
            (
                $this->Htmls_Tag
                (
                    "FOOTER",
                    array
                    (
                        array_merge
                        (
                            $this->Htmls_HR('100%'),
                            $this->MyApp_Interface_Cookies_Message(),
                            $this->Htmls_HR('100%'),
                            $this->MyApp_Interface_Support(),
                            //$this->Htmls_HR('75%'),
                            $this->MyApp_Interface_Thanks(),
                            $this->Htmls_HR('100%'),
                            $this->MyApp_Interface_Phrase(),
                            $this->Htmls_HR('100%'),
                            $this->MyApp_Interface_Body_Middle_Row_Cookies_Show(),
                            $this->Htmls_HR('100%'),
                            $this->DB_Queries_Show()
                        )
                    )
                ),
            );
    }
}

?>