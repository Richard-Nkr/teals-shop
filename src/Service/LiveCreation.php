<?php

namespace App\Service;

use App\Entity\Live;

class LiveCreation
{
    public function addLive(Live $live): Live
    {
        $live->setDateDebut(new \DateTime());
        return $live;
    }


}