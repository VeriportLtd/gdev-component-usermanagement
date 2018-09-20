<?php

namespace Gdev\UserManagement\Repositories;

use Data\Repositories\BaseRepository;
use DataTablesHelper;

/**
 * Class RolesRepository
 * @package Gdev\UserManagement\Repositories
 */
class OrganizationsRepository extends BaseRepository
{

    const Model = 'Gdev\UserManagement\Models\Organization';

    public static function GetFilteredList($start, $length, $columns, $order, $search)
    {
        $booleanColumns = [];

        $cols = DataTablesHelper::GetParameters($columns, $order, $search);
        $numericColumns = [];
        $groupableColumns = [];
        $joins = [];

        $groupBy = null;
        $rc =[];
        $rcJoins = [];

        $queries = static::PrepareDataTableQuery($start, $length, $cols, $groupableColumns, $numericColumns, $joins, $groupBy, $rc, $rcJoins);

        return static::executeDTQuery($queries);
    }
}