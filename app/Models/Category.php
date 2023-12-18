<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $guarded = ['id'];

    public function booking(){
        return $this->hasMany(Booking::class);
    }
}
