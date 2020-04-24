<?php 
require_once('ranking_02.php');

class Review {
    public $city_name;
    public $comment;
   
    public function __construct($city_name, $comment) {
        $this->city_name = $city_name;
        $this->comment = $comment;
    }
}

    $review1 = new Review($bkk->name, '屋台でもクオリティの高い食べものが多いです');
    $review2 = new Review($bkk->name, '人が暖かい');
    $review3 = new Review($bkk->name, 'お酒が安い');
    $review4 = new Review($rome->name, '観光スポットが多い');
    $review5 = new Review($rome->name, '本場のイタリアンが最高でした');
    $review6 = new Review($rome->name, 'スリが多いので常に気をつけていました');
    $review7 = new Review($seoul->name, 'コスメが安い');
    $review8 = new Review($seoul->name, '料理がおいしい');
    $review9 = new Review($seoul->name, '物価が安い');
    $review10 = new Review($ny->name, '本場のミュージカルに感動しました');
    $review11 = new Review($ny->name, '美術館に安く入れてお得');
    $review12 = new Review($ny->name, '人が冷たかった');
    $review13 = new Review($bali->name, '料理がおいしい');
    $review14 = new Review($bali->name, 'カフェが多くゆっくりすごせました');
    $review15 = new Review($bali->name, '海はそこまで綺麗ではないです');
    $review16 = new Review($ist->name, '世界遺産に感動！');
    $review17 = new Review($ist->name, 'ケバブが美味しかった');
    $review18 = new Review($ist->name, '親日国であることを感じた');
    $review19 = new Review($taipei->name, '何を食べてもおいしいです');
    $review20 = new Review($taipei->name, '日本からも近いのでまたいきたいです');
    $review21 = new Review($taipei->name, '交通網が発達してて移動がらくちん');
    $review22 = new Review($saigon->name, 'フォーがとてもおいしかった');
    $review23 = new Review($saigon->name, 'タクシーでぼったくられました');
    $review24 = new Review($saigon->name, '物価がとても低い');
    $review25 = new Review($bkk->name, '何もかも最高！');
    $review26 = new Review($rome->name, 'パスタが絶品でした');
    $review27 = new Review($ny->name, '冬場はとても寒いです');
    $review28 = new Review($ist->name, 'サバサンドがおいしかった');
    $review29 = new Review($taipei->name, '人が暖かいです');
    $review30 = new Review($saigon->name, 'マッサージが安くてまたいきたい');
    
    
    $reviews = array($review1,$review2,$review3,$review4,$review5,$review6,$review7,$review8,$review9,$review10,$review11,$review12,$review13,$review14,$review15,$review16,$review17,$review18,$review19,$review20,$review21,$review22,$review23,$review24,$review25,$review26,$review27,$review28,$review29,$review30,);
?>


