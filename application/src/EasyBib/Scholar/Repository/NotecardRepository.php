<?php

namespace EasyBib\Scholar\Repository;

interface NotecardRepository
{
    /**
     * @param int $projectId
     * @return array
     */
    public function getAll($projectId);

    /**
     * @param int $notecardId 
     * @param array $data 
     * @return array
     */
    public function update($notecardId, array $data);
}
