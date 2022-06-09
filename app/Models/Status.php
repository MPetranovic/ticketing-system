<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Status extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'status',
    ];

    public function tickets() {
        return $this->hasOne(Ticket::class);
    }

}
