<?php
namespace Repositories;
use Lib\BaseDatos;
use Lib\Pages;
use PDO;
use PDOException;

function dd(...$vars) {
    echo '<pre>';
    foreach ($vars as $var) {
        echo '<br>';
        print_r($var);
    }
    echo '</pre>';
    die();
}

class PedidoRepository {
    private BaseDatos $db;
    private Pages $pages;

    public function __construct() {
        $this->db = new BaseDatos();
        $this->pages = new Pages();
    }

    public function getAll() {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $this->db->ejecucionConsultaSql($sql);
        return $this->db->todosRegistrosUltimaConsulta();
    }

    public function getById($id) {
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        return $pedido;
    }

    public function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = :usuarioId ORDER BY id DESC";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedidos;
    }

    public function borrarCategoria($id) {
        $sql = "DELETE FROM lineas_pedidos WHERE pedido_id = :id";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $sql = "DELETE FROM pedidos WHERE id = :id";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $delete = $stmt->execute();
        return $delete;
    }

    public function editar($id, $coste, $usuario_id) {
        $sql = "UPDATE pedidos SET coste = :coste, usuario_id = :usuario_id WHERE id = :id";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':coste', $coste, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $update = $stmt->execute();
        return $update;
    }

    public function getProductosPedido($pedidoId) {
        $sql = "SELECT p.*, lp.unidades FROM productos p
                INNER JOIN lineas_pedidos lp ON p.id = lp.producto_id
                WHERE lp.pedido_id = :pedidoId";

        $stmt = $this->db->ejecucionDeclaracionSQL($sql); 
        $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function getCantidadProducto($pedidoId, $productoId) {
        
        $sql = "SELECT cantidad FROM lineas_pedidos WHERE pedido_id = :pedidoId AND producto_id = :productoId";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmt->bindParam(':productoId', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['cantidad'] : 0;
    }

    public function calcularTotal($carrito) {
        $total = 0;
        foreach ($carrito as $elemento) {
            $total += $elemento['precio'] * $elemento['cantidad'];
        }
        return $total;

    }

    public function getUsuarioPedido($pedidoId) {
        $sql = "SELECT usuario_id FROM pedidos WHERE id = :pedidoId";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT email FROM usuarios WHERE id = :idUsuario";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':idUsuario', $result['usuario_id'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['email'] : 0;
    }


    private function insertPedido($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora)
    {
        $sqlPedido = "INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuarioId, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)";
        $stmtPedido = $this->db->ejecucionDeclaracionSQL($sqlPedido);
        $stmtPedido->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmtPedido->bindParam(':provincia', $provincia, PDO::PARAM_STR);
        $stmtPedido->bindParam(':localidad', $localidad, PDO::PARAM_STR);
        $stmtPedido->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmtPedido->bindParam(':coste', $coste, PDO::PARAM_STR);
        $stmtPedido->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmtPedido->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmtPedido->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmtPedido->execute();
    
        // Obtener el ID del nuevo pedido
        return $this->db->lastInsertId();
    }

    private function insertLineasPedido($pedidoId, $carrito)
    {
        foreach ($carrito as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];

            $sqlLineaPedido = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedidoId, :productoId, :unidades)";
            $stmtLineaPedido = $this->db->ejecucionDeclaracionSQL($sqlLineaPedido);
            $stmtLineaPedido->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
            $stmtLineaPedido->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $stmtLineaPedido->bindParam(':unidades', $cantidad, PDO::PARAM_INT);
            $stmtLineaPedido->execute();
        }
    }

    private function actualizarStock($carrito)
    {
        foreach ($carrito as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];

            $sqlStock = "UPDATE productos SET stock = stock - :cantidad WHERE id = :productoId";
            $stmtStock = $this->db->ejecucionDeclaracionSQL($sqlStock);
            $stmtStock->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtStock->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $stmtStock->execute();
        }
    }

    public function guardarCategoria($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito)
    {
        // Comienzo de la transacción
        $this->db->iniciar();

        try {
            // Paso 1: Insertar el pedido en la tabla pedidos
            $pedidoId = $this->insertPedido($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);

            // Paso 2: Insertar líneas de pedido en la tabla lineas_pedido
            $this->insertLineasPedido($pedidoId, $carrito);

            // Paso 3: Actualizar el stock de los productos
            $this->actualizarStock($carrito);

            // Commit si todas las operaciones fueron exitosas
            $this->db->confirmar();

            // Se puede devolver el ID del pedido creado o cualquier otro dato que necesites
            return $pedidoId;
        } catch (PDOException $e) {
            // En caso de error, realizar rollback y lanzar la excepción nuevamente
            $this->db->rollBack();
            throw $e;
        }
    }

public function confirmarPedido($idPedido){
        $estado = 'confirmado';
        try {
            
            $sql = "UPDATE pedidos SET estado = '$estado' WHERE id = $idPedido";

            $this->db->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function obtenerUsuarioPorId($usuarioId) {
        $sql = "SELECT nombre, apellidos, email FROM usuarios WHERE id = :id";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindParam(':id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
