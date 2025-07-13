<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukHukum extends Model
{
    use HasFactory;

    protected $table = 'produkhukum';

    protected $fillable = [
        'no_peraturan',
        'judul',
        'category_id',
        'tanggal_penetapan',
        'tanggal_diundangkan',
        'no_lembaran_daerah',
        'file_produk_hukum',
        'dibaca'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
