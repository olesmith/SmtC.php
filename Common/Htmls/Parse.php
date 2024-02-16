<?php


trait Htmls_Parse
{
    //*
    //* Tags $html contents with $options;
    //*

    function Htmls_Parse($html)
    {
        $html=
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();

            "<DIV ID='1333'>".
            $html.
            "</DIV>";
        
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $html=$doc->getElementByID('ol');
        
        var_dump($html);
    }
}
?>