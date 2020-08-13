<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DOMWrap\Document;
use GuzzleHttp\Client;

use Log;

class DocumentController extends Controller
{
    /**
     * 指定したURLに存在する画像リソースを取得します。
     * @param Request $request
     * NOTE: POSTでなければリクエストにFormDataが乗ってこない
     */
    public function getRawHtml(Request $request)
    {
        $url = $request->url;
        /*
        $client = New Client();
        $response = $client->get($url);
        $html = (string) $response->getBody();
        
        $doc = new Document;
        $node = $doc->html($html);
        $test = $node->find('img')->text();

        Log::debug($node);
        */
        exec("pwd", $output);
        chdir('../_python');
        exec("python3 hello.py", $output);

        Log::debug($output);

        //return $node;

        
    }
}
