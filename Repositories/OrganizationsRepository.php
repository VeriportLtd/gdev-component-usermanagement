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
        $activeSubquery = '';
        $numericColumns = ['organizations.OrganizationId'];
        $groupableColumns = [];
        $joins = [];
        $rcJoins = [];
        $groupBy = 'organizations.OrganizationId';
        $requiredConditions = [];

        $countSelector = 'organizations.OrganizationId';

        $queries = OrganizationsRepository::PrepareDataTableQuery($start, $length, $cols, $groupableColumns, $numericColumns, $joins, $groupBy, $requiredConditions, $rcJoins, $countSelector);

        return OrganizationsRepository::executeDTQuery($queries);
    }
}