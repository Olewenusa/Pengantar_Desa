<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengantar extends Model
{
    use HasFactory;

    protected $table = 'pengantar';

    protected $fillable = [
        'resident_id',
        'name',
        'NIK',
        'purpose',
        'date',
        'status_rt',
        'status_rw',
        'notes_rt',
        'notes_rw',
        'report_date'
    ];

    protected $casts = [
        'date' => 'date',
        'report_date' => 'datetime'
    ];

    // Relationship dengan residents
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Accessor untuk status keseluruhan
    public function getOverallStatusAttribute()
    {
        if ($this->status_rt === 'rejected' || $this->status_rw === 'rejected') {
            return 'rejected';
        }
        
        if ($this->status_rt === 'accepted' && $this->status_rw === 'accepted') {
            return 'completed';
        }
        
        if ($this->status_rt === 'accepted' && $this->status_rw === 'pending') {
            return 'waiting_rw';
        }
        
        return 'waiting_rt';
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_rt', $status)->orWhere('status_rw', $status);
    }

    // Scope untuk pending RT
    public function scopePendingRT($query)
    {
        return $query->where('status_rt', 'pending');
    }

    // Scope untuk pending RW
    public function scopePendingRW($query)
    {
        return $query->where('status_rt', 'accepted')->where('status_rw', 'pending');
    }
}