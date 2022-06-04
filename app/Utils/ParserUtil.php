<?php


namespace App\Utils;

use App\Modules\ParserResults\Models\ParserResult;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\String\length;
use function Symfony\Component\String\splice;

class ParserUtil
{
    private $parser;
    private $results = [];

    public function __construct($parser)
    {
        $this->parser = $parser;
    }

    public function start() {
        for ($i = 2; $i < 101; $i++) {
            $html = $this->getHtml($this->parser->url . '/?page=' . $i);
            $crawler = new Crawler($html);

            $crawler->filter($this->parser->selector)->each(function (Crawler $node) {

                $filtered = $node->filter($this->parser->search_link_selector);

                if ($filtered->count()) {
                    $direct_url = $filtered->attr('href');
                    if ($direct_url[0] == '/') {
                        $direct_url = $this->parser->url . $direct_url;
                    }
                    $direct_url_splice = explode('/', $direct_url);


                    if (ParserResult::where('url', $direct_url)->count() == 0 and
                        array_key_exists(3, $direct_url_splice) and $direct_url_splice[3] == "currencies" and
                        !(array_key_exists(5, $direct_url_splice) and $direct_url_splice[5])) {

                        $direct_html = $this->getHtml($direct_url);
                        $direct_crawler = new Crawler($direct_html);

                        $result['url'] = $direct_url;
                        $result['targets_result'] = [];
                        $result['internal_links'] = [];
                        $result['images'] = [];
                        $result['other'] = [];

                        foreach ($this->parser->targets as $target_id => $target) {
                            if ($direct_crawler->filter($target['selector'])->count()) {
                                $result['targets_result'][] = $direct_crawler->filter($target['selector'])->text();
                            } else {
                                $result['targets_result'][] = '';
                            }
                        }

                        $direct_crawler->filter('.statsBlockInner')->each(function (Crawler $node, $i) use (&$result, $direct_url) {
                            if ($i < 3) {
                                $span = $node->filter('.chbrcp')->getNode(0);
                                if ($span) $span->parentNode->removeChild($span);
                                $exploded = explode('$', $node->text());
                                if (array_key_exists(1, $exploded)) {
                                    $result['targets_result'][] = (int)str_replace(',', '', $exploded[1]);
                                } else {
                                    $result['targets_result'][] = '';
                                }
                            }
                        });

                        if ($this->parser->img_selector) {
                            $result['images'] = $direct_crawler->filter($this->parser->img_selector)->each(function (Crawler $node, $i) {
                                return $node->image()->getUri();
                            });
                        }

                        if ($this->parser->internal_link_selector) {
                            $result['internal_links'] = $direct_crawler->filter($this->parser->internal_link_selector)->each(function (Crawler $node, $i) {
                                return ["href" => $node->attr('href'), "text" => $node->text()];
                            });
                        }
                        $this->results[] = $result;
                    }
                }


            });
        }
    }

    //Переопределение этого метода в случае использования обхода защиты от парсинга
    public function getHtml($url)
    {

//        return Http::withOptions([
//            'proxy' => '37.139.243.32:1080'
//        ])->get($url)->body();
        return Http::get($url)->body();
    }

    public function saveResults()
    {
        if ($this->results) {
            foreach ($this->results as $result) {
                $hash = md5(json_encode($result['targets_result']));

                //Проверка на наличие этого результата в БД, если есть не сохраняем
                if (!ParserResult::where('result_hash', $hash)->count() and !ParserResult::where('url', $result['url'])->count()) {
                    ParserResult::create([
                        'parser_id' => $this->parser->id,
                        'url' => $result['url'],
                        'targets_result' => $result['targets_result'],
                        'images' => $result['images'],
                        'internal_links' => $result['internal_links'],
                        'result_hash' => $hash,
                    ]);
                }
            }
            return "Результаты сохранены";
        } else {
            return "Результатов по данным парсера не обнаруженно";
        }
    }
}
