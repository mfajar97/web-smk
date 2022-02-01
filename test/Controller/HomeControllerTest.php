<?php 
namespace JustFajar\Belajar\PHP\MVC\Controller;

use JustFajar\Belajar\PHP\MVC\Config\Database;
use JustFajar\Belajar\PHP\MVC\Domain\Session;
use JustFajar\Belajar\PHP\MVC\Domain\User;
use JustFajar\Belajar\PHP\MVC\Repository\SessionRepository;
use JustFajar\Belajar\PHP\MVC\Repository\UserRepository;
use JustFajar\Belajar\PHP\MVC\Service\SessionService;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
  private HomeController $homeController;
  private UserRepository $userRepository;
  private SessionRepository $sessionRepository;

  protected function setup():void
  {
    $this->homeController = new HomeController();
    $this->sessionRepository = new SessionRepository(Database::getConnection());
    $this->userRepository = new UserRepository(Database::getConnection());

    $this->sessionRepository->deleteAll();
    $this->userRepository->deleteAll();
  }

  public function testGuest()
  {
    $this->homeController->index();

    $this->expectOutputRegex("[Login Management]");
  }

  public function testUserLogin()
  {
    $user = new User();
    $user->id = "eko";
    $user->name = "Eko";
    $user->password = "rahasia";
    $this->userRepository->save($user);

    $session = new Session();
    $session->id = uniqid();
    $session->userId = $user->id;
    $this->sessionRepository->save($session);

    $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

    $this->homeController->index();

    $this->expectOutputRegex("[Hello Eko]");   
  }
}