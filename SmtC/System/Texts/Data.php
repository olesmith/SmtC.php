array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    
    "Sort"       => array
    (
        "Sql"   => "VARCHAR(256)",
        "Compulsory" => FALSE,

        "Search" => True,
        "Add"  => TRUE,
    ),
    "Name"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => 1,
        "Search"  => TRUE,
        "Add"  => TRUE,
    ),
    "Title"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Body"         => array
    (
        "Sql" => "TEXT",
        "Size" => "50x5",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Public"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("NoYes"),
        "Default" => 1,
        "Search" => True,
        "Comment_Method"   => "Text_Children_Apply_To_CheckBox",
        "TriggerFunction"  => "Text_Children_Apply_To",
    ),
    "IsLatex"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("NoYes"),
        "Default" => 1,
        "Search" => True,
        "Comment_Method"   => "Text_Children_Apply_To_CheckBox",
        "TriggerFunction"  => "Text_Children_Apply_To",
    ),
    "PDF"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("NoYes"),
        "Default" => 1,
        "Search" => True,
        "Comment_Method"   => "Text_Children_Apply_To_CheckBox",
        "TriggerFunction"  => "Text_Children_Apply_To",
    ),
    "Parent"       => array
    (
        "Sql"   => "INT",
        "SqlClass" => "Texts",
        "Compulsory" => FALSE,
        
        "Default" => " 0",
        "Search" => True,

        "Add"  => TRUE,
        "EditFieldMethod" => "Text_Parent_Select",
    ),
    "Friend"       => array
    (
        "Sql"   => "INT",
        "SqlClass" => "Friends",
        "Compulsory" => FALSE,

        "Search" => True,
    ),
    
    "Mode"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => array("Item","List"),
        "Search" => True,
        "Default" => 2,
    ),
    "Type"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("Text_Types"),
        "Default" => 1,

        "Search" => True,

        "Nexts" => array
        (
            9 => 11,
           11 => 1,
        ),
    ),
    
    "Root"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("NoYes"),
        "Default" => 1,
        "Search" => True,
    ),
    "Open"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => $this->MyLanguage_GetMessages("NoYes"),
        "Default" => 1,
        "Search" => True,
        "Comment_Method"   => "Text_Children_Apply_To_CheckBox",
        "TriggerFunction"  => "Text_Children_Apply_To",
    ),
    
    "Code_Type"       => array
    (
        "Sql"   => "ENUM",
        "Compulsory" => FALSE,

        "Values" => array
        (
            "HTML",
            "JS",
            "SVG",
            "\\LaTeX",
            "Python (3)",
            "PHP",
        ),
        "Default" => 2,

        "Search" => True,
    ),
    "Src"       => array
    (
        "Sql"   => "VARCHAR(1024)",
        "Compulsory" => FALSE,

        "Search" => True,
    ),
);