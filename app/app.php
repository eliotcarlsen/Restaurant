<?php
  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../src/Restaurant.php';
  require_once __DIR__.'/../src/Cuisine.php';

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

    $app->post("/addrestaurant", function() use($app){
      $test_cuisine = new Cuisine($_POST['typeofrestaurant']);
      $test_cuisine->save();
      $cuisine_id = $test_cuisine->getId();
      $cuisines = Cuisine::getAll();
      $new_restaurant = new Restaurant($_POST['nameofrestaurant'],$_POST['location'], $cuisine_id);
      $new_restaurant->save();
      return $app['twig']->render('restaurant.html.twig', array ('restaurants'=> Restaurant::getAll()));
    });

    $app->get("/restaurantinfo/{id}", function($id) use($app){
      $restaurant = Restaurant::find($id);
      $found_cuisines = $restaurant->findCuisines();
      return $app['twig']->render('restaurantinfo.html.twig', array ('restaurant'=>$restaurant, 'id'=>$id, 'cuisine'=>$found_cuisines));
    });

    return $app;
?>
