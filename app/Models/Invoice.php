<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'type',
    'paid',
    'payment_date',
    'value'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
