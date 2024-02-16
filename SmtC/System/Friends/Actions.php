array
(
    'Search' => array
    (
        'AccessMethod' => "CheckShowListAccess",
    ),
    'Add' => array
    (
        'AccessMethod' => "CheckEditListAccess",
    ),
    'Copy' => array
    (
        'AccessMethod' => "CheckEditAccess",
    ),
    'Show' => array
    (
        'AccessMethod' => "CheckShowAccess",
    ),
    'Edit' => array
    (
        'AccessMethod' => "CheckEditAccess",
    ),
    'EditList' => array
    (
        'AccessMethod' => "CheckEditListAccess",
    ),
    'Delete' => array
    (
        'AccessMethod' => "CheckDeleteAccess",
    ),
    "Permissions" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Friend=#ID",
        'Singular' => True,
        "Handler"     => "Friend_Permissions_Handle",
        'AccessMethod' => array
        (
            "CheckEditAccess",
        ),
        "Icon" => "Permissions_Icon",
    ),
    "Tops" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Action=Tops&Friend=#ID",
        'Singular' => True,
        'AccessMethod' => array
        (
            "CheckShowAccess",
        ),
        "Icon" => "Permissions_Icon",
        "Handler"     => "Friend_Tops_Handle",
    ),
    "Texts" => array
    (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Texts&Action=Search&Friend=#ID",
        'Singular' => True,
        'AccessMethod' => array
        (
            "CheckShowAccess",
        ),
        "Icon" => "Texts_Icon",
        "Handler"     => "Friend_Texts_Handle",
    ),
    "Sessions" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        'Singular' => True,
        "Handler"     => "Friends_Sessions_Handle",
        'AccessMethod' => array
        (
            "CheckEditAccess",
        ),
        //"Icon" => "Permissions_Icon",
    ),
);
