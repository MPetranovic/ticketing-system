<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, fn($query, $search)
            => $query->where(fn($query)
                => $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
            )
        );

        // $query->when($filters['client'] ?? false, fn($query, $client)
        //     => $query
        //         ->whereHas('client', fn($query)
        //             => $query->where('name', $client)
        //     )
        // );
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

    public function technician() {
        return $this->belongsTo(Technician::class);
    }

}
