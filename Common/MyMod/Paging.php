<?php

include_once("Paging/Menu.php");

trait MyMod_Paging
{
    use
       MyMod_Paging_Menu;


    var $Page,$PageURL="",
        $NItemsPerPage=15,
        $NumberOfItems=0,
        $FirstItemNo=0,
        $LastItemNo=0,
        $OffSet=0;

    
    var $MyMod_Paging_Messages="Paging.php";
    var $MyMod_Paging_No=0;
    var $MyMod_Paging_N=0;
    var $MyMod_Paging_Items_PerLine=15;
    var $MyMod_Paging_NPages_In_Menu=5;
    var $MyMod_Paging_NPages_Intermediate=5;
    var $MyMod_Paging_Active_ID=0;
    var $MyMod_Paging_First_Names=array();
    
    //*
    //* Initializes paging subsystem.
    //*

    function MyMod_Paging_Init($hash=array())
    {
        $query=$this->CGI_Script_Query_Hash();
        unset($query[ "Page" ]);

        $query=$this->MyMod_Search_CGI_Hash_Get($query);

        $this->PageURL=$this->CGI_Script_Exec($this->CGI_Hash2Query($query));
 
        $this->NumberOfItems=count($this->ItemHashes);
        foreach (array_keys($this->ItemHashes) as $id)
        {
            $name="";
            if (!empty($this->ItemHashes[ $id ][ $this->ItemNamer ]))
            {
                $name=$this->ItemHashes[ $id ][ $this->ItemNamer ];
            }
            if (!empty($this->ItemHashes[ $id ][ "Name" ]))
            {
                $name=$this->ItemHashes[ $id ][ "Name" ];
            }

            $this->MyMod_Paging_First_Names[ $id ]=$name;
        }

        $this->MyMod_Paging_NItemsPerPage_Set();
        $this->MyMod_Paging_NPages_Set();
        $this->MyMod_Paging_Page_No_Set();
        $this->MyMod_Paging_Page_No_2_Item_Nos();
    }

    //*
    //* $this->NItemsPerPage from CGI.
    //*

    function MyMod_Paging_NItemsPerPage_Set()
    {
        $val=$this->CGI_POSTint($this->ModuleName."_NItemsPerPage");;
        if (!empty($val))
        {
            $this->NItemsPerPage=$val;
            //var_dump("Paging from POST: ".$val);
            
        }
        else
        {
            $val=$this->CGI_GETint("NItemsPerPage");
            if (!empty($val))
            {
                $this->NItemsPerPage=$val;
                //var_dump("Paging from GET: ".$val);
            }
        }

        return $this->NItemsPerPage;
    }
    
    //*
    //* Updates $this->MyMod_Paging_N.
    //*

    function MyMod_Paging_NPages_Set()
    {
        if ($this->NumberOfItems>$this->NItemsPerPage)
        {
            $this->MyMod_Paging_N=intval($this->NumberOfItems/$this->NItemsPerPage);
            $res=$this->NumberOfItems % $this->NItemsPerPage;
            if ($res>0) { $this->MyMod_Paging_N++; }
        }
        elseif ($this->NumberOfItems>0)
        {
            $this->MyMod_Paging_N=1;
        }
        else
        {
            $this->MyMod_Paging_N=0;
        }
    }
    
    //*
    //* Returns value of pageno, as from CGI.
    //*

    function MyMod_Paging_Page_No_Get()
    {
        $this->MyMod_Paging_No=$this->GetPOST($this->ModuleName."_Page");
        if (empty($this->MyMod_Paging_No))
        {
            $this->MyMod_Paging_No=$this->GetGETOrPOST("Page");
        }

        if (empty($this->MyMod_Paging_No)) { $this->MyMod_Paging_No=1; }

        return $this->MyMod_Paging_No;
    }

    //*
    //* Updates $this->MyMod_Paging_No.
    //*

    function MyMod_Paging_Page_No_Set()
    {
        //$this->MyMod_Paging_No=$this->PresetPage;
        if (empty($this->MyMod_Paging_No))
        {
            $this->MyMod_Paging_No=$this->GetPOST($this->ModuleName."_Page");
            if (empty($this->MyMod_Paging_No))
            {
                $this->MyMod_Paging_No=$this->GetGETOrPOST("Page");
            }
        }

        if (
              empty($this->MyMod_Paging_No)
              ||
              $this->MyMod_Paging_No>$this->MyMod_Paging_N
           )
        {
            $this->MyMod_Paging_No=1;
        }
    }

    //*
    //* Updates $this->FirstItemNo, $this->LastItemNo and $this->OffSet.
    //*

    function MyMod_Paging_Page_No_2_Item_Nos()
    {
        if ($this->NumberOfItems>$this->NItemsPerPage)
        {
            if ($this->MyMod_Paging_Active_ID && $this->MyMod_Paging_Active_ID>0)
            {
                $this->FirstItemNo=0;
                foreach ($items as $id => $item)
                {
                    if ($item[ "ID" ]==$this->MyMod_Paging_Active_ID)
                    {
                        $this->FirstItemNo=$id;
                        $this->OffSet=$this->NumberOfItems;
                    }
                }
            }
            else
            {
                if ($this->MyMod_Paging_No==0)
                {
                    $this->FirstItemNo=0;
                    $this->OffSet=$this->NumberOfItems;
                }
                elseif
                    (
                        preg_match('/\d+/',$this->MyMod_Paging_No)
                        &&
                        $this->MyMod_Paging_No>0
                    )
                {
                    $res=$this->NItemsPerPage % $this->NumberOfItems;

                    $this->FirstItemNo=
                        ($this->MyMod_Paging_No-1)*$this->NItemsPerPage+1;
                    $this->OffSet=$res;
                }
                else
                {
                    $this->FirstItemNo=0;
                    $this->OffSet=0;
                }
            }
        }
        else
        {
            $this->FirstItemNo=0;
            $this->OffSet=$this->NumberOfItems;
        }

        $this->LastItemNo=$this->FirstItemNo+$this->OffSet;
     }
}

?>