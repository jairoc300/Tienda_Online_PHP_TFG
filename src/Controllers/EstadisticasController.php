<?php
namespace Controllers;

use Lib\BaseDatos;
use Lib\Pages;

class EstadisticasController {
    private BaseDatos $db;
    private Pages $pages;

    public function __construct() {
        $this->db = new BaseDatos();
        $this->pages = new Pages();
    }

    public function index() {
        // Total usuarios
        $usuarios = $this->consulta("SELECT COUNT(*) as total FROM usuarios");
        $pedidos = $this->consulta("SELECT COUNT(*) as total FROM pedidos");
        $ingresos = $this->consulta("SELECT SUM(coste) as total FROM pedidos");
        $ventas = $this->consulta("SELECT p.nombre, SUM(lp.unidades) as total_vendido FROM lineas_pedidos lp JOIN productos p ON lp.producto_id = p.id GROUP BY lp.producto_id ORDER BY total_vendido DESC");
        $estados = $this->consulta("SELECT estado, COUNT(*) as total FROM pedidos GROUP BY estado");

        $this->pages->render("admin/estadisticas", [
            "usuarios" => $usuarios[0]["total"] ?? 0,
            "pedidos" => $pedidos[0]["total"] ?? 0,
            "ingresos" => $ingresos[0]["total"] ?? 0,
            "ventas" => $ventas,
            "estados" => $estados
        ]);
    }
    
    // Método auxiliar para obtener resultados de consulta
    private function consulta($sql) {
        $this->db->ejecucionConsultaSql($sql);
        return $this->db->todosRegistrosUltimaConsulta();
    }
}
