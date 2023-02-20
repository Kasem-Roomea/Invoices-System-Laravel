<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoice_all = invoice::count();
        $invoice_count_1 = invoice::where('Value_Status' , '1' )->count();
        $invoice_count_2 = invoice::where('Value_Status' , '2' )->count();
        $invoice_count_3 = invoice::where('Value_Status' , '3' )->count();
        $invoice_all_sum = invoice::sum('Amount_collection');
        $invoice_count_sum1 = invoice::where('Value_Status' , '1' )->sum('Amount_collection');
        $invoice_count_sum2 = invoice::where('Value_Status' , '2' )->sum('Amount_collection');
        $invoice_count_sum3 = invoice::where('Value_Status' , '3' )->sum('Amount_collection');
        if($invoice_all==0)
        {
            $invoice_percent1 = 0;
            $invoice_percent2 = 0;
            $invoice_percent3 = 0;
        }
        else
            {
                $invoice_percent1 = round($invoice_count_1/$invoice_all*100);
                $invoice_percent2 = round($invoice_count_2/$invoice_all*100);
                $invoice_percent3 = round($invoice_count_3/$invoice_all*100);
            }




        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$invoice_percent2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$invoice_percent1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$invoice_percent3]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$invoice_percent2, $invoice_percent1,$invoice_percent3]
                ]
            ])
            ->options([]);

        return view('home' , compact('invoice_all' , 'invoice_count_1' , 'invoice_count_2' ,
            'invoice_count_3' , 'invoice_all_sum' ,
            'invoice_count_sum1' , 'invoice_count_sum2' ,
            'invoice_count_sum3' , 'invoice_percent1' ,
            'invoice_percent2' , 'invoice_percent3' , 'chartjs' , 'chartjs_2'));
    }
}
