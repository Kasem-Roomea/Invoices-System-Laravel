<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_attachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'invoice_number',
        'Created_by',
        'invoice_id',
    ];

    public function invoice()
    {
        return $this->belongsTo("App\Models\invoice" , "invoice_id");
    }
}
