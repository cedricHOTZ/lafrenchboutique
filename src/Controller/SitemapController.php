<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends AbstractController
{
    public function sitemap()
    {
        // Obtenez les URLs que vous souhaitez inclure dans le sitemap
        $urls = [
            [
                'loc' => $this->generateUrl('app_product', ['slug' => 'valeur-du-slug']), 
                'lastmod' => '2023-04-23',
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],

            // Ajoutez d'autres URLs ici...
        ];

        // Créez le contenu XML du sitemap
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $xml->startElement('url');
            $xml->writeElement('loc', $url['loc']);
            $xml->writeElement('lastmod', $url['lastmod']);
            if (isset($url['changefreq'])) {
                $xml->writeElement('changefreq', $url['changefreq']);
            }
            if (isset($url['priority'])) {
                $xml->writeElement('priority', $url['priority']);
            }
            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        // Retournez le contenu XML dans une réponse HTTP
        $response = new Response($xml->outputMemory());
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
