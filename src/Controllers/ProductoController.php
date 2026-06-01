<?php

namespace Controllers;
use Lib\Pages;
use Services\ProductoService;
use Repositories\ProductoRepository;
use Services\PedidoService;
use Repositories\PedidoRepository;


/**
 * Clase ProductoController
 *
 * Esta clase maneja la lógica para las acciones relacionadas con los productos.
 */
class ProductoController{
    private Pages $pages;
    private ProductoService $productoService;
    private PedidoService $pedidoService;
    private $errores = [];

    /**
     * Constructor de ProductoController.
     *
     * Inicializa una nueva instancia de la clase ProductoController.
     */
    public function __construct() {
        $this->pages = new Pages();
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->pedidoService = new PedidoService(new PedidoRepository());
    }

    /**
     * Procesa la subida de archivo de imagen.
     */
    private function procesarImagenSubida($imagenRequerida = true) {
        // Si no hay archivo y es requerido
        if (empty($_FILES['imagen']['name']) && $imagenRequerida) {
            $this->errores[] = 'Debe seleccionar una imagen.';
            return false;
        }

        // Si no hay archivo pero es opcional (editar), retornar null
        if (empty($_FILES['imagen']['name']) && !$imagenRequerida) {
            return null;
        }

        // Si hay archivo, procesarlo
        if (!empty($_FILES['imagen']['name'])) {
            $archivo = $_FILES['imagen'];
            
            // Validar que no haya error en la subida
            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                $this->errores[] = 'Error al subir la imagen: ' . $this->obtenerMensajeError($archivo['error']);
                return false;
            }

            // Validar tipo de archivo
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $tipoMime = mime_content_type($archivo['tmp_name']);
            
            if (!in_array($tipoMime, $tiposPermitidos)) {
                $this->errores[] = 'El archivo debe ser una imagen válida (JPG, PNG, GIF o WebP).';
                return false;
            }

            // Validar peso del archivo (máximo 5MB)
            if ($archivo['size'] > 5 * 1024 * 1024) {
                $this->errores[] = 'La imagen no puede superar 5MB.';
                return false;
            }

            // Generar nombre único para el archivo
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombreArchivo = time() . '_' . uniqid() . '.' . $extension;
            $dirImg = __DIR__ . '/../../public/img/';

            if (!is_dir($dirImg)) {
                mkdir($dirImg, 0755, true);
            }

            $rutaDestino = $dirImg . $nombreArchivo;

            // Guardar el archivo
            if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                $this->errores[] = 'No se pudo guardar la imagen en el servidor.';
                return false;
            }

