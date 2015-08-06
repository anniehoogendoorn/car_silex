<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/car.php";

    session_start();

    if (empty($_SESSION['cars_matching_search'])) {
        $_SESSION['cars_matching_search'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('dealership_search.html.twig');

    });


      $app->get("/search_results", function() use ($app) {
      $first_car = new Car("2014 Porsche 911", 7864, 114991, "img/porsche.jpg");
      $second_car = new Car("2011 Ford F450", 14000, 55995, "img/ford.jpeg");
      $third_car = new Car("2013 Lexus RX 350", 20000, 44700, "img/lexus.jpg");
      $fourth_car = new Car("Mercedes Benz CLS550", 37979, 39900, "img/mercedes.jpg");

      $cars = array($first_car, $second_car, $third_car, $fourth_car);

      $cars_matching_search = array();
          foreach ($cars as $car) {
              if ($car->worthBuying($_GET["price"], $_GET["miles"])) {
                  array_push($cars_matching_search, $car);
              }
           }

         return $app['twig']->render('search_results.html.twig', array('cars_matching_search' => $cars_matching_search));

      });

      $app->get("/submit_car", function() use ($app) {
          
         return $app['twig']->render('submit_car.html.twig');
      });

    return $app;
?>
