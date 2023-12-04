<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;
public static function isStockAvailable($product_id, $size)
{
    $getProductStock = ProductsAttribute::select('stock')->where('product_id', $product_id)->where('size', $size)->first();
    if ($getProductStock) {
        return $getProductStock->stock;
    } else {
        return 0; // ou une autre valeur de votre choix en cas de non-disponibilité du stock
    }
}

}
