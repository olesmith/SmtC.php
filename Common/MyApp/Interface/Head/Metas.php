<?php


trait MyApp_Interface_Head_METAs
{    
    //*
    //* Returns interface header META section
    //*

    function MyApp_Interface_METAs($nochache=true)
    {
        $metas=
            array
            (
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "HTTP-EQUIV" => 'Content-type',
                        "CONTENT"    => "text/html; charset=".$this->HtmlSetupHash[ "CharSet"  ],
                    )
                ),
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "NAME"    => 'Autor',
                        "CONTENT" => $this->HtmlSetupHash[ "Author"  ],
                    )
                ),
                $this->HtmlTag
                (
                   "META",
                    "",
                    array
                    (
                        "CHARSET"    => $this->HtmlSetupHash[ "CharSet"  ],
                    )
                ),
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "NAME"    => 'viewport',
                        "CONTENT" => 'width=device-width, initial-scale=1',
                    )
                )
            );

        if (!$nochache)
        {
            $metas=
                array_merge
                (
                    $metas,
                    $this->MyApp_Interface_METAs_NoCache()
                );
        }
        
        return $metas;
    }
    
    
    //*
    //* Returns interface header META section
    //*

    function MyApp_Interface_METAs_NoCache()
    {
        return
            array
            (
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "http-equiv" => "Cache-Control",
                        "content" => "no-cache, no-store, must-revalidate",
                    )
                ),
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "http-equiv" => "Pragma",
                        "content" => "no-cache",
                    )
                ),
                $this->HtmlTag
                (
                    "META",
                    "",
                    array
                    (
                        "http-equiv" => "expires",
                        "content" => "0 ",
                    )
                ),
            );
    }
    
    
    
    
}

?>