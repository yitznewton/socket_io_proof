<?php

namespace EasyBib\Scholar\Repository;

use PDO;

class SqlNotecardRepository implements NotecardRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:/vagrant/application/scholar.sqlite3');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param int $projectId
     * @return array
     */
    public function getAll($projectId)
    {
        $projectId = $this->sanitizeId($projectId);
        $q = 'SELECT id, text FROM notecard WHERE project_id = ?';
        $stmt = $this->pdo->prepare($q);
        $stmt->execute([$projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $notecardId
     * @param array $data 
     * @return array
     */
    public function update($notecardId, array $data)
    {
        $text = isset($data['text']) ? $data['text'] : '';
        $notecardId = $this->sanitizeId($notecardId);
        $q = 'UPDATE notecard SET text = ? WHERE id = ?';
        $stmt = $this->pdo->prepare($q);
        $stmt->execute([$text, $notecardId]);

        $q = 'SELECT id, text, project_id FROM notecard WHERE id = ?';
        $stmt = $this->pdo->prepare($q);
        $stmt->execute([$notecardId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function sanitizeId($rawId)
    {
        return (int) $rawId;
    }
}
