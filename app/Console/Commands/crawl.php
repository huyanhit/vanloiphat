<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\DomCrawler\Crawler;

class crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:robot';

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
        $this->crawlCategories('https://robot.com.vn');

    }

    public function getDomUrl($site): Crawler
    {
        return new Crawler(file_get_contents($site));
    }

    public function crawlCategories($site): void
    {
        $catCraw = [
            ['id'=> 2, 'link' =>'/collections/may-loc-nuoc-dien-giai-ion-kiem-robot'],
            ['id'=> 4, 'link' =>'/collections/may-loc-nuoc-ro-hydrogen-kiem'],
            ['id'=> 5, 'link' =>'/collections/thiet-bi-phu-kien-mln-dien-giai'],
            ['id'=> 1, 'link' =>'/collections/may-loc-nuoc'],
            ['id'=> 5, 'link' =>'/collections/bo-loc-dau-nguon-loi-loc'],
        ];

        foreach ($catCraw as $val){
            echo('category:'. $val['link']).PHP_EOL;
            $this->crawlPosts($site, $val['link'], $val['id']);
            $this->getDomUrl($site.$val['link'])->filter('body .pagination-custom .page')
            ->each(function (Crawler $node) use ($site, $val){
                if($node->filter('a')->count()){
                    $link = $node->filter('a')->attr('href');
                    echo('category paging:'. $link).PHP_EOL;
                    $this->crawlPosts($site, $link, $val['id']);
                };
            });
        }

        /*$this->getDomUrl($site)->filter('body .menu-child__list .item')->each(function (Crawler $node) use ($site){
            $link = $node->filter('a')->attr('href');
            echo('category:'. $link).PHP_EOL;
            $this->crawlPosts($site, $link,1);
            $this->getDomUrl($site.$link)->filter('body .pagination-custom .page')
                ->each(function (Crawler $node) use ($site){
                if($node->filter('a')->count()){
                    $link = $node->filter('a')->attr('href');
                    echo('category paging:'. $link).PHP_EOL;
                    $this->crawlPosts($site, $link,1);
                };
            });
        });*/
    }

    public function crawlPosts($site, $uri, $catID):? array
    {
        if(substr($uri, 0, 1) === '/'){
            $this->getDomUrl($site.$uri)->filter('body .product-list__content .item')->each(function (Crawler $node) use ($site, $catID){
                $link = $node->filter('a')->attr('href');
                echo('post:'.$link).PHP_EOL;
                $this->crawlPost($site, $link, $catID);
            });;
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
            if($image->media_type == 'image'){
                $contents = file_get_contents($image->src);
                $name = substr($image->src, strrpos($image->src, '/') + 1);
                Storage::disk('local')->put('vanloiphat/'.$name, $contents);
                Storage::disk('local')->put('thumb_vanloiphat/'.$name,
                    Image::make($image->src)->orientate()->resize(null, 270, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream()
                );

                $files .= DB::table('images')->insertGetId(['uri' => '/storage/vanloiphat/'.$name, 'active' => 1]). ', ';
            }
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
        return [
            'active' => 1,
            'is_hot' => 1,
            'is_new' => 1,
            'is_promotion' => 1,
            'producer_id' => 6,
            'product_category_id' => $catID,
            'description' => $crawl->filter('body #tab_2')->count()?$crawl->filter('body #tab_2')->html():"",
            'warning' => $crawl->filter('body #tab_3')->count()?$crawl->filter('body #tab_3')->html():'',
            'certificate'=> $crawl->filter('body #tab_4')->count()?$crawl->filter('body #tab_4')->html():'',
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
        if(substr($uri, 0, 1) === '/'){
            $js = json_decode(file_get_contents($site.$uri.'.js'));
            $product = Product::where('title', $js->title)->first();
            if($product == null){
                $data = array_merge(
                    $this->crawlJS($js),
                    $this->crawlContent($site.$uri, $catID),
                );
                DB::table('products')->insertGetId($data);
            }else if($product->content == '</article>'){
                $product->content = $js->description;
                $product->save();
            }
        }
    }
}
