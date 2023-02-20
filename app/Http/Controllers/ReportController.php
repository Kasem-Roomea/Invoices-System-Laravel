<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\section;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.invoices_report');
    }

    public function search_invoices(Request $request)
    {
        $radio = $request->rdio;


        //search with status payment and date
        if ($radio == 1) {


            if ($request->type && $request->start_at =='' && $request->end_at =='') {

                $invoices = invoice::select('*')->where('status','=',$request->type)->get();
                $type = $request->type;
                return view('report.invoices_report',compact('type'))->withDetails($invoices);
            }

            else
                {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('status','=',$request->type)->get();
                return view('report.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);

            }



        }
        else {

            $invoices = invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('report.invoices_report')->withDetails($invoices);

        }





    }


}
