<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'invoice_number',
        'product',
        'Section',
        'Status',
        'Value_Status',
        'Payment_Date',
        'note',
        'user'
    ];

    public function invoice()
    {
        return $this->belongsTo("App\Models\invoice" , "id_Invoice");
    }
}
