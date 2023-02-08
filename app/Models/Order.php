<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $fillable = [
        'has_been_paid',
        'user_id',
        'orderDate',
        'total_price',
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
