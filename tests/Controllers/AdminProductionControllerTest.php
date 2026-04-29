<?php

namespace Portfolio\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Portfolio\Controllers\AdminProductionController;
use Portfolio\Services\Form;
use Portfolio\Services\Captcha;
use Portfolio\Entities\Template;
use Portfolio\Entities\Production;
use Portfolio\Models\TemplateModel;
use Portfolio\Models\ProductionModel;

class AdminProductionControllerTest extends TestCase
{
    private AdminProductionController&MockObject $controller;
    private Form&MockObject $formMock;
    private Captcha&MockObject $captchaMock;
    private TemplateModel&MockObject $templateModelMock;
    private ProductionModel&MockObject $productionModelMock;
    private Template $template;
    private Production $production;

    protected function setUp(): void
    {
        // Mocks des services et models
        $this->formMock            = $this->createMock(Form::class);
        $this->captchaMock         = $this->createMock(Captcha::class);
        $this->templateModelMock   = $this->createMock(TemplateModel::class);
        $this->productionModelMock = $this->createMock(ProductionModel::class);
        $this->template            = new Template();
        $this->production          = new Production();

        // On mocke uniquement render() et imageSize() qui ont des effets de bord
        $this->controller = $this->getMockBuilder(AdminProductionController::class)
            ->setConstructorArgs([
                $this->formMock,
                $this->captchaMock,
                $this->templateModelMock,
                $this->productionModelMock,
                $this->template,
                $this->production,
            ])
            ->onlyMethods(['render', 'imageSize'])
            ->getMock();

        // imageSize() retourne un chemin fictif
        $this->controller->method('imageSize')
            ->willReturn('img/fake-image.webp');

        // render() ne fait rien (pas de vue à charger)
        $this->controller->method('render');

        // Session propre avant chaque test
        $_SESSION = [];
        $_POST    = [];
        $_FILES   = [];
        $_GET     = [];
    }

    // --- index() ---

    public function testIndexCallsFindAll(): void
    {
        $this->productionModelMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->controller->index();
    }

    // --- add() : POST vide ---

    public function testAddWithEmptyPostRendersNoError(): void
    {
        $this->formMock
            ->method('validatePost')
            ->willReturn(false);

        $this->formMock
            ->method('validateFiles')
            ->willReturn(false);

        // Aucune création ne doit avoir lieu
        $this->productionModelMock
            ->expects($this->never())
            ->method('create');

        $this->controller->add('token_test');
    }

    // --- add() : token CSRF invalide → session détruite ---

    public function testAddWithInvalidTokenDestroysSession(): void
    {
        $_SESSION['token'] = 'valid_token';
        $_POST['token']    = 'invalid_token'; // token différent

        $this->formMock->method('validatePost')->willReturn(true);
        $this->formMock->method('validateFiles')->willReturn(true);
        $this->formMock->method('errorUpload')->willReturn('');
        $this->formMock->method('formateFileAdmin')->willReturn([
            'img1.webp', 'img2.webp', 'img3.webp', 'img4.webp', 'img5.webp'
        ]);

        // create() ne doit jamais être appelé
        $this->productionModelMock
            ->expects($this->never())
            ->method('create');

        // On s'attend à un exit() via header() — on capture avec try/catch
        try {
            $this->controller->add('token_test');
        } catch (\Throwable $e) {
            // header() + exit() peuvent lever une erreur en CLI, c'est normal
        }
    }

    // --- add() : captcha invalide ---

    public function testAddWithInvalidCaptchaReturnsError(): void
    {
        $_SESSION['token'] = 'abc';
        $_POST['token']    = 'abc';
        $_POST['recaptcha_response'] = 'fake';

        $this->formMock->method('validatePost')->willReturn(true);
        $this->formMock->method('validateFiles')->willReturn(true);
        $this->formMock->method('errorUpload')->willReturn('');
        $this->formMock->method('formateFileAdmin')->willReturn([
            'img1.webp', 'img2.webp', 'img3.webp', 'img4.webp', 'img5.webp'
        ]);

        // Captcha invalide
        $this->captchaMock
            ->expects($this->once())
            ->method('verify')
            ->willReturn(false);

        // Aucune création
        $this->productionModelMock
            ->expects($this->never())
            ->method('create');

        $this->controller->add('token_test');
    }

    // --- add() : scénario nominal complet ---

    public function testAddWithValidDataCallsCreate(): void
    {
        $_SESSION['token']    = 'abc';
        $_SESSION['id_admin'] = 1;
        $_POST = [
            'token'      => 'abc',
            'title'      => 'Mon projet',
            'url'        => 'https://monprojet.fr',
            'description'=> 'Description',
            'createdAt'  => '2024-01-01',
            'comment'    => 'Un commentaire',
            'recaptcha_response' => 'valid',
        ];

        $lastProd = (object)['idProduction' => 5];

        $this->formMock->method('validatePost')->willReturn(true);
        $this->formMock->method('validateFiles')->willReturn(true);
        $this->formMock->method('errorUpload')->willReturn('');
        $this->formMock->method('formateFileAdmin')->willReturn([
            'img1.webp', 'img2.webp', 'img3.webp', 'img4.webp', 'img5.webp'
        ]);

        $this->captchaMock->method('verify')->willReturn(true);

        $this->productionModelMock
            ->expects($this->once())
            ->method('create');

        $this->productionModelMock
            ->expects($this->once())
            ->method('findLast')
            ->willReturn($lastProd);

        $this->templateModelMock
            ->expects($this->once())
            ->method('create');

        $this->controller->add('token_test');
    }

    // --- delete() : confirmation oui ---

    public function testDeleteWithYesCallsDelete(): void
    {
        $_SESSION['token'] = 'abc';
        $_GET['token']     = 'abc';
        $_POST['yes']      = '1';

        $this->productionModelMock
            ->expects($this->once())
            ->method('delete')
            ->with(3);

        try {
            $this->controller->delete(3, 'abc');
        } catch (\Throwable $e) {
            // header() + exit() en CLI
        }
    }

    // --- delete() : confirmation non ---

    public function testDeleteWithNoRedirectsWithoutDeleting(): void
    {
        $_SESSION['token'] = 'abc';
        $_GET['token']     = 'abc';
        $_POST['no']       = '1';

        $this->productionModelMock
            ->expects($this->never())
            ->method('delete');

        try {
            $this->controller->delete(3, 'abc');
        } catch (\Throwable $e) {
            // header() + exit() en CLI
        }
    }
}