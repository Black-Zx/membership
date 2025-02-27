<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'referral_code', 
        'status',
        'referred_by'
    ];


    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function referrer()
    {
        return $this->belongsTo(Member::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(Member::class, 'referred_by');
    }

    public static function getStatuses()
    {
        return ['pending', 'approved', 'rejected', 'terminated'];
    }
}
