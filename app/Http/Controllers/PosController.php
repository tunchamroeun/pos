<?php

namespace App\Http\Controllers;

use App\StockDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PosController extends Controller
{
    public function sell_list(){
        $stock_detail = StockDetail::with('variation')->where('remain_qty','>=',1)->get();
        return DataTables::of($stock_detail)
            ->addColumn('action',function ($action){
                return '<button id="'.$action->id.'" class="ui mini button green add-to-inv"><i class="icon check"></i></button>';
            })
            ->editColumn('variation.product.productName',function ($proName){
                return '<a href="#">'.$proName->variation->product->productName.'</a>';
            })
            ->editColumn('created_at',function ($created_at){
                return $created_at->created_at->diffForHumans();
            })
            ->rawColumns(['variation.product.productName','action'])
            ->toJson();
    }
    public function sell_list_id(Request $request){
        $input = $request->all();
        $stock_details = StockDetail::with('variation')->where('id','=',$input['id'])->where('remain_qty','>=',1)->limit(1)->get();
        return view('sell.select_invoice',compact('stock_details'));
    }
}
