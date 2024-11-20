<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'bengkels', 'name_customer', 'total_price'
    ];

    // Karna migration tidak bisa membaca tipe data array, jadi array di migration(json). agar nantinya bentuk bengkels tetap berupa array (tambah), jadi harus dipastikan dengan $cast
    protected $casts = [
        'bengkels' => 'array'
    ];
    public function user() {
        // menghubungkan ke primary keynya
        // dalam kurung merupakan nama model tempat penyimpanan dari PKnya si FK yang ada di model ini
        return $this->belongsTo(User::class);
    }
}
