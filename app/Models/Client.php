<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use HasFactory, Notifiable, Sortable;

    public $sortable = [
        'name',
    ];

    protected $guarded = [];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
