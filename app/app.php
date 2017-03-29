<?php
  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../src/Restaurant.php';
  require_once __DIR__.'/../src/Cuisine.php';

  session_start();
  if (empty($_SESSION[''])) {
    $_SESSION[''] = array();
  }

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server,$username,$password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use($app){
      return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
