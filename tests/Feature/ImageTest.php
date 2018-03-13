<?php

namespace Tests\Feature;

use Tests\TestCase;

class ImageTest extends TestCase
{
    public function test_it_can_retrieve_a_png_image()
    {
        $response = $this->get('/test/test.png');

        $this->assertTrue($response->isOk());
        $this->assertEquals('image/png', $response->getHeaderLine('Content-Type'));
    }

    public function test_it_can_retrieve_a_jpg_image()
    {
        $response = $this->get('/test/test.jpg');

        $this->assertTrue($response->isOk());
        $this->assertEquals('image/jpeg', $response->getHeaderLine('Content-Type'));
    }

    public function test_it_can_retrieve_a_jpeg_image()
    {
        $response = $this->get('/test/test.jpeg');

        $this->assertTrue($response->isOk());
        $this->assertEquals('image/jpeg', $response->getHeaderLine('Content-Type'));
    }

    public function test_it_returns_a_404_when_trying_to_retrieve_an_invalid_image()
    {
        $response = $this->get('/test/test.txt');

        $this->assertFalse($response->isOk());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_it_can_cache_an_image()
    {
        $this->configureApp(['settings' => ['cache' => ['enabled' => true]]]);

        $response = $this->get('/test/test.png');

        $this->assertTrue($response->isOk());
        $this->assertEquals('image/png', $response->getHeaderLine('Content-Type'));

        $this->assertFileExists(__DIR__ . '/../files/cache/218250c649285dba72768c67e0492776babb91a9.cache.php');

        $cachedResponse = $this->get('/test/test.png');

        $this->assertTrue($cachedResponse->isOk());
        $this->assertEquals('image/png', $cachedResponse->getHeaderLine('Content-Type'));

        $cache = $this->app->getContainer()->cache;
        $cache->flush();
    }
}
