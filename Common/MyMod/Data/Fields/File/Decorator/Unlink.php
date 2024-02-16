<?php


trait MyMod_Data_Fields_File_Decorator_Unlink
{
    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_SPAN($edit,$item,$data,$value)
    {
        if ($edit==0 || empty($item[ $data ])) { return ""; }

        $filename=$this->MyMod_Data_Fields_File_FileName($data,$item);
        
        if (!file_exists($filename)) { return ""; }

        
        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data),
                array
                (
                    "CLASS" => "uploadmsg",
                    "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Unlink_Title($item,$data),
                    "ONCLICK" => $this->JS_Load_URL_2_Element_Do
                    (
                        $this->CGI_GET("Dest"),
                        $this->MyMod_Data_Fields_File_Decorator_Unlink_URI
                        (
                            $item,$data
                        )
                    )
                )
            );
    }

    
    //* FileUnlinkLink
    //* 
    //* Creates icon for file unlinking.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data)
    {
        return
            $this->MyMod_Interface_Icon("fas fa-trash");

            $this->MyActions_Entry_Icon("Unlink");
    }
     
    //* FileDownloadTitle
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Title($item,$data)
    {
        return
            $this->MyMod_Data_Fields_File_Decorator_Title
            (
                $item,$data,
                "Field_File_Delete_Title"
            );
    }
     
    //* FileDownloadRemove Link
    //* 
    //* Creates links for file download removal.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_URI($item,$data)
    {
        $args=$this->CGI_URI2Hash();
        $args=$this->CGI_Hidden2Hash($args);
        $this->CGI_CommonArgs_Add($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Unlink";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return $args;
        return
            $this->MyActions_Entry_Alert
            (
                "?".$this->CGI_Hash2Query($args),
                $this->MyLanguage_GetMessage("Upload_Remove_Confirm")."?"
            );
    }
    
}

?>