            return $nombreArchivo;
        }

        return null;
    }

    /**
     * Obtiene el mensaje de error de subida de archivo.
     */
    private function obtenerMensajeError($codigoError) {
        $mensajes = [
            UPLOAD_ERR_INI_SIZE => 'El archivo es demasiado grande (límite del servidor).',
            UPLOAD_ERR_FORM_SIZE => 'El archivo es demasiado grande (límite del formulario).',
            UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente.',
            UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo.',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal del servidor.',
            UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en el disco.',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo.'
        ];
        return $mensajes[$codigoError] ?? 'Error desconocido en la subida.';
    }

    /**
     * Válida los datos del producto.
     */
    private function validarProducto($data, $imagenRequerida = true) {
        $nombre = strip_tags(trim($data['nombre'] ?? ''));
        $descripcion = strip_tags(trim($data['descripcion'] ?? ''));
        $precio = filter_var($data['precio'], FILTER_VALIDATE_FLOAT);
        $stock = filter_var($data['stock'], FILTER_VALIDATE_INT);
        $categoriaId = filter_var($data['categoria_id'], FILTER_VALIDATE_INT);

        if (empty($nombre) || strlen($nombre) < 3 || strlen($nombre) > 100) {
            $this->errores[] = 'El nombre debe tener entre 3 y 100 caracteres.';
        }
        if (empty($descripcion) || strlen($descripcion) < 5 || strlen($descripcion) > 500) {
            $this->errores[] = 'La descripción debe tener entre 5 y 500 caracteres.';
        }
        if ($precio === false || $precio < 0.01 || $precio > 999999.99) {
            $this->errores[] = 'El precio debe ser un número positivo válido.';
        }
        if ($stock === false || $stock < 0 || $stock > 999999) {
            $this->errores[] = 'El stock debe ser un número entero positivo válido.';
        }
        if ($categoriaId === false || $categoriaId <= 0) {
            $this->errores[] = 'Debes seleccionar una categoría válida.';
        }

        // Procesar imagen
        $imagen = $this->procesarImagenSubida($imagenRequerida);
        if ($imagen === false) {
            
            return false;
        }

        if (empty($this->errores)) {
            return [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'stock' => $stock,
                'categoriaId' => $categoriaId,
                'imagen' => $imagen
            ];
        } else {
            return false;
        }
    }

    /**
     * Obtiene productos de manera aleatoria.
     *
     * @return array Los productos obtenidos aleatoriamente.
     */
    public function getRandom() {
        $productos = $this->productoService->getRandom();
        return $productos;
    }

    /**
     * Obtiene todos los productos.
     *
     * @return array Los productos obtenidos.
     */
    public function gestionarProductos() {
        $productos = $this->productoService->recuperarTodos();
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }
    
    /**
     * Crea un nuevo producto con validación.
     */
    public function crear() {
        $categorias = $this->productoService->recuperarTodos();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datosProducto = [
                'nombre' => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio' => $_POST['precio'] ?? '',
                'stock' => $_POST['stock'] ?? '',
                'categoria_id' => $_POST['categoria_id'] ?? ''
            ];

            $validado = $this->validarProducto($datosProducto, true);

            if ($validado !== false) {
                $this->productoService->guardar(
                    $validado['categoriaId'],
                    $validado['nombre'],
                    $validado['descripcion'],
                    $validado['precio'],
                    $validado['stock'],
                    $validado['imagen']
                );
                header('Location: ' . BASE_URL);
            } else {
                $this->pages->render('producto/crear', ['categorias' => $categorias, 'errores' => $this->errores]);
            }
        } else {
            $this->pages->render('producto/crear', ['categorias' => $categorias, 'errores' => []]);
        }
    }


    /**
     * Elimina un producto.
     *
     * @param int $id El ID del producto.
     */
    public function borrar($id) {
        $this->productoService->borrar($id);

        header('Location: ' . BASE_URL . 'producto/gestionarProductos');
    }


    /**
     * Edita un producto con validación.
     */
    public function editar() {
        $categorias = $this->productoService->recuperarTodos();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                $this->errores[] = 'ID de producto no válido.';
            }

            $datosProducto = [
                'nombre' => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio' => $_POST['precio'] ?? '',
                'stock' => $_POST['stock'] ?? '',
                'categoria_id' => $_POST['categoria_id'] ?? ''
            ];

            $validado = $this->validarProducto($datosProducto, false);

            if ($validado !== false && $id !== false) {
                // Si no se cargó imagen nueva, usar la actual
                if ($validado['imagen'] === null) {
                    $productoActual = $this->productoService->porId($id);
                    $validado['imagen'] = $productoActual['imagen'];
                }

                $this->productoService->actualizar(
                    $id,
                    $validado['nombre'],
                    $validado['descripcion'],
                    $validado['precio'],
                    $validado['stock'],
                    $validado['categoriaId'],
                    $validado['imagen']
                );
                header('Location: ' . BASE_URL);
            } else {
                $producto = $this->productoService->porId($id);
                $this->pages->render('producto/editar', ['producto' => $producto, 'categorias' => $categorias, 'errores' => $this->errores]);
            }
        } else {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            $producto = $this->productoService->porId($id);
            $this->pages->render('producto/editar', ['producto' => $producto, 'categorias' => $categorias, 'errores' => []]);
        }
    }

    /**
     * Obtiene los detalles de un producto.
     *
     * @param int $id El ID del producto.
     */
    public function verDetalles($id) {
        $producto = $this->productoService->porId($id);
        $this->pages->render('producto/verDetalles', ['producto' => $producto]);
    }
}
