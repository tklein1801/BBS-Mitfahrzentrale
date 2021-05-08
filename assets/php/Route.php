<?php
require_once  get_defined_constants()['BASEPATH'] . "assets/php/ApiLogger.php";

use DulliAG\System\ApiLogger;

class Route 
{
  private static $routes = Array();
  private static $pathNotFound = null;
  private static $methodNotAllowed = null;

  public static function add($expression, $function, $method = 'GET') 
  {
    array_push(self::$routes,Array(
      'expression' => $expression,
      'function' => $function,
      'method' => $method
    ));
  }

  public static function getAll() 
  {
    return self::$routes;
  }

  public static function pathNotFound($function)
  {
    self::$pathNotFound = $function;
  }

  public static function methodNotAllowed($function)
  {
    self::$methodNotAllowed = $function;
  }

  public static function run($basepath = '/')
  {
    $logger = new ApiLogger();
    // Parse current url
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

    if (isset($parsed_url['path'])) {
      $path = $parsed_url['path'];
    } else {
      $path = '/';
    }

    // Get current request method
    $method = $_SERVER['REQUEST_METHOD'];

    $path_match_found = false;

    $route_match_found = false;

    foreach (self::$routes as $route) {
      // If the method matches check the path

      // Add basepath to matching string
      if ($basepath != '' && $basepath != '/') {
        $route['expression'] = '('.$basepath.')'.$route['expression'];
      }

      // Add 'find string start' automatically
      $route['expression'] = '^'.$route['expression'];

      // Add 'find string end' automatically
      $route['expression'] = $route['expression'].'$';

      // echo $route['expression'].'<br/>';

      // Check path match	
      if (preg_match('#'.$route['expression'].'#', $path, $matches)) {
        $path_match_found = true;

        // Check method match
        if (strtolower($method) == strtolower($route['method'])) {
          array_shift($matches);// Always remove first element. This contains the whole string

          if ($basepath != '' && $basepath != '/') {
            array_shift($matches);// Remove basepath
          }

          call_user_func_array($route['function'], $matches);

          $route_match_found = true;

          // Do not check other routes
          break;
        }
      }
    }

    // Check if the requested path is an RestAPI-endpoint but not the api-documentation website 
    // If the path contains the word api & have more than 4 characters it should be an real endpoint
    // $isAnApiRoute = str_contains($parsed_url['path'], "api") && $parsed_url['path'] !== "/api"; Only works on PHP 8.0+
    $isAnApiRoute = strlen($parsed_url['path']) > 4 && substr($parsed_url['path'], 1, 3) == "api";
    // No matching route was found
    if (!$route_match_found) {
      // But a matching path exists
      if ($path_match_found) {
        header("HTTP/1.0 405 Method Not Allowed");
        if($isAnApiRoute) {
          $logger->createLog($parsed_url['path']);
        }
        if (self::$methodNotAllowed) {
          call_user_func_array(self::$methodNotAllowed, Array($path,$method));
        }
      } else {
        header("HTTP/1.0 404 Not Found");
        if($isAnApiRoute) {
          $logger->createLog($parsed_url['path']);
        }       
        if (self::$pathNotFound) {
          call_user_func_array(self::$pathNotFound, Array($path));
        }
      }
    }
    
    if ($isAnApiRoute) {
      $logger->createLog($parsed_url['path']);
    } 
  }
}