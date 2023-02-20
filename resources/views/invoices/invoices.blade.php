@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    قائمة الفواتير
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/قائمة الفواتير</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- start action delete invoices -->
    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- end action delete invoices -->

    <!-- start action update invoices -->
    @if (session()->has('edit_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تعديل الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- end action update invoices -->

    <!-- start action update status invoices -->
    @if (session()->has('chang_status'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تعديل حالة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- end action update status invoices -->

    <!-- start action archive  invoices -->
    @if (session()->has('archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم أرشفة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- end action archive invoices -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">

                                @can('اضافة فاتورة')
                                    <a  href="invoices/create" class="btn btn-info x-small text-white" ><i class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a><br><br>
                                @endcan

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>المنتج</th>
                                <th>القسم</th>
                                <th>الخصم</th>
                                <th>نسبة الضريبة</th>
                                <th>قيمة الضريبة</th>
                                <th>الاجمالي</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $i = 0;
                            @endphp

                            @foreach($invoices as $invoice)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td><a href="{{url('InvoiceDetails/edit',$invoice->id)}}">{{$invoice->invoice_number}}</a></td>
                                    <td>{{$invoice->invoice_Date}}</td>
                                    <td>{{$invoice->Due_date}}</td>
                                    <td>{{$invoice->product}}</td>
                                    <td>{{$invoice->sections->section_name}}</td>
                                    <td>{{$invoice->Discount}}</td>
                                    <td>{{$invoice->Value_VAT}}</td>
                                    <td>{{$invoice->Rate_VAT}}</td>
                                    <td>{{$invoice->Total}}</td>
                                    <td>
                                        @if($invoice->Value_Status==1)
                                            <span class="text-success">{{$invoice->Status}}</span>
                                        @endif

                                        @if($invoice->Value_Status==2)
                                                <span class="text-danger">{{$invoice->Status}}</span>
                                        @endif

                                        @if($invoice->Value_Status==3)
                                                <span class="text-warning">{{$invoice->Status}}</span>
                                        @endif
                                    </td>
                                    <td>{{$invoice->note}}</td>
                                    <td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13 " >

                                                @can('تعديل الفاتورة')
                                                    <a class="dropdown-item"
                                                       href=" {{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل
                                                        الفاتورة</a>

                                                @endcan

                                                @can('حذف الفاتورة')
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                           data-toggle="modal" data-target="#delete_invoice"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                            الفاتورة</a>
                                                @endcan


                                                 @can('تغير حالة الدفع')
                                                        <a class="dropdown-item"
                                                           href="{{ URL::route('Status_show', [$invoice->id]) }}"><i
                                                                class=" text-success fas                                                                                                                                                                                                                                                                                                                                                                                                                                                                        fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                            حالة
                                                            الدفع</a>
                                                 @endcan


                                                 @can('ارشفة الفاتورة')
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                           data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                            الارشيف</a>
                                                 @endcan


                                                 @can('طباعة الفاتورة')
                                                        <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                                class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                            الفاتورة
                                                        </a>
                                                 @endcan

                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--/div-->



        <!--  start modola delet invoice -->
            <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ url('invoices/destroy') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}

                    <div class="modal-body">
                        هل انت متاكد من عملية الحذف ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- row closed -->
    </div>
        <!--  End modola delet invoice -->


        <!--  start modola archive invoice -->
        <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('invoice_archive') }}" method="post">
                        {{ csrf_field() }}

                    <div class="modal-body">
                        هل انت متاكد من عملية الارشفة ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="hidden" name="id_page" id="id_page" value="2">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تاكيد</button>
                    </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <!--  end modola archive invoice -->


    <!-- Container closed -->
    </div>
    <!-- main-content closed -->


@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>


    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
