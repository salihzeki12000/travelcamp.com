<?php


class Ranking {
    public $name;
    public $food;
    public $sightseeing;
    public $price;
    public $img;
    
    public function __construct($name, $food, $sightseeing, $price, $img) {
        $this->name = $name;
        $this->food = $food;
        $this->sightseeing = $sightseeing;
        $this->price = $price;
        $this->img = $img;
    }
    public static function findByName($cities, $name) {
        foreach ($cities as $city) {
          if ($city->name === $name) {
            return $city;
          }
        }
   }
}


    $bkk = new Ranking('バンコク','★ ★ ★ ★ ★','★ ★ ★ ★ ★','★ ★ ★ ★ ★','./img_02/bkk.jpg');
    $rome = new Ranking('ローマ','★ ★ ★ ★ ★','★ ★ ★ ★ ★','★ ★','./img_02/rome.jpg');
    $seoul = new Ranking('ソウル','★ ★ ★ ★ ★','★ ★ ★','★ ★ ★ ★','./img_02/korea.jpg');
    $ny = new Ranking('ニューヨーク','★ ★ ★ ★','★ ★ ★ ★ ★','★','./img_02/NY.jpg');
    $bali = new Ranking('バリ','★ ★ ★ ★ ★','★ ★ ★ ★ ★','★ ★ ★ ★','./img_02/bali.jpg');
    $ist = new Ranking('イスタンブール','★ ★ ★ ★','★ ★ ★ ★','★ ★ ★','./img_02/ist.jpg');
    $taipei = new Ranking('台北','★ ★ ★ ★ ★','★ ★ ★ ★','★ ★ ★ ★','./img_02/taipei.jpg');
    $saigon = new Ranking('ホーチミン','★ ★ ★ ★ ★','★ ★ ★','★ ★ ★ ★ ★','./img_02/sgn.jpg');
    
    $cities = array($bkk, $rome, $seoul, $ny, $bali, $ist, $taipei, $saigon);
    
    
    



?>