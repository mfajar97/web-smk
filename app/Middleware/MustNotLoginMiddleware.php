<?php 

namespace JustFajar\Belajar\PHP\MVC\Middleware;

use JustFajar\Belajar\PHP\MVC\App\View;
use JustFajar\Belajar\PHP\MVC\Config\Database;
use JustFajar\Belajar\PHP\MVC\Repository\SessionRepository;
use JustFajar\Belajar\PHP\MVC\Repository\UserRepository;
use JustFajar\Belajar\PHP\MVC\Service\SessionService;

class MustNotLoginMiddleware implements Middleware
{
  private SessionService $sessionService;

  public function __construct()
  {
    $sessionRepository = new SessionRepository(Database::getConnection());
    $userRepository = new UserRepository(Database::getConnection());
    $this->sessionService = new SessionService($sessionRepository, $userRepository);
  }

  function before(): void
  {
    $user = $this->sessionService->current();
    if ($user != null) {
      View::redirect('/');
    }
  }
} 

