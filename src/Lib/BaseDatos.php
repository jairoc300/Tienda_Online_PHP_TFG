<?php
namespace Lib;

use PDO;
use PDOException;

class BaseDatos {
    private $conexion;
    private mixed $resultado; 
    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;

    /**
     * Constructor de la clase.
     * Inicializa los datos de conexión con la base de datos y establece la conexión.
     */
    function __construct() {
        $this->servidor = $_ENV['SERVIDOR'] ?? getenv('SERVIDOR');
        $this->usuario = $_ENV['USUARIO'] ?? getenv('USUARIO');
        $this->pass = $_ENV['PASSWORD'] ?? getenv('PASSWORD');
        $this->base_datos = $_ENV['BASE_DATOS'] ?? getenv('BASE_DATOS');

        $this->conexion = $this->conexionBaseDatos();
    }

    /**
     * Crea una conexión a la base de datos utilizando PDO.
     *
     * @return PDO Objeto de conexión a la base de datos.
     */
    private function conexionBaseDatos(): PDO {
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );

            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
            return $conexion;
        } catch (PDOException $e) {
            echo "Error en la conexión a la base de datos: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Ejecuta una consulta SQL en la base de datos.
     *
     * @param string $consultasQL La consulta SQL a ejecutar.
     */
    public function ejecucionConsultaSql(string $consultasQL): void {
        $this->resultado = $this->conexion->query($consultasQL);
    }

    /**
     * Extrae un registro de los resultados de la última consulta.
     *
     * @return mixed Un array asociativo del registro o false si no hay más.
     */
    public function registroUltimaConsulta(): mixed {
        return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC)) ? $fila : false;
    }

    /**
     * Extrae todos los registros de los resultados de la última consulta.
     *
     * @return array Un array de todos los registros como arrays asociativos.
     */
    public function todosRegistrosUltimaConsulta(): array {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }


    public function exec($sql) {
        return $this->conexion->exec($sql);
    }

    /**
     * Devuelve el número de filas afectadas por la última operación SQL.
     *
     * @return int El número de filas afectadas.
     */
    public function numerofilas(): int {
        return $this->resultado->rowCount();
    }

    /**
     * Cierra la conexión a la base de datos.
     */
    public function cerrarConexion() {
        $this->conexion = null;
    }

    /**
     * Prepara una declaración SQL para su ejecución y devuelve un objeto de declaración.
     *
     * @param string $pre La consulta SQL para preparar.
     */
    public function ejecucionDeclaracionSQL($pre) {
        return $this->conexion->prepare($pre);
    }

    /**
     * Inicia una transacción.
     */
    public function iniciar() {
        $this->conexion->beginTransaction();
    }

    /**
     * Confirma una transacción, guardando todos los cambios.
     */
    public function confirmar() {
        $this->conexion->commit();
    }

    /**
     * Revierte una transacción, deshaciendo todos los cambios.
     */
    public function rollback() {
        $this->conexion->rollBack();
    }

    /**
     * Obtiene el ID del último registro insertado.
     *
     * @return string El ID del último registro insertado.
     */
    public function lastInsertId() {
        return $this->conexion->lastInsertId();
    }
}
