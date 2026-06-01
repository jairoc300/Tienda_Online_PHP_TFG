<?php

namespace Repositories;

use Lib\BaseDatos;
use PDO;

/**
 * Repositorio para manejar las operaciones de productos en la base de datos.
 */
class ProductoRepository {
    private BaseDatos $db;

    public function __construct() {
        $this->db = new BaseDatos();
    }

    /**
     * Recupera todos los productos de la base de datos.
     */
    public function recuperarTodos() {
        return $this->executeQuery("SELECT * FROM productos");
    }

    /**
     * Recupera cinco productos al azar de la base de datos.
     */
    public function getRandom() {
        return $this->executeQuery("SELECT * FROM productos ORDER BY RAND() LIMIT 5");
    }

    /**
     * Recupera todos los productos por categoría.
     *
     * @param int $categoriaId ID de la categoría.
     */
    public function getByCategoria($categoriaId) {
        return $this->executeQuery("SELECT * FROM productos WHERE categoria_id = :categoriaId", ['categoriaId' => $categoriaId]);
    }

    /**
     * Recupera un producto por su ID.
     *
     * @param int $id ID del producto.
     */
    public function porId($id) {
        return $this->executeQuery("SELECT * FROM productos WHERE id = :id", ['id' => $id])[0] ?? null;
    }

