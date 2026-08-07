<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UsesYearSql
{
    /**
     * Returns the appropriate SQL expression for extracting the year from created_at,
     * compatible with both SQLite and MySQL/MariaDB.
     */
    protected function yearSql(): string
    {
        return DB::getDriverName() === 'sqlite'
            ? "strftime('%Y', created_at)"
            : 'YEAR(created_at)';
    }

    /**
     * Returns a SQL expression that produces a 'YYYY-MM' string from created_at,
     * compatible with both SQLite and MySQL/MariaDB. Cocok untuk agregasi bulanan.
     */
    protected function yearMonthSql(): string
    {
        return DB::getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";
    }
}
