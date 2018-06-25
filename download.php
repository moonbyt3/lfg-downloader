<?php
use Symfony\Component\DomCrawler\Crawler;

require_once __DIR__.'/vendor/autoload.php';

if ($argc < 2) {
	echo 'Usage: php download.php startpage endpage';
	exit;
}

$startPage = $argv[1];
$endPage = $argv[2];

if (!is_writeable(__DIR__.'/images')) {
	echo 'Images directory is not writeable!';
}

for ($i = $startPage; $i < $endPage; $i++) {

	echo $i;

	// get html
	$url = 'http://www.lfg.co/page/'.$i.'/';
	$content = file_get_contents($url);
	
	// get image url
	$crawler = new Crawler($content);
	$img = $crawler->filterXPath('//div[contains(@id, "comic-img")]/img')->attr('src');

	// download image url
	$imageContent = file_get_contents($img);
	file_put_contents('images/'.$i.'.gif', $imageContent);

	echo " done.\n";
}
