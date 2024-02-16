array
(
    "Search" => array
    (
        "AccessMethod" => "CheckShowListAccess",
    ),
    "Add" => array
    (
        "AccessMethod" => "CheckEditListAccess",
    ),
    "Copy" => array
    (
        "AccessMethod" => "CheckEditAccess",
    ),
    "Show" => array
    (
        "AccessMethod" => "CheckShowAccess",
    ),
    "Download" => array
    (
        "AccessMethod" => "CheckShowAccess",
    ),
    "Unlink" => array
    (
        "AccessMethod" => "CheckEditAccess",
    ),
    "Edit" => array
    (
        "AccessMethod" => "CheckEditAccess",
    ),
    "EditList" => array
    (
        "AccessMethod" => "CheckEditListAccess",
    ),
    "Select" => array
    (
        "Singular" => True,
    ),
    "Delete" => array
    (
        "AccessMethod" => "CheckDeleteAccess",
    ),
    "Root" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Root_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            "Text_Children_Has",
            "Text_Is_Root",
        ),
        "Icon" => "Text_Icon",
    ),
    "Roots" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => False,
        "Handler"     => "Text_Roots_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
        ),
        "Icon" => array("Texts_Icon","Texts_Alt_Icon"),
    ),
    "Display" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Display_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
        ),
        "Icon" => array("Texts_Icon","Texts_Alt_Icon"),
    ),
    "Parent" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Action=Display&Text=#Parent",
        "Singular" => True,
        //"Handler"     => "Text_Children_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            "Text_Parent_Has",
        ),
        "Icon" => "fas fa-hand-point-left",
    ),
    "Children" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Children_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            "Text_Children_Has",
        ),
        "Icon" => "fas fa-child",
    ),
    "Codes" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Codes_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            //"Text_Children_Has",
        ),
        "Icon" => "fas fa-child",
    ),
    "Create" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Create_Child_Handle",
        "AccessMethod" => array
        (
            "CheckEditAccess",
        ),
        "Icon" => "fas fa-plus",
    ),
    "Latex" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Text=#ID",
        "Singular" => True,
        "Handler"     => "Text_Latex_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            "Text_Latex_Is",
        ),
        "Icon" => "Latex_Icon",
    ),
    "PDF" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Latex=1&Text=#ID",
        "Singular" => True,
        "NoHeads" => 1,
        "Handler"     => "Text_PDF_Handle",
        "AccessMethod" => array
        (
            "CheckShowAccess",
            "Text_PDF_Is",
        ),
        "Icon" => "PDF_Icon",
    ),
);
