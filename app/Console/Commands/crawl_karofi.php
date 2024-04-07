<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\DomCrawler\Crawler;

class crawl_karofi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:karofi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->crawlCategories('https://karofi.com');

    }

    public function getDomUrl($site): Crawler
    {
        return new Crawler(file_get_contents($site));
    }

    public function crawlCategories($site): void
    {
        $catCraw = [
            ['id'=> 3, 'link' =>'/cay-nuoc-nong-lanh-13'],
            ['id'=> 1, 'link' =>'/may-loc-nuoc-28'],
            ['id'=> 7, 'link' =>'/he-thong-loc-nuoc-cong-nghiep'],
        ];

        foreach ($catCraw as $val){
            echo('category:'. $val['link']).PHP_EOL;
            for ($i = 1 ;$i<100;  $i++){
                if(!empty($this->getDomUrl($site.$val['link'].'?page='.$i)->filter('.product-list__content')->text())){
                    $this->crawlPosts($site, $val['link'], $val['id']);
                }
            }
        }
    }

    public function crawlPosts($site, $uri, $catID):? array
    {
        if(substr($uri, 0, 1) === '/'){
            $this->getDomUrl($site.$uri)->filter('body .product-list__content .item')->each(function (Crawler $node) use ($site, $catID){
                $link = $node->filter('a')->attr('href');
                echo('post:'.$link).PHP_EOL;
                $this->crawlPost($site, $link, $catID);
            });
        }

        return null;
    }

    public function saveImage($url)
    {
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::disk('local')->put('vanloiphat/'.$name, $contents);
        Storage::disk('local')->put('thumb_vanloiphat/'.$name,
            Image::make($url)->orientate()->resize(null, 270, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()
        );

        return DB::table('images')->insertGetId(['uri' => '/storage/vanloiphat/'.$name, 'active' => 1]);
    }

    public function saveImages($images): string
    {
        $files = '';
        foreach ($images as $image){
            $contents = file_get_contents($image);
            $name = substr($image, strrpos($image, '/') + 1);
            Storage::disk('local')->put('vanloiphat/'.$name, $contents);
            Storage::disk('local')->put('thumb_vanloiphat/'.$name,
                Image::make($image)->orientate()->resize(null, 270, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream()
            );

            $files .= DB::table('images')->insertGetId(['uri' => '/storage/vanloiphat/'.$name, 'active' => 1]). ', ';
        }

        return substr($files, 0,-2);
    }
    public function crawlJS($data): array
    {
        return [
            'sku' => $data->variants[0]->title,
            'title' => $data->title,
            'keywords'=> $data->metadescription,
            'content' => substr($data->description, 0, strpos($data->description,'<table border="1"><tbody>')).'</article>',
            'price' => $data->price/100,
            'price_pro' => $data->compare_at_price/100,
            'image_id' => $this->saveImage($data->featured_image),
            'images' => $this->saveImages($data->media),
        ];
    }

    public function crawlContent($file, $catID): array
    {
        $crawl = $this->getDomUrl($file);
        $title = $crawl->filter('body .product-info__content h1')->html();
        $skus = explode(' ', $title);
        $sku  = array_pop($skus);
        $images = $crawl->filter('body .product-info__slide .slides .item')->each(function (Crawler $node){
            return $node->filter('img')->attr('src');
        });
        $content = $crawl->filter('body .product-info__content-short')->html().
            $crawl->filter('body .product-tabs__content .box-content__main')->html();
        if(strpos($content,'<div class="form-box"')){
            $content = substr($content, 0, strpos($content,'<div class="form-box"')).'</article>';
        }
        return [
            'active' => 1,
            'is_hot' => 1,
            'is_new' => 1,
            'is_promotion' => 1,
            'producer_id' => 2,
            'instalment' => 1,
            'title' => $crawl->filter('body .product-info__content h1')->text(),
            'sku' => $sku,
            'keywords'=> $title,
            'content' => $content,
            'description' => $crawl->filter('body #product_techcontent')->html(),
            'price' => str_replace([',',' VNĐ'],'', $crawl->filter('body .product-info__content-price')->text()),
            'price_pro' => 0,
            'image_id' => $this->saveImage($images[0]),
            'images' => $this->saveImages($images),
            'product_category_id' => $catID,
            'warning' => '',
            'certificate'=> '',
            'company_offer' =>
                "<ul>
                    <li>&nbsp;Hổ trợ giao h&agrave;ng tận nơi TP-HCM</li>
                    <li>&nbsp;Hổ trợ thi c&ocirc;ng lắp đặt tận nơi TP-HCM</li>
                    <li>&nbsp;Hổ trợ bảo tr&igrave; v&agrave; thay thế tận nơi TP-HCM</li>
                 </ul>",
            'producer_offer' =>
                "<ul>
                    <li>&nbsp;Hổ trợ trả g&oacute;p 0% l&atilde;i xuất trong 1 năm</li>
                </ul>"
        ];
     }
    public function crawlPost($site, $uri, $catID): void
    {
        if(substr($uri, 0, 18) === $site){
            $content = $this->crawlContent($uri, $catID);
            $product = Product::where('title', $content['title'])->first();
            if($product == null) {
                DB::table('products')->insertGetId($content);
            }
        }
    }
}
