<?php
namespace Lib;

/**
 * Clase Router para gestionar rutas y llamadas a controladores.
 */
class Router {

    /**
     * Array para almacenar las rutas configuradas.
     * 
     * @var array
     */
    private static $routes = [];

    /**
     * Añade una ruta al router.
     * 
     * @param string $method Método HTTP para la ruta.
     * @param string $action URI asociada a la acción.
     * @param callable $controller Controlador que se ejecutará.
     */
    public static function añadirRuta(string $method, string $action, callable $controller): void {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    /**
     * Despacha la URI actual a los controladores correspondientes.
     */
    public static function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = preg_replace('/tienda_online_php/', '', $_SERVER['REQUEST_URI']);
        
        // Remueve query strings (todo después de ?)
        if (strpos($action, '?') !== false) {
            $action = substr($action, 0, strpos($action, '?'));
        }
        
        $action = trim($action, '/');

        // Extrae el parámetro ID si existe en la URI.
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);

        if (!empty($match)) {
            $param = $match[0];
            $action = preg_replace('/' . preg_quote($match[0], '/') . '$/', ':id', $action);
        }

        // Intenta ejecutar la función asociada con la ruta y método.
        if (isset(self::$routes[$method][$action])) {
            $callback = self::$routes[$method][$action];
            echo call_user_func($callback, $param);
        } else {
            // Redirecciona a una página de error si la ruta no existe.
            header('Location: ' . BASE_URL . 'error');
            exit;
        }
    }
}
