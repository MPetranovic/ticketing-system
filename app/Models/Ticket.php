<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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
