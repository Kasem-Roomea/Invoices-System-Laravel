<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class invoice extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'note',
        'user',
        'due_date'
    ];

    protected $dates = ['deleted_at'];

    public function sections()
    {
        return $this->belongsTo("App\Models\section" , "section_id" , "id");
    }
}
