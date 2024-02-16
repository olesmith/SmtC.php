array
(
   "Basic" => array
   (
       "Data" => array
       (
           "Sort","Name","Title",
           "Body",
           "Parent",
           "File",
           "Root","Type","Public",
           "IsLatex",
           "Type","Mode",
           "Src",
           "URL",
       ), 
   ),
   "File" => array
   (
       "AccessMethod" => "Text_File_Is",
       "Data" => array
       (
           "File","Path",
           "Code_Type",
           "Sort","Name","Title",
           "File_Run_Res","File_Run_Time","File_Run_Last",
       ), 
       "NonAddGroup" => True,
   ),
   "Link" => array
   (
       "AccessMethod" => "Text_Is_Link",
       "Data" => array
       (
           "Sort","Name","Title",
           "Parent",
           "Destination",
       ), 
       "NonAddGroup" => True,
   ),
   "Carousel" => array
   (
       "AccessMethod" => "Text_Is_Carousel",
       "Data" => array
       (
           "Type",
           "Sort","Name","Title",
           "Carousel_Base_URI",
       ), 
       "NonAddGroup" => True,
   ),
   "URL" => array
   (
       "AccessMethod" => "Text_Is_URL",
       "Data" => array
       (
           "Type",
           "Sort","Name","Title",
           "Body",
           "URL",
       ), 
       "NonAddGroup" => True,
   ),
   "Exercise" => array
   (
       "AccessMethod" => "Text_Is_Question_Or_Exercise",
       "Data" => array
       (
           "Type",
           "Sort","Name","Title",
           "Body",
           "Answer","Solution",
       ),
       "NonAddGroup" => True,
   ),
   "Image" => array
   (
       "AccessMethod" => "Text_Is_Image",
       "Data" => array
       (
           "Type",
           "Sort","Name","Title",
           "Body",
           "URL",
       ), 
       "NonAddGroup" => True,
   ),
   "Code" => array
   (
       "AccessMethod" => "Text_Is_Code",
       "Data" => array
       (
           "Root","Type","Code_Type",
           "Sort","Name","Title",
           "Body",
           "Src",
       ), 
       "NonAddGroup" => True,
   ),
   "Details" => array
   (
       "Data" => array
       (
           "Parent",
           "Root","Type",
           "Public",
           "Sort",
           "Code","Code_Type",
           "IsLatex","PDF",
           "Open",
           "Friend",
           "Name","Title",
           "Body",

           "Path",
           "File",
           "Src",
           "URL",
       ), 
       "NonAddGroup" => True,
   ),
   "Children" => array
   (
       "Action" => "Children",
       "Data" => array
       (
       ), 
       "NonAddGroup" => True,
   ),
   "Times" => array
   (
       "Data" => array
       (
           "CTime","MTime","ATime",
           "Root","Type","Public",
           "Open",
           "Sort","Name","Title",
           "Body",
       ), 
       "NonAddGroup" => True,
    ),
);