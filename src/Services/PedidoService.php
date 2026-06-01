<?php

namespace Services;

use Repositories\PedidoRepository;

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
 * Servicio para gestionar operaciones relacionadas con pedidos.
 */
class PedidoService {
    private PedidoRepository $pedidoRepository;

    /**
     * Constructor de PedidoService.
     *
     * @param PedidoRepository $pedidoRepository Repositorio para gestionar los datos de los pedidos.
     */
    public function __construct(PedidoRepository $pedidoRepository) {
        $this->pedidoRepository = $pedidoRepository;
    }

    /**
     * Recupera todos los pedidos del sistema.
     */
    public function recuperarTodosPedidos() {
        return $this->pedidoRepository->getAll();
    }

    /**
     * Obtiene un pedido específico por su ID.
     *
     * @param int $id ID del pedido.
     */
    public function obtenerPedidoPorId($id) {
        return $this->pedidoRepository->getById($id);
    }

    /**
     * Obtiene todos los pedidos asociados a un usuario específico.
     *
     * @param int $usuarioId ID del usuario.
     */
    public function obtenerPedidosPorUsuario($usuarioId) {
        return $this->pedidoRepository->getByUsuario($usuarioId);
    }

    /**
     * Elimina un pedido por su ID.
     *
     * @param int $id ID del pedido a eliminar.
     */
    public function eliminarPedido($id) {
        return $this->pedidoRepository->borrarCategoria($id);
    }

    /**
     * Actualiza la información de un pedido existente.
     *
     * @param int $id ID del pedido.
     * @param string $fecha Fecha del pedido.
     * @param string $hora Hora del pedido.
     * @param float $coste Coste total del pedido.
     * @param string $estado Estado del pedido.
     * @param int $usuario_id ID del usuario que realizó el pedido.
     */
    public function actualizarPedido($id,$coste, $usuario_id) {
        return $this->pedidoRepository->editar($id, $coste, $usuario_id);
    }

    /**
     * Guarda un nuevo pedido en el sistema.
     */
    public function guardarPedido($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito) {
        return $this->pedidoRepository->guardarCategoria($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
    }

    /**
     * Obtiene los productos asociados a un pedido específico.
     *
     * @param int $pedidoId ID del pedido.
     */
    public function getProductosPedido($pedidoId) {
        return $this->pedidoRepository->getProductosPedido($pedidoId);
    }

    public function getUsuarioPedido($pedidoId) {
        return $this->pedidoRepository->getUsuarioPedido($pedidoId);
    }

    /**
     * Calcula el total del carrito de compras.
     *
     * @param array $carrito Carrito de compras.
     */
    public function getTotalCarrito($carrito) {
        return $this->pedidoRepository->calcularTotal($carrito);
    }

    /**
     * Obtiene la cantidad de un producto específico en un pedido.
     *
     * @param int $pedidoId ID del pedido.
     * @param int $productoId ID del producto.
     */
    public function getCantidadProducto($pedidoId, $productoId) {
        return $this->pedidoRepository->getCantidadProducto($pedidoId, $productoId);
    }

    /**
     * Confirma un pedido existente.
     *
     * @param int $pedidoId ID del pedido a confirmar.
     */
    public function confirmarPedido($pedidoId) {
        return $this->pedidoRepository->confirmarPedido($pedidoId);
    }

    /**
     * Obtiene los datos de un usuario por su ID.
     *
     * @param int $usuarioId ID del usuario.
     */
    public function obtenerUsuarioPorId($usuarioId) {
        return $this->pedidoRepository->obtenerUsuarioPorId($usuarioId);
    }

    public function actualizarDireccion($id, $provincia, $localidad, $direccion) {
        return $this->pedidoRepository->actualizarDireccion($id, $provincia, $localidad, $direccion);
    }

}

