<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomImage extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'image',
        'room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
