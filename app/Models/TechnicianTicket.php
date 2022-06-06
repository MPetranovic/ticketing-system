<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TechnicianTicket extends Pivot
{
    public $table = 'technicians_tickets';

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
}
