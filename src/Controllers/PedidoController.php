<?php

namespace Controllers;

use Repositories\PedidoRepository;
use Repositories\ProductoRepository;
use Services\ProductoService;
use Utils\Utils;
use Lib\Pages;
use Services\PedidoService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function dd(...$vars) {
    echo '<pre>';
    foreach ($vars as $var) {
        echo '<br>';
        print_r($var);
    }
    echo '</pre>';
    die();
}

/**
 * Clase PedidoController
 *
 * Esta clase maneja la lógica para las acciones relacionadas con los pedidos.
 */
class PedidoController {
    private Pages $pages;
    private PedidoService $pedidoService;
    private ProductoService $productoService; 

    /**
     * Constructor de PedidoController.
     *
     * Inicializa una nueva instancia de la clase PedidoController.
     */
    public function __construct() {
        $this->pages = new Pages();
        $this->pedidoService = new PedidoService(new PedidoRepository());
        $this->productoService = new ProductoService(new ProductoRepository());
    }

    /**
     * Obtiene todos los pedidos.
     *
     * @return array Los pedidos obtenidos.
     */
    public function mostrarPedido(){
        if(!isset($_SESSION['login'])){
            $this->pages->render('usuario/login' , ['errores' => 'No hay productos en el carrito']);
        }
        // Redirigir admin a panel de control
        else if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'admin/estadisticas/');
        }
        elseif(isset($_SESSION['login']) && count($_SESSION['carrito']) >= 1){
            $errores = [];
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['cantidad'] > $elemento['stock']) {
                    $errores[] = 'El producto <strong>' . htmlspecialchars($elemento['nombre']) . '</strong> no tiene suficiente stock. Disponible: ' . $elemento['stock'] . ' unidades.';
                }
            }
            
            if (!empty($errores)) {
                $total = $this->pedidoService->getTotalCarrito($_SESSION['carrito']);
                $this->pages->render('carrito/ver' , ['errores' => implode(' | ', $errores), 'productos' => $_SESSION['carrito'], 'total' => $total]);
                return;
            }
        
            $this->pages->render('pedido/crear');
        } elseif (isset($_SESSION['login']) && count($_SESSION['carrito']) == 0) {
            $this->pages->render('carrito/ver' , ['errores' => 'No hay productos en el carrito']);
        }
    }

    /**
     * Obtiene todos los pedidos.
     *
     * @return array Los pedidos obtenidos.
     */
    public function todosLosPedidos(){
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        else {
            $usuario = $_SESSION['login'];
            if ($usuario->rol == 'admin') {
                $pedidos = $this->pedidoService->recuperarTodosPedidos();
                $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos]);
            }
            else {
                header('Location: ' . BASE_URL . 'usuario/login');
            }
        }
    }

    /**
     * Obtiene todos los pedidos de un usuario.
     *
     * @return array Los pedidos obtenidos.
     */
    public function misPedidos(){
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        // Redirigir admin a gestión general de pedidos
        else if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'pedido/todosLosPedidos');
        }
        else {
            $usuario = $_SESSION['login'];
            $pedidos = $this->pedidoService->obtenerPedidosPorUsuario($usuario->id);
            
            // Obtener productos para cada pedido
            $productos_por_pedido = [];
            foreach ($pedidos as $pedido) {
                $productos_por_pedido[$pedido['id']] = $this->pedidoService->getProductosPedido($pedido['id']);
            }
            
            $this->pages->render('pedido/misPedidos', ['pedidos' => $pedidos, 'productos_por_pedido' => $productos_por_pedido]);
        }
    }

    /**
     * Valida los datos del pedido.
     *
     * @param string $provincia Provincia de envío.
     * @param string $localidad Localidad de envío.
     * @param string $direccion Dirección de envío.
     * @return array Array de errores o vacío si es válido.
     */
    public function validarPedido($provincia, $localidad, $direccion) {
        $errores = [];
        
        // Sanitizar datos
        $provincia = strip_tags(trim($provincia ?? ''));
        $localidad = strip_tags(trim($localidad ?? ''));
        $direccion = strip_tags(trim($direccion ?? ''));
        
        // Validaciones
        if (empty($provincia) || strlen($provincia) < 2 || strlen($provincia) > 100) {
            $errores[] = 'La provincia debe tener entre 2 y 100 caracteres.';
        }
        
        if (empty($localidad) || strlen($localidad) < 2 || strlen($localidad) > 100) {
            $errores[] = 'La localidad debe tener entre 2 y 100 caracteres.';
        }
        
        if (empty($direccion) || strlen($direccion) < 5 || strlen($direccion) > 200) {
            $errores[] = 'La dirección debe tener entre 5 y 200 caracteres.';
        }
        
        return $errores;
    }

    /**
     * Obtiene todos los pedidos de un usuario.
     *
     * @return array Los pedidos obtenidos.
     */
    public function crear () {

        if (!isset($_SESSION['login']) || $_SESSION['carrito'] == "") {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        // Redirigir admin
        else if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'admin/estadisticas/');
        }

        else {
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            $coste = isset($_POST['coste']) ? $_POST['coste'] : false;
            $estado = 'pendiente';
            $fecha = Utils::getCurrentDate();
            $hora = Utils::getCurrentTime();

            $errores = $this->validarPedido($provincia, $localidad, $direccion);

            if (!empty($errores)) {
                $this->pages->render('pedido/crear', ['errores' => $errores]);
            } else {
            
            $usuario = $_SESSION['login'];
            $carrito = $_SESSION['carrito'];
            $total = $this->pedidoService->getTotalCarrito($carrito);
            $pedido = $this->pedidoService->guardarPedido($usuario->id, $provincia, $localidad, $direccion, $total, $estado, $fecha, $hora, $carrito);
            unset($_SESSION['carrito']);
            
            // Redirigir a pago después de confirmar datos de entrega
            header('Location: ' . BASE_URL . 'pago/procesarPago?id=' . $pedido);
            
            }
        }
    }

    /**
     * Obtiene todos los pedidos de un usuario.
     *
     * @return array Los pedidos obtenidos.
     */
    public function eliminar($id){
        $usuario = $_SESSION['login'];

        if ($usuario->rol == 'admin') {
            $this->pedidoService->eliminarPedido($id);
            header('Location: ' . BASE_URL . 'pedido/todosLosPedidos');
        }
    }

    /**
     * Obtiene todos los pedidos de un usuario.
     *
     * @return array Los pedidos obtenidos.
     */
    public function editar($id){
        $pedidos = $this->pedidoService->recuperarTodosPedidos();
        $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos, 'id' => $id]);
    }

    /**
     * Obtiene todos los pedidos de un usuario.
     *
     * @return array Los pedidos obtenidos.
     */
    public function validarPedidoActualizado($data) {
        $errores = [];
        if (empty($data['coste']) || !is_numeric($data['coste'])) {
            $errores['coste'] = 'El coste es requerido y debe ser un número';
        }
        return $errores;
    }

    public function actualizar(){
        $usuario = $_SESSION['login'];
        $pedido = $_POST['data'];
        $id = $pedido['id'];
        $coste = $pedido['coste'];
        $usuario_id = $pedido['usuario_id'];
        
        if ($usuario->rol == 'admin') {
            $data = $_POST['data'];
            
    
            if (!empty($errores)) {
                $pedidos = $this->pedidoService->recuperarTodosPedidos();
                $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos ,'errores' => $errores]);
            } else {
                $this->pedidoService->actualizarPedido($id, $coste, $usuario_id);
                header('Location: ' . BASE_URL . 'pedido/todosLosPedidos');
            }
        }
    }

    public function confirmarPedido($id) {
        $usuario = $_SESSION['login'];
        $usuario_email = $this->pedidoService->getUsuarioPedido($id);

        if ($usuario->rol == 'admin') {
            
            $this->pedidoService->confirmarPedido($id);
            
            $this->enviarEmail($id, $usuario_email);
            header('Location: ' . BASE_URL . 'pedido/todosLosPedidos');
        }

    }


    /**
     * Envia un correo electrónico al cliente.
     * @return void
     */
    public function enviarEmail($id, $usuario_email) {
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Timeout = 5;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = 'jairoalejandro71@gmail.com';
        $mail->Password = 'ezas onxe xcfx mdua';
        $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];

        $mail->setFrom('jairoalejandro71@gmail.com', 'Tienda de Jairo');
        $mail->addReplyTo('replyto@example.com', 'First Last');
        $mail->addAddress($usuario_email, 'Cliente');
        $mail->Subject = 'Ya puede recoger su pedido en la tienda online';
        ob_start();

        // Obtener detalles del pedido
        $pedido = $this->pedidoService->obtenerPedidoPorId($id);
        $productos = $this->pedidoService->getProductosPedido($id);

        // Obtener datos del usuario que realizó el pedido
        $usuarioData = $this->pedidoService->obtenerUsuarioPorId($pedido['usuario_id']);
        $nombre = $usuarioData['nombre'] ?? 'Cliente';

        $idPedido = $id;
        $fecha = Utils::getCurrentDate();
        $hora = Utils::getCurrentTime();

        include __DIR__ . '/../Views/pedido/correo.php';
        $html = ob_get_contents();
        ob_end_clean();
        $mail->msgHTML($html, __DIR__);
        $mail->AltBody = '';

        $mail->send();
    }
    
        
        function save_mail($mail)
        {
            
            $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
    
            
            $imapStream = imap_open($path, $mail->Username, $mail->Password);
    
            $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
            imap_close($imapStream);
    
            return $result;
        }
        
        }

