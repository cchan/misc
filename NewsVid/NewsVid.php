<?php
//NewsVid script.


//$url = 'http://localhost/misc/getallheaders.php';
/*require 'phpQuery-onefile.php';

$url = 'https://news.google.com/';
$data = array('key1' => 'value1', 'key2' => 'value2');

//$headertext='';
//$headers=array ( 'Connection' => 'keep-alive', 'Content-Type' => 'application/x-www-form-urlencoded', 'Cache-Control' => 'max-age=0', 'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 'Accept-Encoding' => 'gzip,deflate,sdch', 'Accept-Language' => 'en-US,en;q=0.8' );
//foreach($headers as $header=>$val)$headertext.=$header.': '.$val."\r\n";

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        //'header'  => $headertext,
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$html = file_get_contents($url, false, $context);

phpQuery::newDocument($html);
echo pq('.main-content-with-gutter')->text();*/


require 'autoloader.php';
$feed = new SimplePie();
$urls = ['http://fulltextrssfeed.com/rss.cnn.com/rss/cnn_topstories.rss',
	'http://fulltextrssfeed.com/news.google.com/?output=rss',
	];
foreach($urls as $url){
	$feed->set_feed_url($url);
	$feed->init();
	foreach ($feed->get_items() as $item)
		echo $item->get_permalink().'<br>'.$item->get_date('j F Y | g:i a').' '
			.$item->get_title().': '.$item->get_description().'<br><br>';
}
?>