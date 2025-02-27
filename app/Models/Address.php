<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 
        'address_type_id', 
        'street', 
        'city', 
        'state', 
        'zip'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    // Enable Address to Have Documents (e.g., Proof of Address)
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    
}
