<?php

class City {
    public $town;
    public $activity;
    public $season;
    public $image;
    public $flight_for;
    public $local_airport;
    public $flight_from;
    
    public function __construct($town, $activity, $season, $image, $flight_for, $local_airport, $flight_from){
        $this->town = $town;
        $this->activity = $activity;
        $this->season = $season;
        $this->image = $image;
        $this->flight_for = $flight_for;
        $this->local_airport = $local_airport;
        $this->flight_from = $flight_from;
    }
    public static function findByName($destinations, $town) {
        foreach ($destinations as $destination) {
          if ($destination->town == $town) {
            return $destination;
          }
        }
   }
}

    $seoul = new City('Seoul','本場の冷麺はコシが違う','冬は極寒のため、夏がおすすめ','./img_03/seoul.jpg','10:00 KA10便 12:00 現地着','仁川国際空港','15:00 KA11便 日本時間 17:00 着');
    $taipei = new City('Taipei','小籠包は有名店よりローカル店の方が安くて美味しい','いつでも温暖だが、夏は湿気がすごい','./img_03/taipei.jpg','9:00 CI34便 現地時間12:00 着','桃園国際空港','10:00 CI33便 日本時間 13:00 着');
    $manila = new City('Manila','マンゴーが安くて美味しい','雨季は道路が冠水することもあるので避けよう','./img_03/manila.jpg','13:00 NH55便 17:00 現地着','マニラ・ニノイアキノ国際空港','15:00 NH56便 日本時間 19:00 着');
    $guam = new City('Guam','あまりやることはないためビーチでのんびり','いつでも温暖','./img_03/guam.jpg','9:00 DL110便 12:00 現地着','グアム国際空港','19:00 DL111便 日本時間 22:00 着');
    $saipan = new City('Saipan','マニャガハ島は海の透明度が高い','いつでも温暖','./img_03/saipan.jpg','7:00 UN45便 11:00 現地着','サイパン国際空港','15:00 UN46便 日本時間 19:00 着');
    $sebu = new City('Sebu','ジンベイザメに９９％会えるオスロブには行ってみよう','雨季は海が濁るため避けよう','./img_03/sebu.jpg','9:00 NH11便 13:00 現地着','マクタン・セブ国際空港','15:00 NH13便 日本時間 20:00 着');
    $bkk = new City('Bangkok','本場のタイマッサージは安いけど結構痛いかも','雨季でも一日中雨ではないのでオールシーズンおっけー','./img_03/bkk.jpg','12:00 TG120便 17:00 現地着','スワンナプーム国際空港','15:00 TG119便 日本時間 20:00 着');
    $sgn = new City('Sgn','フォーはめちゃくちゃ美味い','ビーチではないのでいつでもおっけー','./img_03/sgn.jpg','6:00 VJ20便 11:00 現地着','タンソンニャット国際空港','5:00 VJ30便 日本時間 11:00 着');
    $samui = new City('Koh samui','ダイビングスポットはがいくつかある','タイの他の地域とは雨季が異なるため事前にしっかりチェック','./img_03/samui.jpg','9:00 TG40便 14:00 現地着','サムイ国際空港','11:00 TG39便 日本時間 17:00着');
    $hanoi = new City('Hanoi','世界遺産のハロン湾','いつでもおっけー','./img_03/hanoi.jpg','11:00 VA11便 17:00 現地着','ノイバイ国際空港','19:00 VA12便 日本時間 23:00 着');
    $hongkong = new City('Hongkong','本場の飲茶はほんと美味しい','いつでもおっけー','./img_03/hongkong.jpg','9:00 CX12便 13:00 現地着','香港国際空港','15:00 CX15便 日本時間 20:00 着');
    $pataya = new City('Pataya','バンコクからバスで二時間で行けるビーチ','雨季は避けよう','./img_03/pataya.jpg','9:00 TG130便 14:00 現地着','パタヤ国際空港','15:00 TG131便 日本時間 20:00 着');
    $changmai = new City('Chiang mai','バンコクと違いのんびりな雰囲気がいい','雨季でも雰囲気が出て楽しい','./img_03/changmai.jpg','9:00 TG40便 13:00 現地着','チェンマイ国際空港','15:00 TG39便 日本時間 20:00 着');
    $singapor = new City('Singapore','名物チキンライスは食べるべき','いつでもおっけー','./img_03/singapor.jpg','9:00 SQ200便 15:00 現地着','チャンギ国際空港','14:00 SQ122便 日本時間 20:00 着');
    $kul = new City('Kuala lumpur','治安もいいしご飯もおいしい','いつでもおっけー','./img_03/kul.jpg','5:00 ML30便 11:00 現地着','クアラルンプール国際空港','10:00 ML33便 日本時間 17:00 着');
    $cairns = new City('Cairns','世界遺産グレートバリアリーフは必見','年間を通じて温暖な気候を楽しめる','./img_03/cairns.jpg','13:00 QT40便 21:00 現地着','ケアンズ国際空港','15:00 QT39便 日本時間 23:00 着');
    $yangon = new City('Yangon','顔に塗るタナカを体験','いつでもおっけー','./img_03/yangon.jpg','8:00 NH222便 14:00 現地着','ヤンゴン国際空港','15:00 NH221便 日本時間 22:00 着');
    $borakai = new City('Borakai','海の透明度は抜群！シュノーケリングがおすすめ','雨季は何もできないので避けよう','./img_03/borakai.jpg','9:00 JL40便 14:00 現地着','ボラカイ空港','15:00 JL39便 日本時間 21:00 着');
    $bohol = new City('Bohol','海の透明度は抜群！','雨季は避けよう','./img_03/bohol.jpg','12:00 JL43便 17:00 現地着','ボホール空港','15:00 JL41便 日本時間 21:00 着');
    $sydney = new City('Sydney','定番のボンダイビーチやオペラハウスは押さえよう','１２月がクリスマスもあるのでおすすめ','./img_03/sydney.jpg','13:00 QT60便 21:00 現地着','シドニー国際空港','10:00 QT67便 日本時間 20:00 着');
    $hukok = new City('Hukok','ビーチとフォーの組み合わせは最高','雨季は避けよう','./img_03/hukok.jpg','9:00 VA55便 15:00 現地着','フーコック空港','11:00 VA56便 日本時間 19:00 着');
    $bali = new City('Bali','街全体がのんびりとした雰囲気があって何しても楽しい','いつでもオッケー','./img_03/bali.jpg','10:00 GA80便 17:00 現地着','バリ国際空港','15:00 GA81便 日本時間 22:00 着');
    $central_asia = new City('Central_asia','近接しているウズベキスタン、カザフスタン、キルギス周遊','冬は極寒のためおすすめしない','./img_03/central_asia.jpg','9:00 AF40便 12:00 現地着','シャルル・ド・ゴール空港','15:00 AF39便 日本時間 翌9:00 着');
    $vladiostock = new City('Vladivostok','２時間で行けるヨーロッパの雰囲気を感じよう','冬は極寒のため、夏がおすすめ','./img_03/vladio.jpg','9:00 JL23便 12:00 現地着','ウラジオストク国際空港','15:00 JL24便 日本時間 19:00 着');
    $paris = new City('Paris','本場のマカロンはおいしい','冬は極寒のため、夏がおすすめ','./img_03/paris.jpg','9:00 AF40便 現地時間12:00 着','シャルル・ド・ゴール空港','15:00 AF39便 日本時間 翌9:00 着');
    $rome = new City('Rome','パスタ、ピザは絶品','夏がおすすめ','./img_03/rome.jpg','10:00 AL140便 12:00 現地着','フィウミチーノ国際空港','10:00 AL142便 日本時間 翌9:00着');
    $frank = new City('Munich','ドイツビールは何杯でも飲める？！','冬は天気が悪いため、夏がおすすめ','./img_03/frank.jpg','9:00 LH500便 14:00 現地着','ミュンヘン国際空港','22:00 LH510便 日本時間 翌17:00 着');
    $dubai = new City('Dubai','砂漠もビーチもあって意外と暇しない','いつでも暑い！','./img_03/dubai.jpg','9:00 EM400便 16:00 現地着','ドバイ国際空港','15:00 EM410便 日本時間 翌19:00 着');
    $london = new City('London','パブ巡り','いつでも天気が悪い','./img_03/london.jpg','9:00 BR300便 14:00 現地着','ヒースロー国際空港','19:00 BR330便 日本時間 翌14:00 着');
    $zuric = new City('Zuric','マッターホルンは壮大','冬は極寒のため、夏がおすすめ','./img_03/zuric.jpg','7:00 NH229便 8:00 現地着','チューリッヒ国際空港','11:00 NH230便 日本時間 翌9:00 着');
    $paros = new City('Paros','ギリシャのマイナーな島だがそれだけに観光客も少なくゆっくり過ごせる','夏がおすすめ','./img_03/paros.jpg','9:00 JL100便 16:00 現地着','パロス国際空港','15:00 JL110便 日本時間 翌19:00 着');
    $madrid = new City('Madrid','本場のタパスを食べ歩こう','夏がいい','./img_03/madrid.jpg','8:00 IB10便 10:00 現地着','マドリード国際空港','10:00 IB11便 日本時間 翌14:00 着');
    $tunis = new City('Tunis','シティブサイドは雰囲気がいい','夏がおすすめ','./img_03/tunis.jpg','10:00 ET590便 12:00 現地着','チュニス国際空港','15:00 ET595便 日本時間 翌13:00 着');
    $cairo = new City('Cairo','ピラミッドは意外にがっかりしない','ラマダンの時期は外すのがベター','./img_03/cairo.jpg','6:00 EG50便 11:00 現地着','カイロ国際空港','19:00 EG55便 日本時間 翌18:00 着');
    $jerusarem = new City('Jerusarem','３宗教の聖地でもありなんとも言えない感覚に包まれる','いつでも','./img_03/jerusarem.jpg','12:00 TR122便 10:00 現地着','エルサレム国際空港','20:00 TR123便 日本時間 翌17:00 着');
    $dahab = new City('Dahab','世界一安いダイビングライセンスを取るべき','いつでも暑い','./img_03/dahab.jpg','13:00 EG90便 10:00 現地着','ダハブ国際空港','15:00 EG91便 日本時間 翌12:00 着');
    $tehran = new City('Tehran','イランは人が最高に優しい','いつでも','./img_03/iran.jpg','12:00 IR340便 9:00 現地着','イマーム・ホメイニ国際空港','11:00 IR344便 日本時間 翌6:00 着');
    $hono = new City('Honolulu','ノースショアの方がワイキキより日本人は少ない','いつでも','./img_03/honolulu.jpg','19:00 NH25便 12:00 現地着','ダニエル・イノウエ国際空港','15:00 NH26便 日本時間 翌20:00 着');
    $LA = new City('Los Angeles','何をしても天気左右される','夏がおすすめ','./img_03/LA.jpg','9:00 AA100便 9:00 現地着','ロサンゼルス国際空港','11:00 AA101便 日本時間 翌9:00 着');
    $NY = new City('New York','本場のミュージカルは一応おすすめ','冬は極寒のため、夏がおすすめ','./img_03/ny.jpg','15:00 AA200便 12:00 現地着','JFK国際空港','15:00 AA201便 日本時間 翌13:00 着');
    $mexicocity = new City('Mexicocity','本場のタコスはほんと美味しい','いつでも温暖','./img_03/mexico.jpg','9:00 AM400便 9:00 現地着','メキシコシティ国際空港','10:00 AM410便 日本時間 翌9:00 着');
    $miami = new City('Miami','好天率が高め！','いつでも温暖','./img_03/miami.jpg','9:00 AA333便 6:00 現地着','マイアミ国際空港','18:00 AA332便 日本時間 翌19:00 着');
    $quito = new City('Quito','南米といえばやっぱり牛肉！','冬は寒い','./img_03/quito.jpg','9:00 LT10便 12:00 現地着','キト国際空港','15:00 LT11便 日本時間 翌19:00 着');
    $montevideo = new City('Montevideo','あまり馴染みのない国だけど、意外にも発展している','夏がおすすめ','./img_03/montevideo.jpg','1:00 LT120便 6:00 現地着','モンテビデオ国際空港','10:00 LT122便 日本時間 翌6:00 着');
    $atakama = new City('Santiago','世界一の星空は必見。ただし当日の月（満月など）に左右される','いつでも。湿度がほぼ０％なのでうるおいグッズは必携','./img_03/atakama.jpg','12:00 LT20便 10:00 現地着','サンティアゴ国際空港','19:00 LT25便 日本時間 翌20:00 着');


     $destinations = array($seoul, $taipei, $manila, $guam, $saipan, $sebu, $bkk, $sgn, $samui, $hanoi, $hongkong, $pataya, $changmai, $singapor, $kul,$cairns,
                           $yangon, $borakai, $bohol, $sydney, $hukok, $bali, $central_asia, $vladiostock, $paris, $rome, $frank, $dubai,$london, $zuric, 
                           $paros, $madrid, $tunis, $cairo, $jerusarem, $dahab, $tehran, $hono, $LA, $NY, $mexicocity, $miami, $quito, $montevideo, $atakama);



?>