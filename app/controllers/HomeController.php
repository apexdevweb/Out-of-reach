<?php
require_once __DIR__ . "/../models/HomeManager.php";
class HomeController {
    public function homePage() {
        require_once __DIR__ . '/../views/layouts/home.php';
    }
}