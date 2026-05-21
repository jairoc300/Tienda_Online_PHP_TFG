<?php

namespace Controllers;

use Repositories\PedidoRepository;
use Services\PedidoService;
use Lib\Pages;

/**
 * Controlador para gestionar pagos con PayPal (simulado claramente)
 */
class PagoController {
    private Pages $pages;
    private PedidoService $pedidoService;

    public function __construct() {
        $this->pages = new Pages();
        $this->pedidoService = new PedidoService(new PedidoRepository());
    }

    /**
     * Muestra la página de pago con PayPal
     * Simula el flujo de PayPal
     */
    public function procesarPago() {
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
            return;
        }

        // Redirigir admin
        if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'admin/estadisticas/');
            return;
        }

        // Obtener ID del pedido de la URL
        $pedidoId = $_GET['id'] ?? null;
        
        if (!$pedidoId) {
            header('Location: ' . BASE_URL . 'pedido/misPedidos');
            return;
        }

        // Obtener datos del pedido
        $pedido = $this->pedidoService->obtenerPedidoPorId($pedidoId);
        
        if (!$pedido || $pedido['usuario_id'] != $_SESSION['login']->id) {
            $this->pages->render('error/error', ['mensaje' => 'Pedido no encontrado']);
            return;
        }

        // EN MODO DESARROLLO: Saltarse el formulario y aprobar automáticamente
        if (defined('MODO_DESARROLLO') && MODO_DESARROLLO) {
            // Generar referencia de pago
            $_SESSION['pago_exitoso'] = true;
            $_SESSION['referencia_pago'] = 'DEV-' . date('YmdHis') . '-' . $pedidoId;
            
            // Ir directo a confirmación
            header('Location: ' . BASE_URL . 'pago/confirmacionPago?id=' . $pedidoId);
            return;
        }

        // EN MODO PRODUCCIÓN: Mostrar formulario de pago
        // Genera información de pago simulada
        $datoPago = [
            'pedido_id' => $pedidoId,
            'monto' => $pedido['coste'],
            'divisa' => 'EUR',
            'email' => $_SESSION['login']->email,
            'nombre_cliente' => $_SESSION['login']->nombre . ' ' . $_SESSION['login']->apellidos,
            'token_pago' => bin2hex(random_bytes(16)) // Token simulado
        ];

        $this->pages->render('pago/formularioPago', ['pedido' => $pedido, 'dato_pago' => $datoPago]);
    }

    /**
     * Procesa el pago simulado
     * 
     */
    public function efectuarPago() {
        if (!isset($_SESSION['login']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            return;
        }

        // Redirigir admin
        if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'admin/estadisticas/');
            return;
        }

        $pedidoId = $_POST['pedido_id'] ?? null;
        $tokenPago = $_POST['token_pago'] ?? null;
        $numeroTarjeta = $_POST['numero_tarjeta'] ?? null;

        // Validar datos simulados
        if (!$pedidoId || !$tokenPago || !$numeroTarjeta) {
            $_SESSION['error_pago'] = 'Datos de pago incompletos';
            header('Location: ' . BASE_URL . 'pago/procesarPago?id=' . $pedidoId);
            return;
        }

        // Simulación: validar número de tarjeta (mínimo 16 dígitos)
        if (!preg_match('/^\d{16}$/', str_replace(' ', '', $numeroTarjeta))) {
            $_SESSION['error_pago'] = 'Número de tarjeta inválido';
            header('Location: ' . BASE_URL . 'pago/procesarPago?id=' . $pedidoId);
            return;
        }

        // Obtener pedido y validar
        $pedido = $this->pedidoService->obtenerPedidoPorId($pedidoId);
        
        if (!$pedido || $pedido['usuario_id'] != $_SESSION['login']->id) {
            $_SESSION['error_pago'] = 'Pedido inválido';
            header('Location: ' . BASE_URL . 'pedido/misPedidos');
            return;
        }

        // Simular procesamiento de pago
        // 
        $pagoProcesado = $this->simularProcesamientoPago($pedidoId, $pedido['coste']);

        if ($pagoProcesado) {
            $_SESSION['pago_exitoso'] = true;
            $_SESSION['referencia_pago'] = 'PAY-' . date('YmdHis') . '-' . $pedidoId;
            
            // El pedido permanece en estado "pendiente" para confirmación por el admin
            
            header('Location: ' . BASE_URL . 'pago/confirmacionPago?id=' . $pedidoId);
        } else {
            $_SESSION['error_pago'] = 'El pago fue rechazado. Intenta nuevamente.';
            header('Location: ' . BASE_URL . 'pago/procesarPago?id=' . $pedidoId);
        }
    }

    /**
     * Actualiza la dirección de entrega de un pedido
     */
    public function actualizarDireccion() {
        if (!isset($_SESSION['login']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            return;
        }

        $pedidoId = $_POST['pedido_id'] ?? null;
        $provincia = isset($_POST['provincia']) ? strip_tags(trim($_POST['provincia'])) : '';
        $localidad = isset($_POST['localidad']) ? strip_tags(trim($_POST['localidad'])) : '';
        $direccion = isset($_POST['direccion']) ? strip_tags(trim($_POST['direccion'])) : '';

        // Validar datos
        $errores = [];
        if (empty($provincia) || strlen($provincia) < 2 || strlen($provincia) > 100) {
            $errores[] = 'La provincia debe tener entre 2 y 100 caracteres.';
        }
        if (empty($localidad) || strlen($localidad) < 2 || strlen($localidad) > 100) {
            $errores[] = 'La localidad debe tener entre 2 y 100 caracteres.';
        }
        if (empty($direccion) || strlen($direccion) < 5 || strlen($direccion) > 200) {
            $errores[] = 'La dirección debe tener entre 5 y 200 caracteres.';
        }

        if (!empty($errores)) {
            $_SESSION['error_pago'] = implode(' | ', $errores);
            header('Location: ' . BASE_URL . 'pago/procesarPago?id=' . $pedidoId);
            return;
        }

        // Actualizar dirección en la base de datos
        // Por ahora solo guardamos en sesión para mantener consistencia durante el flujo de pago
        header('Location: ' . BASE_URL . 'pago/confirmacionPago?id=' . $pedidoId);
    }

    /**
     * Página de confirmación de pago
     */
    public function confirmacionPago() {
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
            return;
        }

        // Redirigir admin
        if ($_SESSION['login']->rol == 'admin') {
            header('Location: ' . BASE_URL . 'admin/estadisticas/');
            return;
        }

        $pedidoId = $_GET['id'] ?? null;
        
        if (!$pedidoId) {
            header('Location: ' . BASE_URL);
            return;
        }

        $pedido = $this->pedidoService->obtenerPedidoPorId($pedidoId);
        $referenciaPago = $_SESSION['referencia_pago'] ?? 'N/A';

        $datos = [
            'pedido' => $pedido,
            'referencia_pago' => $referenciaPago
        ];

        $this->pages->render('pago/confirmacionPago', $datos);
    }

    /**
     * Simula el procesamiento de un pago
     * 
     *
     * @param int $pedidoId ID del pedido
     * @param float $monto Monto a pagar
     * @return bool True si el pago fue aceptado
     */
    private function simularProcesamientoPago($pedidoId, $monto) {
        
        
        return true;
    }
}
