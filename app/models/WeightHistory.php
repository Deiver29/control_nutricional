<?php
require_once __DIR__ . '/../config/Database.php';

class WeightHistory {

    public static function findByUserId($userId, $limit = 10) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM weight_history 
             WHERE user_id = ? 
             ORDER BY recorded_at DESC 
             LIMIT ?"
        );
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLatest($userId) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM weight_history 
             WHERE user_id = ? 
             ORDER BY recorded_at DESC 
             LIMIT 1"
        );
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getPrevious($userId) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM weight_history 
             WHERE user_id = ? 
             ORDER BY recorded_at DESC 
             LIMIT 1 OFFSET 1"
        );
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($userId, $weight, $notes = null) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "INSERT INTO weight_history (user_id, weight_kg, notes) 
             VALUES (?, ?, ?)"
        );
        return $stmt->execute([$userId, $weight, $notes]);
    }

    public static function getProgress($userId, $days = 30) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM weight_history 
             WHERE user_id = ? 
             AND recorded_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             ORDER BY recorded_at ASC"
        );
        $stmt->execute([$userId, $days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function calculateDifference($userId) {
        $latest = self::getLatest($userId);
        $previous = self::getPrevious($userId);

        if (!$latest || !$previous) {
            return null;
        }

        return [
            'current' => $latest['weight_kg'],
            'previous' => $previous['weight_kg'],
            'difference' => round($latest['weight_kg'] - $previous['weight_kg'], 2),
            'percentage' => round((($latest['weight_kg'] - $previous['weight_kg']) / $previous['weight_kg']) * 100, 2),
            'days_between' => (new DateTime($latest['recorded_at']))->diff(new DateTime($previous['recorded_at']))->days
        ];
    }

    public static function getStats($userId) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT 
                MIN(weight_kg) as min_weight,
                MAX(weight_kg) as max_weight,
                AVG(weight_kg) as avg_weight,
                COUNT(*) as total_records
             FROM weight_history 
             WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
