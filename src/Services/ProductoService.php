<?php

namespace Services;

use Repositories\ProductoRepository;

/**
 * Servicio para gestionar operaciones relacionadas con productos.
 */
class ProductoService {
    private $productoRepository;

    /**
    * Constructor que inyecta el repositorio asociado a las operaciones de productos.
    *
    * @param ProductoRepository $productoRepository Repositorio para gestionar productos.
    */
    public function __construct(ProductoRepository $productoRepository) {
        $this->productoRepository = $productoRepository;
    }

    /**
    * Recupera todas las entradas de productos de la base de datos.
    *
    * @return array Lista de productos.
    */
    public function recuperarTodos() {
        return $this->productoRepository->recuperarTodos();
    }

    /**
    * Obtiene un conjunto aleatorio de productos.
    *
    * @return array Lista aleatoria de productos limitada a 5.
    */
    public function getRandom() {
        return $this->productoRepository->getRandom();
    }

    /**
    * Busca productos por categoría específica.
    *
    * @param int $categoriaId El identificador de la categoría de productos.
    * @return array Productos pertenecientes a la categoría especificada.
    */
    public function getByCategoria($categoriaId) {
        return $this->productoRepository->getByCategoria($categoriaId);
    }

    /**
    * Recupera un producto específico por su ID.
    *
    * @param int $id El identificador del producto.
    * @return array Datos del producto específico.
    */
    public function porId($id) {
        return $this->productoRepository->porId($id);
    }

    /**
    * Guarda un nuevo producto en la base de datos.
    *
    * @param int $categoriaId Identificador de la categoría del nuevo producto.
    * @param string $nombre Nombre del producto.
    * @param string $descripcion Descripción del producto.
    * @param float $precio Precio del producto.
    * @param int $stock Cantidad en stock del producto.
    * @param string $imagen URL de la imagen del producto.
    * @return bool True si el producto se guardó con éxito, false en caso contrario.
    */
    public function guardar($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen) {
        return $this->productoRepository->guardar($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen);
    }

    /**
    * Elimina un producto de la base de datos por su ID.
    *
    */
    public function borrar($productId) {
        return $this->productoRepository->borrar($productId);
    }

    /**
    * Actualiza los datos de un producto existente en la base de datos.
    *
    */
    public function actualizar($productId, $nombre, $descripcion, $precio, $stock, $categoriaId, $imagen) {
        return $this->productoRepository->actualizar($productId, $nombre, $descripcion, $precio, $stock, $categoriaId, $imagen);
    }

    /**
    * Recupera productos de una categoría con paginación.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @param int $pagina Número de página (comienza en 1).
    * @param int $porPagina Cantidad de productos por página.
    * @return array Productos paginados de la categoría.
    */
    public function getByCategoriaPaginado($categoriaId, $pagina = 1, $porPagina = 5) {
        return $this->productoRepository->getByCategoriaPaginado($categoriaId, $pagina, $porPagina);
    }

    /**
    * Obtiene el total de productos en una categoría.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @return int Total de productos en la categoría.
    */
    public function contarProductosCategoria($categoriaId) {
        return $this->productoRepository->contarProductosCategoria($categoriaId);
    }

    /**
    * Busca productos por nombre.
    *
    * @param string $nombre El nombre del producto a buscar.
    * @return array Lista de productos que coinciden con el nombre.
    */
    public function buscarPorNombre($nombre) {
        return $this->productoRepository->buscarPorNombre($nombre);
    }

    /**
    * Busca productos por nombre dentro de una categoría específica.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @param string $nombre El nombre del producto a buscar.
    * @return array Lista de productos que coinciden dentro de la categoría.
    */
    public function buscarPorNombreYCategoria($categoriaId, $nombre) {
        return $this->productoRepository->buscarPorNombreYCategoria($categoriaId, $nombre);
    }

    /**
    * Filtra productos de una categoría por rango de precio.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @param float $precioMin Precio mínimo.
    * @param float $precioMax Precio máximo.
    * @return array Productos dentro del rango de precio.
    */
    public function getByCategoriaPrecio($categoriaId, $precioMin, $precioMax) {
        return $this->productoRepository->getByCategoriaPrecio($categoriaId, $precioMin, $precioMax);
    }

    /**
    * Obtiene productos paginados con filtros aplicados.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @param string|null $nombre Nombre del producto a buscar (opcional).
    * @param float|null $precioMin Precio mínimo (opcional).
    * @param float|null $precioMax Precio máximo (opcional).
    * @param int $pagina Número de página.
    * @param int $porPagina Productos por página.
    * @return array Productos filtrados y paginados.
    */
    public function getByCategoriaPaginadoFiltrado($categoriaId, $nombre = null, $precioMin = null, $precioMax = null, $pagina = 1, $porPagina = 5) {
        return $this->productoRepository->getByCategoriaPaginadoFiltrado($categoriaId, $nombre, $precioMin, $precioMax, $pagina, $porPagina);
    }

    /**
    * Cuenta el total de productos con filtros aplicados.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @param string|null $nombre Nombre del producto a buscar (opcional).
    * @param float|null $precioMin Precio mínimo (opcional).
    * @param float|null $precioMax Precio máximo (opcional).
    * @return int Total de productos que cumplen con los filtros.
    */
    public function contarProductosFiltrado($categoriaId, $nombre = null, $precioMin = null, $precioMax = null) {
        return $this->productoRepository->contarProductosFiltrado($categoriaId, $nombre, $precioMin, $precioMax);
    }

    /**
    * Obtiene el precio máximo de los productos en una categoría.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @return float Precio máximo de la categoría.
    */
    public function obtenerPrecioMaximoCategoria($categoriaId) {
        return $this->productoRepository->obtenerPrecioMaximoCategoria($categoriaId);
    }

    /**
    * Obtiene el precio mínimo de los productos en una categoría.
    *
    * @param int $categoriaId El identificador de la categoría.
    * @return float Precio mínimo de la categoría.
    */
    public function obtenerPrecioMinimoCategoria($categoriaId) {
        return $this->productoRepository->obtenerPrecioMinimoCategoria($categoriaId);
    }
}
