<?php

trait MyMod_LeftMenu
{
    /* //\* */
    /* //\* */
    /* //\* */

    /* function MyMod_LeftMenu_Handle() */
    /* { */
    /*     return */
    /*         $this->Htmls_Echo */
    /*         ( */
    /*             $this->MyMod_LeftMenu_Generate() */
    /*         ); */
    /* } */
    
    /* //\* */
    /* //\* */
    /* //\* */

    /* function MyMod_LeftMenu_Generate() */
    /* { */
    /*     $file=$this->MyMod_Setup_Path()."/LeftMenu.php"; */

    /*     $menu=$this->ReadPHPArray($file); */

    /*     return  */
    /*         $this->MyMod_LeftMenu_List */
    /*         ( */
    /*             $menu */
    /*         ); */
    /* } */
    
    /* //\* */
    /* //\* */
    /* //\* */

    /* function MyMod_LeftMenu_List($menu) */
    /* { */
    /*     $menuids=array_keys($menu); */

    /*     //Ordered by leading sorters (01_...,02_,... */
    /*     sort($menuids); */

    /*     $list=array(); */
    /*     foreach ($menuids as $menuid) */
    /*     { */
    /*         array_push */
    /*         ( */
    /*             $list, */
    /*             $this->MyMod_LeftMenu_Item($menuid,$menu[ $menuid ]) */
    /*         ); */
    /*     } */

    /*     return */
    /*         $this->Htmls_DIV */
    /*         ( */
    /*             $list, */
    /*             array */
    /*             ( */
    /*                 "CLASS" => 'menulist', */
    /*             ) */
    /*         ); */
    /* } */
    
    /* //\* */
    /* //\* */
    /* //\* */

    /* function MyMod_LeftMenu_Item($menuid,$menuitem) */
    /* { */
    /*     $uri=$menuitem[ "Href" ]; */
    /*     $hash=$this->CGI_URI2Hash(); */
    /*     $hash=$this->CGI_URI2Hash($uri,$hash); */
    /*     //var_dump($hash); */
        
    /*     $title= */
    /*         $this->LanguagesObj()->Language_MenuItem_Title_Get($menuid); */


    /*     return */
    /*         $this->Htmls_DIV */
    /*         ( */
    /*             $this->LanguagesObj()->Language_MenuItem_Name_Get($menuid), */
    /*             array */
    /*             ( */
    /*                 "TITLE" => $this->LanguagesObj()->Language_MenuItem_Title_Get($menuid), */
    /*                 "CLASS" => 'leftmenulinks', */
    /*             ) */
    /*         ); */
    /* } */
    
}

?>