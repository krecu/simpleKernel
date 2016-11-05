<?php

namespace StatsApp\Repository;

use Core\Database\Repository;

class StatsRepository extends Repository {
    public static $table = 'stats';
    public static $model = 'StatsApp\Model\StatsModel';
}