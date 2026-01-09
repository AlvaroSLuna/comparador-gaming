<?php

require_once __DIR__ . '/../helpers/HttpClient.php';

class PcComponentesScraper
{
    public static function getPrice($url)
    {
        $html = HttpClient::get($url);

        if (!$html) return null;

        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // ⚠️ Selector puede cambiar con el tiempo
        $priceNode = $xpath->query("//span[contains(@class,'price')]")->item(0);

        if (!$priceNode) return null;

        $price = trim($priceNode->textContent);
        $price = str_replace(['€', '.', ','], ['', '', '.'], $price);

        return floatval($price);
    }
}
