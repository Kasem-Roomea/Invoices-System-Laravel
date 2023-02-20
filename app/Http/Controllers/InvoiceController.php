<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_attachments;
use App\Models\invoice_details;
use App\Models\section;
use App\Models\User;
use App\Notifications\Add_invoices;
use App\Notifications\InvoiceAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Finder\in;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index','store']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show' , 'Status_Update']]);
        $this->middleware('permission:طباعة الفاتورة', ['only' => ['Print_invoice']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['invoice_archive']]);
    }

    public function index()
    {
        $invoices = invoice::all();
        return view("invoices.invoices" , compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = section::all();
        return view("invoices.add_invoice" , compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => date('Y-m-d') ,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoice::latest()->first()->id;
        invoice_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        //send mail
        // $user = User::first();
        // Notification::send($user, new InvoiceAdd($invoice_id));

        $invoice_notification  = invoice::latest()->first();
        $user = User::get();
        Notification::send($user, new Add_invoices($invoice_notification));




        session()->flash('add' , "تم الأضافة بنجاح");
        return redirect('invoices/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sections = section::all();
        $invoice = invoice::where("id",$id)->first();
       return view('invoices.invoice_status_show' , compact('invoice' , 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = invoice::where("id" , $id)->first();
        $sections = section::all();

        return view('invoices.invoice_edit' , compact('sections' , 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


            $invoice = invoice::find($request->id);
            $invoice_attachment = invoice_attachments::where('invoice_id' , $request->id)->get();
            $invoice_details  = invoice_details::where('id_invoice' , $request->id)->first();


            foreach ($invoice_attachment as $attach)
            {
                $attach->update([
                    'invoice_number' => $request->invoice_number
                ]);
            }

        $invoice_details->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'note' => $request->note,
        ]);

        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        session()->flash('edit_invoice' , "تم التعديل بنجاح");
        return redirect('/invoices');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


            $invoice = invoice::findOrFail($request->invoice_id);

            Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);

            // force Delete
            $invoice->forceDelete();
            session()->flash('delete');
            return back();



    }


    public function AjaxSectionProduct($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    public function Status_Update(Request $request)
    {
        $invoice = invoice::find($request->id);

        if($request->Status =="مدفوعة")
        {
                $value_status = 1;
        }
        else
            {
                $value_status = 3;
            }




        $invoice->update([
            'status' => $request->Status,
            'value_status' => $value_status,
            'Payment_Date' => $request->Payment_Date
        ]);

        invoice_details::create([
            'id_Invoice' => $request->id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => $value_status,
            'Payment_Date' => $request->Payment_Date,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        session()->flash('chang_status');
        return redirect("/invoices");

    }

    public function invoice_archive(Request $request)
    {
        $invoice = invoice::findOrFail($request->invoice_id);

        // archive  Delete
        $invoice->Delete();
        session()->flash('archive_invoice');
        return back();
    }


    public function Print_invoice($id)
    {
        $invoices = invoice::where("id" , $id)->first();
        return view("invoices.Print_invoice" , compact('invoices'));
    }

    public function marks_notification()
    {
        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return back();
    }

    public function Invoice_Paid()
    {
        $invoices = Invoice::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoice::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoice::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }





}
