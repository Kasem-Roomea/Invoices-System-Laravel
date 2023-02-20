<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'description',
        'section_id'
    ];

    public function sections()
    {
        return  $this->belongsTo("App\Models\section" , "section_id" );
    }
}
