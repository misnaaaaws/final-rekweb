<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // use HasFactory;
    protected $table = "books";
    public $fillable = ["Judul", "Penulis", "Penerbit", "Tahun_Terbit"];
}
