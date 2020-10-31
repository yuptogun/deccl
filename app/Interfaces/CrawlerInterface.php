<?php
namespace App\Interfaces;

/**
 * App\Service\BaseCrawler 를 상속하는 모든 크롤러는 이 인터페이스를 강제할 것
 * 
 * @author Eojin Kim <eojin1211@hanmail.net>
 */
interface CrawlerInterface
{
    public function crawl($url);
    public function isModelReady();
}