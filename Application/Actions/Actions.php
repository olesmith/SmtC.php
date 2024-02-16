array
(
    //Handler generating left menu components
    "LeftMenu" => array
    (
        "Href"     => "",
        "HrefArgs" => "Action=LeftMenu",
        "Handler"   => "MyApp_Interface_LeftMenu_Handle",
        //"AccessMethod"   => "MyApp_Handle_HasHelp",

        "Admin" => 1,
        "Person" => 1,
        "Public" => 1,
    ),
    "Top" => array
    (
        "Href"     => "",
        "HrefArgs" => "Action=Top",
        "Handler"  => "MyApp_Interface_Body_Top_Handle",
        "Admin" => 1,
        "Person" => 1,
        "Public" => 1,
    ),
    "Help" => array
    (
        "Href"     => "",
        "HrefArgs" => "Action=Help",
        "Name"    => "Ajuda",
        "Title"     => "Ajuda",
        "Public"   => 1,
        "Person"   => 1,
        "Admin"   => 1,
        "Handler"   => "MyApp_Handle_Help",
        //"AccessMethod"   => "MyApp_Handle_HasHelp",
    ),
    "Start" => array
    (
        "Href"     => "",
        "HrefArgs" => "",

        "Handler"   => "MyApp_Handle_Start",
        "Public"   => 1,
        "Person"   => 1,
        "Admin"   => 1,
        "Title"    => "Início",
        "Title_ES" => "Início",
        "Title_UK" => "Start",
        "Name"     => "Início",
        "Name_ES"     => "Início",
        "Name_UK"     => "Start",
    ),
    "Logon" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "MyApp_Handle_Logon",
        "Public"   => 1,
        "Person"   => 0,
        "Admin"   => 0,
        "Title"    => "Efetuar Login",
        "Title_ES" => "Efetuar Login",
        "Title_UK" => "Do Login",
        "Name"     => "Login",
        "Name_UK"     => "Login",
        "Name_ES"     => "Login",
    ),
    "Logoff" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "MyApp_Handle_Logoff",
        "NoHeads"   => 1,
        "Public"   => 0,
        "Person"   => 1,
        "Admin"   => 1,
        "Title"    => "Sair do Sistema",
        "Title_ES" => "Salir del Sistema",
        "Title_UK" => "Logoff from the system",
        "Name"     => "Sair",
        "Name_UK"  => "Logoff",
        "Name_ES"  => "Salir",
    ),
    "NewPassword" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "MyApp_Login_Password_Change_Form",
        "Public"   => 0,
        "Person"   => 1,
        "Admin"   => 1,
        "Title"    => "Trocar sua Senha",
        "Title_UK" => "Change Your Password",
        "Title_ES" => "Cambiar su Contraseña",

        "Name"     => "Alterar Senha",
        "Name_UK"  => "Change Password",
        "Name_ES"  => "Cambiar Contraseña",
    ),
    "NewLogin" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "ChangeLoginForm",
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 0,
    ),
    "MyData" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "HandleMyData",
        "Public"   => 0,
        "Person"   => 1,
        "Admin"   => 1,
    ),
    "SU" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "AddIDArg"   => 0,
        "Handler"   => "MyApp_Handle_SU",
        
        "Title_ES" => "Cambiar Usuário",
        "Title"    => "Trocar Usuário",
        "Title_UK" => "Become Another User",
        "Name"     => "SU",
        "Name_UK"  => "SU",
        "Name_ES"  => "SU",
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
    ),
    /* "UnSU" => array */
    /* ( */
    /*     "Href"     => "", */
    /*     "HrefArgs" => "", */
    /*     "AddIDArg"   => 0, */
    /*     "AccessMethod"   => "UnSUAccess", */
    /*     "Admin"   => 0, */
    /*     "Handler"   => "MyApp_Handle_UnSU", */
    /*     "Public"   => 0, */
    /*     "Person"   => 0, */
    /*     "Admin"   => 0, */
    /* ), */
    /* "Log" => array */
    /* ( */
    /*     "Href"     => "", */
    /*     "HrefArgs" => "", */
    /*     "Handler"   => "MyApp_Handle_Log", */
    /*     "Public"   => 0, */
    /*     "Person"   => 0, */
    /*     "Admin"   => 0, */
    /* ), */
    /* "Backup" => array */
    /* ( */
    /*     "Href"     => "", */
    /*     "HrefArgs" => "", */
    /*     "Handler"   => "MyApp_Handle_Backup", */
    /*     "NoHeads"   => 1, */
    /*     "NoInterfaceMenu"   => 1, */
    /* ), */
    /* "Setup" => array */
    /* ( */
    /*     "Href"     => "", */
    /*     "HrefArgs" => "", */
    /*     "Handler"   => "MyApp_Handle_Setup", */
    /* ), */
    /* "Modules" => array */
    /* ( */
    /*     "Href"     => "", */
    /*     "HrefArgs" => "", */
    /*     "Handler"   => "MyApp_Handle_ModuleSetup", */
    /*     "Public"   => 0, */
    /*     "Person"   => 0, */
    /*     "Admin"   => 0, */
    /* ), */
    "Admin" => array
    (
        "Href"     => "",
        "HrefArgs" => "Admin=1",
        "AddIDArg"   => 0,
        "ConditionalAdmin"   => 1,
        "Handler"   => "MyApp_Handle_Admin",
    ),
    "NoAdmin" => array
    (
        "Href"     => "",
        "HrefArgs" => "Admin=0",
        "AddIDArg"   => 0,
        "ConditionalAdmin"   => 1,
        "Handler"   => "MyApp_Handle_NoAdmin",
    ),
    "ModPerms" => array
    (
        "Href"     => "",
        "HrefArgs" => "Action=ModPerms",
        "AddIDArg"   => 0,
        "ConditionalAdmin"   => 1,
        "Handler"   => "MyApp_Handle_ModPerms",
    ),

    "Register" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Action=Register",
        "Handler"   => "HandleNewRegistration",
    ),
    "Confirm" => array
    (
        "Href"     => "",
        "HrefArgs" => "?&Action=Confirm",
        "Handler"   => "HandleNewRegistration",
    ),
    "ResendConfirm" => array
    (
        "Href"     => "",
        "HrefArgs" => "?Action=ResendConfirm",
        "Handler"   => "HandleNewRegistration",
    ),
    "Recover" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "Login_Password_Recover_Handle",
        "Title"    => "Recuperar sua Senha",
        "Title_ES" => "Recuperar su Contraseña",
        "Title_UK" => "Recover Your Password",
        "Name"     => "Recuperar Senha",
        "Name_UK"  => "Recover Password",
        "Name_UK"  => "Recuperar Contraseña",
        "Public"   => 1,
        "Person"   => 0,
        "Admin"   => 0,
    ),
    "Sessions" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Handler"   => "MyApp_Handle_Sessions",
    ),
);
