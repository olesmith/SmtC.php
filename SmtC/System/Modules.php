   "Languages" => array
   (
      "SqlClass" => "Languages",
      
      "SqlDerivedData" => "Language_Message_Derived_Data",
//array("Module","Message_Key"),
      "SqlFile" => "Languages.php",

      "ItemNamer" =>
         "#Name_".
         $this->ApplicationObj()->MyLanguage_Detect(),
      "SqlFilter" =>
         "#Name_".
         $this->ApplicationObj()->MyLanguage_Detect(),
      "SqlTitleFilter" =>
         "#Title_".
         $this->ApplicationObj()->MyLanguage_Detect().
         " (#ID)",
      "SqlHref" => "1",
      "SqlObject" => "LanguagesObject",
      "SqlTable" => "_Languages_",
      
   ),
   "Logs" => array
   (
      "SqlClass" => "Logs",
      "SqlDerivedData" => array("Message"),
      "SqlFile" => "Logs.php",
      "SqlFilter" => "#Message",
      "SqlHref" => "1",
      "SqlObject" => "LogsObject",
      "SqlTable" => "Logs",
   ),
   "Friends" => array
   (
      "SqlClass" => "Friends",
      "SqlDerivedData" => array("Name","Email"),
      "SqlFile" => "Friends.php",
      "SqlFilter" => "#Name",
      "SqlFilter_Public" => "#Name",
      "SqlTitleFilter" => "#Name (#ID - #Email)",
      "SqlHref" => "1",
      "SqlObject" => "FriendsObject",
      "SqlTable" => "Friends",
   ),
   "Texts" => array
   (
      "SqlClass" => "Texts",
      "SqlDerivedData" => array("Name","Title"),
      "SqlFile" => "Texts.php",
      "SqlFilter" => "#Name: #Title",
      "SqlFilter_Public" => "#Name: #Title",
      "SqlTitleFilter" => "#Name: #Title",
      "SqlHref" => "1",
      "SqlObject" => "TextsObject",
      "SqlTable" => "Texts",
   ),
