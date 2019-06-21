<?php

namespace App\Http\Controllers;
use App\Stock;
use App\StockDetail;
use Faker\Generator as Faker;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;

class ManageStock extends Controller
{
    public function store(Request $request,Faker $faker){
        $input = $request->all();
        $total_pur = 0;
        $total_sell = 0;
        $total_qty = 0;
        foreach ($input['product'] as $value){
            $total_pur += $value['amount'];
            $total_sell += ($value['sell']*$value['qty']);
            $total_qty +=$value['qty'];
        }
        $stock = new Stock();
        $stock->total_pur_price = $total_pur;
        $stock->total_sell_price = $total_sell;
        $stock->total_qty = $total_qty;
        $stock->save();
        foreach ($input['product'] as $value){
            $product = new Product();
            $product->productName = $value['desc'];
            $product->category = 'គ្រឿងឡាន';
            $product->image = '/files/shares/mechanic.png';
            $product->save();
            if ($product){
                $variation = new Variation();
                $variation->product_id = $product->id;
                $variation->variationName = 'គ្រឿងឡាន';
                $variation->barcode = $faker->ean8;
                $variation->save();
                if ($stock && $variation){
                    $stock_detail = new StockDetail();
                    $stock_detail->stock_id = $stock->id;
                    $stock_detail->variation_id = $variation->id;
                    $stock_detail->qty = $value['qty'];
                    $stock_detail->remain_qty = $value['qty'];
                    $stock_detail->pur_price = $value['pur'];
                    $stock_detail->sell_price = $value['sell'];
                    $stock_detail->save();
                }
            }
        }
        if ($stock_detail){
            return redirect()->back();
        }
    }
}
