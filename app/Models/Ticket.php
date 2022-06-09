<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Ticket extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'title',
        'updated_at',
    ];

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, fn($query, $search)
            => $query->where(fn($query)
                => $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['client'] ?? false, fn($query, $client)
            => $query
                ->whereHas('client', fn($query)
                    => $query->where('name', $client)
            )
        );
    }

    public function agent() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function technicians() {
        return $this->belongsToMany(User::class, 'technicians_tickets', 'ticket_id', 'technician_id')->withTimestamps();
    }

}
