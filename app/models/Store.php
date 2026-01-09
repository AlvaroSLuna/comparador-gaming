<?php

require_once __DIR__ . '/../../config/database.php';

class Store
{
    public static function all()
    {
        global $pdo;
        return $pdo->query("SELECT * FROM stores")->fetchAll(PDO::FETCH_ASSOC);
    }
}
