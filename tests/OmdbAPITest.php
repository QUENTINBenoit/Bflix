<?php

namespace App\Tests;

use App\Service\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class OmdbAPITest extends KernelTestCase
{
    public function testFetch(): void
    {
        $kernel = self::bootKernel();
        $omdbApi = static::getContainer()->get(OmdbApi::class);


        $dataArray = $omdbApi->fetch('HPI');

        \dump($dataArray['Title']);

        $this->assertSame('HPI Haut Potentiel Intellectuel', $dataArray['Title']);
        //$routerService = static::getContainer()->get('router');
    }
}
