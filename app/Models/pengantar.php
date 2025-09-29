<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pengantar extends Model
{
    use HasFactory;
    protected $table = 'pengantar';
    
    protected $fillable = [
        'user_id',  // TAMBAHKAN INI
        'resident_id', 
        'name', 
        'NIK', 
        'purpose', 
        'date',
        'status_rt', 
        'status_rw', 
        'notes_rt', 
        'notes_rw'
    ];

    protected $casts = [
        'date' => 'date',
        'report_date' => 'datetime',
    ];

    public function resident()
    {
        // Mengatakan bahwa 'resident_id' di tabel pengantar
        // terhubung ke 'id' di tabel users.
        return $this->belongsTo(User::class, 'resident_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePendingRT($query)
    {
        return $query->where('status_rt', 'pending');
    }

    public function scopePendingRW($query)
    {
        return $query->where('status_rt', 'accepted')->where('status_rw', 'pending');
    }
}