<?php

class Consejo {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Obtiene un consejo aleatorio según objetivo e IMC
     * @param string $objetivo - 'bajar', 'subir', 'mantener'
     * @param float $imc - Valor del índice de masa corporal
     * @param string $tipo - (opcional) 'ejercicio', 'nutricion', 'motivacion'
     * @return array|null
     */
    public function obtenerConsejoAleatorio($objetivo, $imc, $tipo = null) {
        try {
            $sql = "SELECT id, tipo, mensaje, objetivo, imc_min, imc_max 
                    FROM consejos 
                    WHERE objetivo = :objetivo 
                    AND :imc BETWEEN imc_min AND imc_max";
            
            // Filtro opcional por tipo
            if ($tipo) {
                $sql .= " AND tipo = :tipo";
            }
            
            $sql .= " ORDER BY RAND() LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':objetivo', $objetivo);
            $stmt->bindParam(':imc', $imc);
            
            if ($tipo) {
                $stmt->bindParam(':tipo', $tipo);
            }
            
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener consejo: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtiene múltiples consejos variados (uno de cada tipo)
     * @param string $objetivo
     * @param float $imc
     * @return array
     */
    public function obtenerConsejosVariados($objetivo, $imc) {
        $consejos = [
            'ejercicio' => $this->obtenerConsejoAleatorio($objetivo, $imc, 'ejercicio'),
            'nutricion' => $this->obtenerConsejoAleatorio($objetivo, $imc, 'nutricion'),
            'motivacion' => $this->obtenerConsejoAleatorio($objetivo, $imc, 'motivacion')
        ];
        
        return $consejos;
    }
    
    /**
     * Obtiene todos los consejos disponibles para un perfil
     * @param string $objetivo
     * @param float $imc
     * @return array
     */
    public function obtenerTodosConsejos($objetivo, $imc) {
        try {
            $sql = "SELECT id, tipo, mensaje, objetivo 
                    FROM consejos 
                    WHERE objetivo = :objetivo 
                    AND :imc BETWEEN imc_min AND imc_max
                    ORDER BY tipo, RAND()";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':objetivo', $objetivo);
            $stmt->bindParam(':imc', $imc);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener consejos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Cuenta cuántos consejos hay disponibles para un perfil
     * @param string $objetivo
     * @param float $imc
     * @return int
     */
    public function contarConsejos($objetivo, $imc) {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM consejos 
                    WHERE objetivo = :objetivo 
                    AND :imc BETWEEN imc_min AND imc_max";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':objetivo', $objetivo);
            $stmt->bindParam(':imc', $imc);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
            
        } catch (PDOException $e) {
            error_log("Error al contar consejos: " . $e->getMessage());
            return 0;
        }
    }
}
