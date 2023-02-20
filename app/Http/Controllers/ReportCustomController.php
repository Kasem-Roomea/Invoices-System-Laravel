<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\section;
use Illuminate\Http\Request;

class ReportCustomController extends Controller
{
    public function index(){

        $sections = section::all();
        return view('report.customers_report',compact('sections'));
    }


    public function Search_customers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


            $invoices = invoice::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = section::all();
            return view('report.customers_report',compact('sections'))->withDetails($invoices);


        }



        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = section::all();
            return view('report.customers_report',compact('sections'))->withDetails($invoices);


        }



    }
}