    /**
     * Inserta un nuevo producto en la base de datos.
     */
    public function guardar($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen) {
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen, fecha) VALUES (:categoriaId, :nombre, :descripcion, :precio, :stock, :imagen, :fecha)";
        return $this->executeUpdate($sql, [
            'categoriaId' => $categoriaId,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'imagen' => $imagen,
            'fecha' => date('Y-m-d')
        ]);
    }

    /**
     * Elimina un producto de la base de datos por su ID.
     */
    public function borrar($productId) {
        $this->executeUpdate("DELETE FROM productos WHERE id = :id", ['id' => $productId]);
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function actualizar($productId, $nombre, $descripcion, $precio, $stock, $categoriaId, $imagen) {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, categoria_id = :categoriaId, imagen = :imagen WHERE id = :id";
        $this->executeUpdate($sql, [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'categoriaId' => $categoriaId,
            'imagen' => $imagen,
            'id' => $productId
        ]);
    }

    /**
     * Ejecuta consultas de selección y devuelve todos los registros o un valor booleano para las consultas de actualización.
     */
    private function executeQuery($sql, $params = []) {
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera productos por categoría con paginación.
     *
     * @param int $categoriaId ID de la categoría.
     * @param int $pagina Número de página (comienza en 1).
     * @param int $porPagina Cantidad de productos por página.
     */
    public function getByCategoriaPaginado($categoriaId, $pagina = 1, $porPagina = 5) {
        $offset = ($pagina - 1) * $porPagina;
        $sql = "SELECT * FROM productos WHERE categoria_id = :categoriaId LIMIT :offset, :limit";
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        $stmt->bindValue(':categoriaId', $categoriaId);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el total de productos en una categoría.
     *
     * @param int $categoriaId ID de la categoría.
     */
    public function contarProductosCategoria($categoriaId) {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = :categoriaId";
        $result = $this->executeQuery($sql, ['categoriaId' => $categoriaId]);
        return $result[0]['total'] ?? 0;
    }

    /**
     * Busca productos por nombre.
     *
     * @param string $nombre Nombre del producto a buscar.
     */
    public function buscarPorNombre($nombre) {
        $nombre = '%' . strtolower($nombre) . '%';
        $sql = "SELECT * FROM productos WHERE LOWER(nombre) LIKE :nombre";
        return $this->executeQuery($sql, ['nombre' => $nombre]);
    }

    /**
     * Busca productos por nombre dentro de una categoría.
     *
     * @param int $categoriaId ID de la categoría.
     * @param string $nombre Nombre del producto a buscar.
     */
    public function buscarPorNombreYCategoria($categoriaId, $nombre) {
        $nombre = '%' . strtolower($nombre) . '%';
        $sql = "SELECT * FROM productos WHERE categoria_id = :categoriaId AND LOWER(nombre) LIKE :nombre";
        return $this->executeQuery($sql, ['categoriaId' => $categoriaId, 'nombre' => $nombre]);
    }

    /**
     * Filtra productos por categoría y rango de precio.
     *
     * @param int $categoriaId ID de la categoría.
     * @param float $precioMin Precio mínimo.
     * @param float $precioMax Precio máximo.
     */
    public function getByCategoriaPrecio($categoriaId, $precioMin, $precioMax) {
        $sql = "SELECT * FROM productos WHERE categoria_id = :categoriaId AND precio BETWEEN :precioMin AND :precioMax";
        return $this->executeQuery($sql, ['categoriaId' => $categoriaId, 'precioMin' => $precioMin, 'precioMax' => $precioMax]);
    }

    /**
     * Filtra y busca productos con paginación completa.
     *
     * @param int $categoriaId ID de la categoría.
     * @param string|null $nombre Nombre del producto a buscar (opcional).
     * @param float|null $precioMin Precio mínimo (opcional).
     * @param float|null $precioMax Precio máximo (opcional).
     * @param int $pagina Número de página.
     * @param int $porPagina Productos por página.
     */
    public function getByCategoriaPaginadoFiltrado($categoriaId, $nombre = null, $precioMin = null, $precioMax = null, $pagina = 1, $porPagina = 5) {
        $offset = ($pagina - 1) * $porPagina;
        
        $sql = "SELECT * FROM productos WHERE categoria_id = :categoriaId";
        $params = ['categoriaId' => $categoriaId];
        
        if (!empty($nombre)) {
            $sql .= " AND LOWER(nombre) LIKE :nombre";
            $params['nombre'] = '%' . strtolower($nombre) . '%';
        }
        
        if ($precioMin !== null && $precioMax !== null) {
            $sql .= " AND precio BETWEEN :precioMin AND :precioMax";
            $params['precioMin'] = $precioMin;
            $params['precioMax'] = $precioMax;
        }
        
        $sql .= " LIMIT :offset, :limit";
        
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        foreach ($params as $key => $value) {
            if ($key === 'offset') {
                $stmt->bindValue(':offset', $value, PDO::PARAM_INT);
            } elseif ($key === 'limit') {
                $stmt->bindValue(':limit', $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':' . $key, $value);
            }
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta el total de productos con filtros aplicados.
     *
     * @param int $categoriaId ID de la categoría.
     * @param string|null $nombre Nombre del producto a buscar (opcional).
     * @param float|null $precioMin Precio mínimo (opcional).
     * @param float|null $precioMax Precio máximo (opcional).
     */
    public function contarProductosFiltrado($categoriaId, $nombre = null, $precioMin = null, $precioMax = null) {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = :categoriaId";
        $params = ['categoriaId' => $categoriaId];
        
        if (!empty($nombre)) {
            $sql .= " AND LOWER(nombre) LIKE :nombre";
            $params['nombre'] = '%' . strtolower($nombre) . '%';
        }
        
        if ($precioMin !== null && $precioMax !== null) {
            $sql .= " AND precio BETWEEN :precioMin AND :precioMax";
            $params['precioMin'] = $precioMin;
            $params['precioMax'] = $precioMax;
        }
        
        $result = $this->executeQuery($sql, $params);
        return $result[0]['total'] ?? 0;
    }

    /**
     * Obtiene el precio máximo de los productos en una categoría.
     *
     * @param int $categoriaId ID de la categoría.
     */
    public function obtenerPrecioMaximoCategoria($categoriaId) {
        $sql = "SELECT MAX(precio) as precioMax FROM productos WHERE categoria_id = :categoriaId";
        $result = $this->executeQuery($sql, ['categoriaId' => $categoriaId]);
        return $result[0]['precioMax'] ?? 0;
    }

    /**
     * Obtiene el precio mínimo de los productos en una categoría.
     *
     * @param int $categoriaId ID de la categoría.
     */
    public function obtenerPrecioMinimoCategoria($categoriaId) {
        $sql = "SELECT MIN(precio) as precioMin FROM productos WHERE categoria_id = :categoriaId";
        $result = $this->executeQuery($sql, ['categoriaId' => $categoriaId]);
        return $result[0]['precioMin'] ?? 0;
    }

    /**
     * Ejecuta actualizaciones o inserciones y devuelve un booleano.
     */
    private function executeUpdate($sql, $params = []) {
        $stmt = $this->db->ejecucionDeclaracionSQL($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        return $stmt->execute();
    }
}
