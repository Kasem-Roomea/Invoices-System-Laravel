<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Pages More Basic
    Auth::routes(['register' => false]);
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//End Pages More Basic


//Pages invoices
            Route::group(["namespace"=>'App\Http\Controllers'] , function (){

                //invoices view , edit , delete
                    Route::resource('/invoices', "InvoiceController");
                    Route::resource('/invoices_archive', "InvoiceArchiveController");
                    Route::get('Invoice_Paid','InvoiceController@Invoice_Paid');
                    Route::get('Invoice_UnPaid','InvoiceController@Invoice_UnPaid');
                    Route::get('Invoice_Partial','InvoiceController@Invoice_Partial');
                //start notification
                     Route::get('/marks_notification', "InvoiceController@marks_notification");
                //end  notification




                //start Oparation invoices
                    Route::get('edit_invoice/{id}', "InvoiceController@edit");
                    Route::get('Status_show/{id}', "InvoiceController@show")->name("Status_show");
                    Route::post('Status_Update', "InvoiceController@Status_Update")->name("Status_Update");
                    Route::post('invoice_archive', "InvoiceController@invoice_archive")->name("invoice_archive");
                    Route::get('Print_invoice/{id}', "InvoiceController@Print_invoice");
                //end Oparation invoices




                //start get products section select
                    Route::get('/section/{id}', "InvoiceController@AjaxSectionProduct");
                //end get products section select



                //start details invoices
                    Route::get('InvoiceDetails/edit/{id}', "InvoiceDetailsController@edit");
                //end details invoices



                //Files Oparation (Download , View , Delete , Add)
                    Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailsController@get_file');
                    Route::get('View_file/{invoice_number}/{file_name}', 'InvoiceDetailsController@open_file');
                    Route::post('delete_file', 'InvoiceDetailsController@destroy')->name('delete_file');
                    Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');
            });
 //End Pages invoices



//Pages Section\
    Route::group(["namespace"=>'App\Http\Controllers'] , function (){
        Route::resource('section', "SectionController");
    });
//End Pages Section


//Pages Product
    Route::group(["namespace"=>'App\Http\Controllers'] , function (){
        Route::resource('products', "ProductController");
    });

//End Pages Product



//Start Pages Report

Route::group(["namespace"=>'App\Http\Controllers'] , function (){

//report invoice
    Route::get('report_invoice', "ReportController@index");
    Route::post('/Search_invoices', "ReportController@search_invoices");
//report custom
    Route::get('/report_custom', "ReportCustomController@index");
    Route::post('/report_custom_search', "ReportCustomController@Search_customers");
});

//End Pages Report

//Start Permeation Role User
    Route::group(['middleware' => ['auth'] , "namespace"=>'App\Http\Controllers' ], function() {
        Route::resource('roles','UserManagement\RoleController');
        Route::resource('users','UserManagement\UserController');
    });
//End Permeation





//



    Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
