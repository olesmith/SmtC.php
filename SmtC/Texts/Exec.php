<?php

include_once("Exec/Info.php");
include_once("Exec/File.php");
include_once("Exec/Output.php");
include_once("Exec/Path.php");
include_once("Exec/Execute.php");

trait Texts_Exec
{
    use
        Texts_Exec_Info,
        Texts_Exec_File,
        Texts_Exec_Output,
        Texts_Exec_Path,
        Texts_Exec_Execute;
}

?>