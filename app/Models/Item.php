<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description',
        'unit'
    ];

    public function requestDetails()
    {
        return $this->hasMany(RequestDetail::class);
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }
}
