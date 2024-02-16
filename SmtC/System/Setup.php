array
(
    "DefaultAction" => "Start",
    "CSSFile"       => "sigab.css",
    "DefaultProfile" => 2,
    "LoginPermissionVars" => array(),
    "SqlTableVars" => array("SqlVars"),
    "CommonData" => array
    (
        "Hashes" => array
        (
            "Login" => "Auth.Data.php",
            "MySql" => "DB.php",
            "Mail" => "Mail.php",
        ),
    ),
    "AllowedModules" => array
    (
        "Languages",
        "Friends",  
        "Texts",  
        "Logs",
    ),

    "SubModulesVars" => array
    (
        "include_file" => "System/Modules.php",
    ),
    "Module2Groups" => array
    (
    ),
    "ModuleGroups2Actions" => array
    (
        //Actions should be defined in System/Actions.php (or elsewhere)
        "Configuration" => array
        (
            "Name" => "Configuração",
            "Title" => "Configuração",
            "Name_UK" => "Configuration",
            "Title_UK" => "Configuration",
            "Actions" => array
            (
            ),
        ),
    ),
);