<?php

namespace Portfolio\Tests\Models;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Portfolio\Models\ProductionModel;
use Portfolio\Entities\Production;
use PDO;
use PDOStatement;

class ProductionModelTest extends TestCase
{
    private ProductionModel $model;
    private PDO&MockObject $pdoMock;
    private PDOStatement&MockObject $stmtMock;

    protected function setUp(): void
    {
        // Mock PDO et PDOStatement — jamais de vraie BDD
        $this->pdoMock  = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);

        // Instancie le model SANS appeler le constructeur de DbConnect
        $this->model = $this->getMockBuilder(ProductionModel::class)
            ->disableOriginalConstructor()
            ->onlyMethods([]) // on ne mocke aucune méthode du model
            ->getMock();

        // Injecte le PDO mocké dans la propriété protégée
        $reflection = new \ReflectionClass($this->model);
        $prop = $reflection->getProperty('connexion');
        // $prop->setAccessible(true);
        $prop->setValue($this->model, $this->pdoMock);
    }

    // --- create() ---

    public function testCreatePreparesAndExecutesQuery(): void
    {
        $production = $this->makeProduction();

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('INSERT INTO production'))
            ->willReturn($this->stmtMock);

        $this->stmtMock
            ->expects($this->exactly(14))
            ->method('bindValue');

        $this->stmtMock
            ->expects($this->once())
            ->method('execute');

        $this->model->create($production);
    }

    // --- findAll() ---

    public function testFindAllReturnsArray(): void
    {
        $rows = [
            (object)['idProduction' => 1, 'title' => 'Projet A'],
            (object)['idProduction' => 2, 'title' => 'Projet B'],
        ];

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->stmtMock);

        $this->stmtMock->method('execute');

        $this->stmtMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($rows);

        $result = $this->model->findAll();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame('Projet A', $result[0]->title);
    }

    // --- find() ---

    public function testFindReturnsObject(): void
    {
        $row = (object)['idProduction' => 1, 'title' => 'Projet A'];

        $this->pdoMock
            ->method('prepare')
            ->willReturn($this->stmtMock);

        $this->stmtMock->method('bindParam');
        $this->stmtMock->method('execute');

        $this->stmtMock
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($row);

        $result = $this->model->find(1);

        $this->assertIsObject($result);
        $this->assertSame(1, $result->idProduction);
    }

    // --- findLast() ---

    public function testFindLastReturnsLastObject(): void
    {
        $row = (object)['idProduction' => 5, 'title' => 'Dernier projet'];

        $this->pdoMock
            ->method('prepare')
            ->willReturn($this->stmtMock);

        $this->stmtMock->method('execute');

        $this->stmtMock
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($row);

        $result = $this->model->findLast();

        $this->assertSame(5, $result->idProduction);
    }

    // --- delete() ---

    public function testDeletePreparesCorrectQuery(): void
    {
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('DELETE FROM production'))
            ->willReturn($this->stmtMock);

        $this->stmtMock->method('bindParam');
        $this->stmtMock->method('execute');

        $this->model->delete(1);
    }

    // --- Helper ---

    private function makeProduction(): Production
    {
        $p = new Production();
        $p->setTitle('Test projet')
          ->setUrl('https://test.fr')
          ->setDescription('Description test')
          ->setPath('img.jpg')
          ->setCreatedAt('2024-01-01')
          ->setHtml('1')
          ->setSass(null)
          ->setBootstrap(null)
          ->setJs(null)
          ->setPhp('1')
          ->setSymfony(null)
          ->setReact(null)
          ->setWordpress(null)
          ->setIdUser(1);

        return $p;
    }
}
