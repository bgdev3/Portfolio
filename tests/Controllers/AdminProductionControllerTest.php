<?php
namespace Portfolio\Tests\Controllers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Portfolio\Controllers\AdminProductionController;
use Portfolio\Entities\Production;
use Portfolio\Entities\Template;
use Portfolio\Models\ProductionModel;
use Portfolio\Models\TemplateModel;
use Portfolio\Services\Form;
use Portfolio\Services\ImageGenerate;

class AdminProductionControllerTest extends TestCase
{
    private AdminProductionController&MockObject $controller;
    private Form&MockObject $formMock;
    private TemplateModel&MockObject $templateModelMock;
    private ProductionModel&MockObject $productionModelMock;
    private ImageGenerate&MockObject $imageMock;
    private Template $template;
    private Production $production;

    /** Champs fichier du formulaire d'ajout */
    private const FILE_FIELDS = ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4'];

    protected function setUp(): void
    {
        $this->formMock            = $this->createMock(Form::class);
        $this->templateModelMock   = $this->createMock(TemplateModel::class);
        $this->productionModelMock = $this->createMock(ProductionModel::class);
        $this->imageMock           = $this->createMock(ImageGenerate::class);
        $this->template            = new Template();
        $this->production          = new Production();

        // On mocke uniquement render() (charge une vue)
        // L'ordre des arguments doit être celui du constructeur du contrôleur
        $this->controller = $this->getMockBuilder(AdminProductionController::class)
            ->setConstructorArgs([
                $this->formMock,
                $this->templateModelMock,
                $this->productionModelMock,
                $this->template,
                $this->production,
                $this->imageMock,
            ])
            ->onlyMethods(['render'])
            ->getMock();

        // Superglobales propres avant chaque test
        $_SESSION = [];
        $_POST    = [];
        $_FILES   = [];
        $_GET     = [];
    }

    // =========================================================
    // index()
    // =========================================================

    public function testIndexCallsFindAllAndRendersList(): void
    {
        $this->productionModelMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/index', ['list' => []]);

        $this->controller->index();
    }

    // =========================================================
    // add()
    // =========================================================

    public function testAddWithEmptyPostRendersNoError(): void
    {
        $this->formMock->method('validatePost')->willReturn(false);
        $this->formMock->method('validateFiles')->willReturn(false);

        $this->productionModelMock->expects($this->never())->method('create');

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/add', ['error' => '']);

        $this->controller->add('token_test');
    }

    public function testAddWithInvalidFieldsRendersError(): void
    {
        $_POST = ['title' => 'Incomplet'];

        $this->formMock->method('validatePost')->willReturn(false);
        $this->formMock->method('validateFiles')->willReturn(true);

        $this->productionModelMock->expects($this->never())->method('create');

        // On vérifie qu'un message est affiché, sans figer son texte
        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with(
                'admin/productions/add',
                $this->callback(fn (array $data): bool => $data['error'] !== '')
            );

        $this->controller->add('token_test');
    }

    public function testAddWithUploadErrorDoesNotCreate(): void
    {
        $_SESSION['token'] = 'abc';
        $_POST['token']    = 'abc';

        $this->prepareValidUpload('Le fichier est trop volumineux !');

        $this->imageMock->expects($this->never())->method('imageSize');
        $this->productionModelMock->expects($this->never())->method('create');

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/add', ['error' => 'Le fichier est trop volumineux !']);

        $this->controller->add('token_test');
    }

    public function testAddStopsWhenImageResizeFails(): void
    {
        $_SESSION['token'] = 'abc';
        $_POST['token']    = 'abc';

        $this->prepareValidUpload();

        // imageSize() renvoie '' et stocke son erreur en session
        $this->imageMock
            ->expects($this->once())
            ->method('imageSize')
            ->willReturnCallback(function (): string {
                $_SESSION['error'] = 'Format non supporté';
                return '';
            });

        $this->productionModelMock->expects($this->never())->method('create');
        $this->templateModelMock->expects($this->never())->method('create');

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/add', ['error' => 'Format non supporté']);

        $this->controller->add('token_test');
    }

    public function testAddWithValidDataCallsCreate(): void
    {
        $_SESSION['token']    = 'abc';
        $_SESSION['id_admin'] = 1;
        $_POST = [
            'token'       => 'abc',
            'title'       => 'Mon projet',
            'url'         => 'https://monprojet.fr',
            'description' => 'Description',
            'createdAt'   => '2024-01-01',
            'comment'     => 'Un commentaire',
            'php'         => '1',
            'boot'        => '1',
        ];

        $this->prepareValidUpload();

        $this->imageMock
            ->expects($this->exactly(5))
            ->method('imageSize')
            ->willReturn('img/fake-image.webp');

        $this->productionModelMock
            ->expects($this->once())
            ->method('create')
            ->with($this->identicalTo($this->production));

        $this->productionModelMock
            ->expects($this->once())
            ->method('findLast')
            ->willReturn((object) ['idProduction' => 5]);

        $this->templateModelMock
            ->expects($this->once())
            ->method('create')
            ->with($this->identicalTo($this->template));

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/add', ['error' => '']);

        $this->controller->add('token_test');

        // L'entité a bien été hydratée à partir du POST
        $this->assertSame('Mon projet', $this->production->getTitle());
        $this->assertSame('https://monprojet.fr', $this->production->getUrl());
        $this->assertSame('img/fake-image.webp', $this->production->getPath());
        $this->assertSame(1, $this->production->getIdUser());
        $this->assertSame('1', $this->production->getPhp());
        $this->assertSame('1', $this->production->getBootstrap());
        $this->assertNull($this->production->getSass());
        $this->assertNull($this->production->getDocker());
    }

    // =========================================================
    // delete()
    // =========================================================

    public function testDeleteWithWrongTokenDoesNotDelete(): void
    {
        $_SESSION['token'] = 'abc';
        $_GET['token']     = 'autre';
        $_POST['yes']      = '1';

        $this->productionModelMock->expects($this->never())->method('delete');

        // Sans token valide, on retombe sur la page de confirmation
        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/confirmDelete');

        $this->controller->delete(3, 'abc');
    }

    public function testDeleteWithoutAnswerRendersConfirmation(): void
    {
        $_SESSION['token'] = 'abc';
        $_GET['token']     = 'abc';

        $this->productionModelMock->expects($this->never())->method('delete');

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('admin/productions/confirmDelete');

        $this->controller->delete(3, 'abc');
    }

    // =========================================================
    // Helper
    // =========================================================

    /**
     * Prépare un envoi de formulaire d'ajout valide :
     * champs et fichiers acceptés, 5 noms de fichiers formatés, $_FILES rempli.
     *
     * @param string $uploadError Message renvoyé par Form::errorUpload ('' = aucune erreur)
     */
    private function prepareValidUpload(string $uploadError = ''): void
    {
        $this->formMock->method('validatePost')->willReturn(true);
        $this->formMock->method('validateFiles')->willReturn(true);
        $this->formMock->method('errorUpload')->willReturn($uploadError);
        $this->formMock->method('formateFileAdmin')->willReturn([
            'img1.webp', 'img2.webp', 'img3.webp', 'img4.webp', 'img5.webp',
        ]);

        // Le contrôleur lit $_FILES[$champ]['tmp_name'] pour chaque fichier
        $_FILES = [];
        foreach (self::FILE_FIELDS as $field) {
            $_FILES[$field] = [
                'name'     => $field . '.png',
                'tmp_name' => '/tmp/fake-' . $field,
                'error'    => 0,
                'size'     => 1024,
            ];
        }
    }
}
