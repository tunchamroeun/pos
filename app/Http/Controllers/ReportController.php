<?php

namespace App\Http\Controllers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\IncomeNote;
use App\Invoice;
use App\InvoiceDetail;
use App\Stock;
use App\StockDetail;
use App\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function report_income_expense(){
        return view('report.income-expense');
    }
    public function report_import_export(){
        return view('report.import-export');
    }
    //Stock
    function stock_report_data(Request $request){
        $input = $request->all();
        $start = Carbon::parse($input['start']);
        $end = Carbon::parse($input['end']);
        $start = date_format($start,'Y-m-d');
        $end = date_format($end,'Y-m-d');
        $end = Carbon::create($end)->addDay(1);
        $stockData = Stock::all()->whereBetween('created_at',[$start,$end]);
        $totalPurchase = 0;
        $totalQty = 0;
        foreach ($stockData as $value){
            $totalPurchase +=$value['total_pur_price'];
            $totalQty +=$value['total_qty'];
        }
        return[
            'totalPur'=>$totalPurchase,
            'totalQty'=>$totalQty,
        ];
    }
    function stock_report_data_detail(Request $request){
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $input = $request->all();
        $start = Carbon::parse($input['range']['start']);
        $end = Carbon::parse($input['range']['end']);
        $start = date_format($start,'Y-m-d');
        $end = date_format($end,'Y-m-d');
        $end = Carbon::create($end)->addDay(1);
        $stockData = Stock::all()->whereBetween('created_at',[$start,$end]);
        return DataTables::of($stockData)
            ->editColumn('created_at',function ($date){
                return $date->created_at->diffForHumans();
            })
            ->editColumn('total_pur_price',function ($total_pur_price){
                return new Money($total_pur_price->total_pur_price, new Currency('USD'), true);
            })
            ->addColumn('action',function ($action){
                return '<button class="ui button mini olive btn-detail" id="'.$action->id.'"><i class="icon eye"></i></button>';
            })
            ->toJson();
    }
    function stock_report_detail(Request $request){
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $input = $request->all();
        $stockData = StockDetail::with('variation')->where('stock_id',$input['data']['id'])->get();
        return DataTables::of($stockData)
            ->editColumn('variation.product.image',function ($img){
                return '<img class="ui image avatar" src="'.asset($img->variation->product->image).'" alt="">';
            })
            ->editColumn('created_at',function ($date){
                return $date->created_at->diffForHumans();
            })
            ->editColumn('pur_price',function ($pur){
                return new Money($pur->pur_price, new Currency('USD'), true);
            })
            ->rawColumns(['variation.product.image'])
            ->toJson();
    }
    //invoice
    function invoice_report_data(Request $request){
        $input = $request->all();
        $start = Carbon::parse($input['start']);
        $end = Carbon::parse($input['end']);
        $start = date_format($start,'Y-m-d');
        $end = date_format($end,'Y-m-d');
        $end = Carbon::create($end)->addDay(1);
        $stockData = Invoice::all()->whereBetween('created_at',[$start,$end]);
        $incomeNotekData = IncomeNote::all()->whereBetween('created_at',[$start,$end]);
        $totalAmount = 0;
        $totalQty = 0;
        foreach ($stockData as $value){
            $totalAmount +=$value['total_amount'];
            $totalQty +=$value['total_qty'];
        }
        $totalNoteAmount = 0;
        foreach ($incomeNotekData as $value){
            $totalNoteAmount +=$value['amount'];
        }
        return[
            'totalAmount'=>$totalAmount+$totalNoteAmount,
            'totalQty'=>$totalQty,
        ];
    }
    function invoice_report_data_detail(Request $request){
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $input = $request->all();
        $start = Carbon::parse($input['range']['start']);
        $end = Carbon::parse($input['range']['end']);
        $start = date_format($start,'Y-m-d');
        $end = date_format($end,'Y-m-d');
        $end = Carbon::create($end)->addDay(1);
        $stockData = Invoice::all()->whereBetween('created_at',[$start,$end]);
        return DataTables::of($stockData)
            ->editColumn('created_at',function ($date){
                return $date->created_at->diffForHumans();
            })
            ->editColumn('total_amount',function ($total_amount){
                return new Money($total_amount->total_amount, new Currency('USD'), true);
            })
            ->addColumn('action',function ($action){
                return '<button class="ui button mini olive btn-detail-sell" id="'.$action->id.'"><i class="icon eye"></i></button>';
            })
            ->toJson();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    function invoice_report_detail(Request $request){
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $input = $request->all();
        $stockData = InvoiceDetail::with('stock_detail')->where('invoice_id',$input['data']['id'])->get();
        return DataTables::of($stockData)
            ->editColumn('stock_detail.variation.product.image',function ($img){
                return '<img class="ui image avatar" src="'.asset($img->stock_detail->variation->product->image).'" alt="">';
            })
            ->editColumn('created_at',function ($date){
                return $date->created_at->diffForHumans();
            })
            ->editColumn('amount',function ($pur){
                return new Money($pur->amount, new Currency('USD'), true);
            })
            ->rawColumns(['stock_detail.variation.product.image'])
            ->toJson();
    }
    //show income note
    public function show_income_note(Request $request){
        $input = $request->all();
        return IncomeNote::where('invoice_id',$input['data']['id'])->get();
    }
    //index check stock
    public function check_stock_index(){
        return view('report.check-stock');
    }
    //Report stock
    public function check_stock(){
        $outOrNotYetImportStock = Variation::with(['check_stock_detail','product'])->whereDoesntHave('check_stock_detail')->get();
        return DataTables::of($outOrNotYetImportStock)
            ->editColumn('product.image',function ($image){
                return '<img class="ui image avatar" src="'.asset($image->product->image).'" alt="">';
            })
            ->editColumn('created_at',function ($created_at){
                return $created_at->created_at->diffForHumans();
            })
            ->addColumn('note',function (){
                return '<div class="ui label pink">
                           <i class="bell icon"></i> មិនទាន់មានក្នុងស្តុក
                        </div>';
            })
            ->rawColumns(['product.image','note'])
            ->toJson();
    }
    public function check_stock_notification(){
        $notification_html = Variation::with(['check_stock_detail','product'])->whereDoesntHave('check_stock_detail')->get();
        $notification_count = Variation::with(['check_stock_detail','product'])->whereDoesntHave('check_stock_detail')->count();
        $html = view('report.notification',compact('notification_html'));
        return [
            'count'=>$notification_count,
            'html'=>$html->render()
        ];
    }
    public function dd(){

    }
}
