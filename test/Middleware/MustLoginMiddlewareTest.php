<?php 

namespace JustFajar\Belajar\PHP\MVC\Middleware {
  require_once __DIR__ . '/../Helper/helper.php';

  use JustFajar\Belajar\PHP\MVC\Config\Database;
  use JustFajar\Belajar\PHP\MVC\Domain\Session;
  use JustFajar\Belajar\PHP\MVC\Domain\User;
  use JustFajar\Belajar\PHP\MVC\Repository\SessionRepository;
  use JustFajar\Belajar\PHP\MVC\Repository\UserRepository;
  use JustFajar\Belajar\PHP\MVC\Service\SessionService;
  use PHPUnit\Framework\TestCase;
  
  class MustLoginMiddlewareTest extends TestCase
  {
    private MustLoginMiddleware $middleware;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
  
    protected function setUp(): void
    {
      $this->middleware = new MustLoginMiddleware();
      putenv("mode=test");

      $this->userRepository = new UserRepository(Database::getConnection());
      $this->sessionRepository = new SessionRepository(Database::getConnection());

      $this->sessionRepository->deleteAll();
      $this->userRepository->deleteAll();
    }
  
    public function testBeforeGuest()
    {
      $this->middleware->before();
      $this->expectOutputRegex("[Location: /users/login]");
    }

    public function testBeforeLoginUser() 
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

      $this->middleware->before();
      $this->expectOutputString("");
    }
  }
}
