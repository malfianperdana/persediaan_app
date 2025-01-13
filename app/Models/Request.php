<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'request_number'];

    protected static function booted()
    {
        static::creating(function ($request) {
            $latestRequest = self::latest('id')->first();
            $nextNumber = $latestRequest ? (int)substr($latestRequest->request_number, 3) + 1 : 1;
            $request->request_number = 'REQ' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(RequestDetail::class);
    }
}
