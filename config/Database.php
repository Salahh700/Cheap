<?php
/**
 * ========================================
 * CLASSE DATABASE - GESTION DES CONNEXIONS
 * ========================================
 * Singleton pattern pour gérer la connexion PDO
 */

class Database {
    private static $instance = null;
    private $pdo;

    /**
     * Constructeur privé (Singleton)
     */
    private function __construct() {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];

            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            logger('Database connection established successfully', 'info');

        } catch (PDOException $e) {
            logger('Database connection failed: ' . $e->getMessage(), 'error');

            if (APP_DEBUG) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            } else {
                die('Erreur de connexion à la base de données. Veuillez contacter l\'administrateur.');
            }
        }
    }

    /**
     * Obtenir l'instance unique de la classe
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtenir la connexion PDO
     */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Empêcher le clonage de l'instance
     */
    private function __clone() {}

    /**
     * Empêcher la désérialisation de l'instance
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    /**
     * SELECT - Récupérer plusieurs lignes
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            logger('Query error: ' . $e->getMessage() . ' | SQL: ' . $sql, 'error');
            throw $e;
        }
    }

    /**
     * SELECT - Récupérer une seule ligne
     */
    public function queryOne($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            logger('QueryOne error: ' . $e->getMessage() . ' | SQL: ' . $sql, 'error');
            throw $e;
        }
    }

    /**
     * INSERT/UPDATE/DELETE - Exécuter une requête
     */
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            logger('Execute error: ' . $e->getMessage() . ' | SQL: ' . $sql, 'error');
            throw $e;
        }
    }

    /**
     * INSERT - Insérer et retourner le dernier ID
     */
    public function insert($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            logger('Insert error: ' . $e->getMessage() . ' | SQL: ' . $sql, 'error');
            throw $e;
        }
    }

    /**
     * Commencer une transaction
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    /**
     * Valider une transaction
     */
    public function commit() {
        return $this->pdo->commit();
    }

    /**
     * Annuler une transaction
     */
    public function rollback() {
        return $this->pdo->rollback();
    }

    /**
     * Compter le nombre de lignes
     */
    public function count($table, $where = '', $params = []) {
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }

        $result = $this->queryOne($sql, $params);
        return (int) $result['count'];
    }

    /**
     * Vérifier si une ligne existe
     */
    public function exists($table, $where, $params = []) {
        return $this->count($table, $where, $params) > 0;
    }
}

/**
 * Helper global pour obtenir la connexion DB
 */
function db() {
    return Database::getInstance();
}

/**
 * Helper global pour obtenir la connexion PDO
 */
function pdo() {
    return Database::getInstance()->getConnection();
}
