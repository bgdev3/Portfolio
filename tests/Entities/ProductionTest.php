<?php

namespace Portfolio\Tests\Entities;

use PHPUnit\Framework\TestCase;
use Portfolio\Entities\Production;

class ProductionTest extends TestCase
{
    private Production $production;

    protected function setUp(): void
    {
        $this->production = new Production();
    }

    // --- Getters/Setters de base ---

    public function testSetAndGetTitle(): void
    {
        $this->production->setTitle('Mon projet');
        $this->assertSame('Mon projet', $this->production->getTitle());
    }

    public function testSetAndGetUrl(): void
    {
        $this->production->setUrl('https://monprojet.fr');
        $this->assertSame('https://monprojet.fr', $this->production->getUrl());
    }

    public function testSetAndGetDescription(): void
    {
        $this->production->setDescription('Une description');
        $this->assertSame('Une description', $this->production->getDescription());
    }

    public function testSetAndGetPath(): void
    {
        $this->production->setPath('uploads/image.jpg');
        $this->assertSame('uploads/image.jpg', $this->production->getPath());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $this->production->setCreatedAt('2024-01-01');
        $this->assertSame('2024-01-01', $this->production->getCreatedAt());
    }

    public function testSetAndGetIdUser(): void
    {
        $this->production->setIdUser(42);
        $this->assertSame(42, $this->production->getIdUser());
    }

    // --- Stack technique (nullable) ---

    public function testStackTechDefaultsToNull(): void
    {
        $this->assertNull($this->production->getHtml());
        $this->assertNull($this->production->getSass());
        $this->assertNull($this->production->getBootstrap());
        $this->assertNull($this->production->getJs());
        $this->assertNull($this->production->getPhp());
        $this->assertNull($this->production->getSymfony());
        $this->assertNull($this->production->getReact());
        $this->assertNull($this->production->getWordpress());
    }

    public function testSetAndGetHtml(): void
    {
        $this->production->setHtml('1');
        $this->assertSame('1', $this->production->getHtml());
    }

    public function testSetAndGetSymfony(): void
    {
        $this->production->setSymfony('1');
        $this->assertSame('1', $this->production->getSymfony());
    }

    // --- Fluent interface (chaining) ---

    public function testSettersReturnSelf(): void
    {
        $result = $this->production
            ->setTitle('Test')
            ->setUrl('https://test.fr')
            ->setDescription('Desc')
            ->setPath('img.jpg')
            ->setCreatedAt('2024-01-01');

        $this->assertInstanceOf(Production::class, $result);
    }

    // --- Bug détecté : getUrl() retourne $this->title au lieu de $this->url ---

    public function testUrlIsIndependentFromTitle(): void
    {
        $this->production->setTitle('Mon titre');
        $this->production->setUrl('https://monprojet.fr');

        // Ce test ÉCHOUE avec le code actuel → bug confirmé
        $this->assertSame('https://monprojet.fr', $this->production->getUrl());
        $this->assertSame('Mon titre', $this->production->getTitle());
    }
}