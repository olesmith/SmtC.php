array
(
    "Path"       => array
    (
        "Sql" => "VARCHAR(1024)",
        "Search" => True,
        "TriggerFunction"  => "Text_Path_Exec_Trigger",
        //"PermsMethod" => "Text_Perms_Exercise_Answer",
    ),
    "File"       => array
    (
        "Sql" => "FILE",
        "Extensions" => array("png","jpg","pdf","svg","py"),
        "Search" => FALSE,
        "NoAdd" => True,
        //"PermsMethod" => "Text_Perms_Exercise_Answer",
    ),
    "File_Run_Res"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Search"  => True,

        "ReadOnly" => True,
        "Default" => -1,
    ),
    "File_Run_Time"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,

        "ReadOnly" => True,
        "Default" => -1,
    ),
    "File_Run_Last"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,

        "ReadOnly" => True,
        "TimeType" => True,
        "Default" => -1,
    ),
);