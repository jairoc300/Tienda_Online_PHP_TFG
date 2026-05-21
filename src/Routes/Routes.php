<?php
namespace Routes;

use Controllers\InicioController;
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Controllers\UsuarioController;
use Controllers\CarritoController;
use Controllers\ErrorController;
use Controllers\PedidoController;
use Controllers\EstadisticasController;
use Controllers\PagoController;
use Lib\Router;

class Routes {
    public static function index() {
        Router::añadirRuta('GET', '/', function() {
            return (new InicioController())->index();
        });

        Router::añadirRuta('GET', '/categoria/ver', function($id = null) {
            return (new CategoriaController())->ver($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/categoria/crear', function() {
            return (new CategoriaController())->crear();
        });

        Router::añadirRuta('POST', '/categoria/crear', function() {
            return (new CategoriaController())->crear();
        });

        Router::añadirRuta('GET', '/categoria/borrar', function($id = null) {
            return (new CategoriaController())->borrar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/categoria/editar', function($id = null) {
            return (new CategoriaController())->editar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('POST', '/categoria/actualizar', function() {
            return (new CategoriaController())->actualizar();
        });

        Router::añadirRuta('GET', '/categoria/gestionarCategorias', function() {
            return (new CategoriaController())->gestionarCategorias();
        });

        Router::añadirRuta('GET', '/admin/estadisticas', function() {
            return (new EstadisticasController())->index();
        });

        Router::añadirRuta('GET', '/producto/verDetalles', function($id = null) {
            return (new ProductoController())->verDetalles($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/producto/crear', function() {
            return (new ProductoController())->crear();
        });

        Router::añadirRuta('POST', '/producto/crear', function() {
            return (new ProductoController())->crear();
        });

        Router::añadirRuta('GET', '/producto/borrar', function($id = null) {
            return (new ProductoController())->borrar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/producto/editar', function($id = null) {
            return (new ProductoController())->editar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('POST', '/producto/editar', function() {
            return (new ProductoController())->editar();
        });

        Router::añadirRuta('GET', '/producto/gestionarProductos', function() {
            return (new ProductoController())->gestionarProductos();
        });

        Router::añadirRuta('GET', '/carrito/agregarProducto', function($id = null) {
            return (new CarritoController())->agregarProducto($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/carrito/obtenerCarrito', function() {
            return (new CarritoController())->obtenerCarrito();
        });

        Router::añadirRuta('GET', '/carrito/eliminarProducto', function($id = null) {
            return (new CarritoController())->eliminarProducto($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/carrito/aumentarCantidad', function($id = null) {
            return (new CarritoController())->aumentarCantidad($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/carrito/disminuirCantidad', function($id = null) {
            return (new CarritoController())->disminuirCantidad($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::añadirRuta('GET', '/pedido/mostrarPedido', function() {
            return (new PedidoController())->mostrarPedido();
        }); 

        Router::añadirRuta('GET', '/pedido/misPedidos', function() {
            return (new PedidoController())->misPedidos();
        });

        Router::añadirRuta('GET', '/pedido/todosLosPedidos', function() {
            return (new PedidoController())->todosLosPedidos();
        });

        Router::añadirRuta('GET', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::añadirRuta('POST', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::añadirRuta('GET', '/pedido/confirmarPedido', function($id = null) {
            return (new PedidoController())->confirmarPedido($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/pedido/eliminar', function($id = null) {
            return (new PedidoController())->eliminar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/pedido/editar', function($id = null) {
            return (new PedidoController())->editar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/pedido/actualizar', function() {
            return (new PedidoController())->actualizar();
        });

        Router::añadirRuta('POST', '/pedido/actualizar', function() {
            return (new PedidoController())->actualizar();
        });

        // RUTAS DE PAGO
        Router::añadirRuta('GET', '/pago/procesarPago', function($id = null) {
            return (new PagoController())->procesarPago();
        });

        Router::añadirRuta('POST', '/pago/efectuarPago', function() {
            return (new PagoController())->efectuarPago();
        });

        Router::añadirRuta('GET', '/pago/confirmacionPago', function($id = null) {
            return (new PagoController())->confirmacionPago();
        });

        Router::añadirRuta('POST', '/pago/actualizarDireccion', function() {
            return (new PagoController())->actualizarDireccion();
        });

        Router::añadirRuta('GET', '/usuario/login', function() {
            return (new UsuarioController())->login();
        });   

        Router::añadirRuta('POST', '/usuario/login', function() {
            return (new UsuarioController())->login();
        });

        Router::añadirRuta('POST', '/usuario/registro', function() {
            return (new UsuarioController())->registro();
        });

        Router::añadirRuta('GET', '/usuario/registro', function() {
            return (new UsuarioController())->registro();
        });

        Router::añadirRuta('GET', '/usuario/verTodos', function() {
            return (new UsuarioController())->verTodos();
        });

        Router::añadirRuta('GET', '/usuario/logout', function() {
            return (new UsuarioController())->logout();
        });

        Router::añadirRuta('GET', '/usuario/eliminar', function($id = null) {
            return (new UsuarioController())->eliminar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('GET', '/usuario/editar', function($id = null) {
            return (new UsuarioController())->editar($_GET['id'] ?? $id);
        });

        Router::añadirRuta('POST', '/usuario/actualizar', function() {
            return (new UsuarioController())->actualizar();
        });

        Router::añadirRuta('GET', '/error', function() {
            return (new ErrorController())->error404();
        });

        Router::dispatch();
    }
}