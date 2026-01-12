<?php

class SteamService
{
    public static function getGames($limit = 20)
    {
        $url = "https://store.steampowered.com/api/featuredcategories";

        $json = file_get_contents($url);
        $data = json_decode($json, true);

        $games = [];

        foreach ($data['specials']['items'] as $item) {
            $games[] = [
                'name' => $item['name'],
                'price' => $item['final_price'] / 100,
                'url' => 'https://store.steampowered.com/app/' . $item['id']
            ];
        }

        return array_slice($games, 0, $limit);
    }
}
