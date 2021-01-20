<?php

namespace App\Traits;

use App\Traits\Url;

class SiteMap
{
    const START_TAG = '<?xml version="1.0" encoding="UTF-8"?>
                        <urlset
                            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
                        <!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->';
    const END_TAG = '</urlset>';

    // to build the XML content
    private $content;

    public function add(Url $siteMapUrl)
    {
        $this->content .= $siteMapUrl->build();
    }

    public function build()
    {
        return self::START_TAG . $this->content . self::END_TAG;
    }
}