@extends('layouts.dashboard')
@section('title')
    បញ្ញីទំនិញ
@stop
@section('content')
    <div class="row">
        <div class="column">
            <form action="{{route('invoicing.reduce')}}" method="post" class="ui segments">
                <div class="ui segment">
                    {{csrf_field()}}
                    <table class="ui celled table">
                        <thead>
                        <tr>
                            <th class="single line">ល.រ / No</th>
                            <th class="single line">ឈ្មោះទំនិញ / Item Name</th>
                            <th class="single line">ចំនួនក្នុងស្តុក / Qty in Stock</th>
                            <th class="single line">ចំនួន / Qty</th>
                            <th class="single line">តម្លៃលក់ / List Price ($)</th>
                            <th class="single line">តម្លៃរុប / Total ($)</th>
                            <th>
                                <span class="ui mini button teal modalshow"><i class="icon add"></i></span>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="append-able-row">
                        <tr id="0" class="displaynone item-list"></tr>
                        {{--Append able row--}}
                        </tbody>
                        <tfoot class="hiddenui">
                        <tr>
                            <th colspan="5" class="single line right aligned">ថ្លៃឈ្នួល ($)</th>
                            <th class="single line">
                                <div class="ui input fluid m-0">
                                    <input required="required" id="income-note" name="income_note" class="rounded-0" type="number"​ step="any" min="0" value="1" placeholder="សរុប">
                                </div>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th class="single line right aligned">ចំនួនសរុប</th>
                            <th class="single line">
                                <div class="ui input fluid m-0">
                                    <input required="required" type="number" readonly id="total-qty" name="total_qty">
                                </div>
                            </th>
                            <th class="single line right aligned">សរុប / Grand Total ($)</th>
                            <th class="single line">
                                <div class="ui input fluid m-0">
                                    <input required="required" id="total" name="total" class="rounded-0" readonly type="number"​ step="any" placeholder="សរុប">
                                </div>
                            </th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="ui segment">
                    <button id="btn-invoicing" class="ui button olive disabled"><i class="icon save"></i>រក្សាទុក</button>
                </div>
            </form>
        </div>
    </div>
    <div class="ui small modal transition" style="margin-top: -100px;">
        <div class="header p-header">
            ជ្រើរើសទំនិញ
        </div>
        <div class="row">
            <div class="column">
                <div class="ui segment">
                    <table id="product_list" class="w-100 ui compact selectable striped celled table tablet stackable datatable">
                        <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>ឈ្មោះ</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                ចាកចេញ
            </div>
        </div>
    </div>
@stop
@push('css')
@endpush
@push('js')
    <script src="{{asset('sigware/plugins/datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('sigware/js/customjs/custom-datatable.js')}}"></script>
@endpush
@section('js')
    <script>
        $(function () {
            $('.menu .item').tab();
            let product = $('#product_list').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: '{{route('invoicing.stock')}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'variation.product.productName', name: 'variation.product.productName'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action',orderable:false,searchable:false}
                ],
            });
            $(document).on('click', '.modalshow', function () {
                $(".ui.modal").modal("show");
            });
            //change calculate
            $(document).on('change keyup keypress blur mousewheel', '#sell',function () {
                let amount_selector = $(this.parentNode.parentNode.parentNode).find('#amount');
                let qty_value = parseInt($(this.parentNode.parentNode.parentNode).find('#qty').val());
                let purchase = parseFloat($(this).val());
                amount_selector.val(parseFloat(qty_value*purchase).toFixed(2));
                //cal total
                calcTotal();
                //calcQty
                calcQty();
            });
            //qty
            $(document).on('change keyup keypress blur mousewheel', '#qty',function () {
                let amount_selector = $(this.parentNode.parentNode.parentNode).find('#amount');
                let sell_value = parseInt($(this.parentNode.parentNode.parentNode).find('#sell').val());
                let qty = parseFloat($(this).val());
                amount_selector.val(parseFloat(qty*sell_value).toFixed(2));
                //cal total
                calcTotal();
                //calcQty
                calcQty();
            });
            //remove row
            $(document).on('click','#remove-row',function () {
                $(this.parentNode.parentNode).remove();
                //cal total
                calcTotal();
                //calcQty
                calcQty();
            });
            function calcTotal() {
                let total = 0;
                let amount = document.querySelectorAll('#amount');
                $.each(amount,function (key,val) {
                    total +=parseFloat($(val).val());
                });
                $('#total').val(total.toFixed(2));
            }
            function calcQty() {
                let total = 0;
                let qty = document.querySelectorAll('#qty');
                $.each(qty,function (key,val) {
                    total +=parseFloat($(val).val());
                });
                $('#total-qty').val(total);
            }
            $(document).on('click','.add-to-inv',function () {
                let stock_id = parseInt($(this).attr('id'));
                $.ajax({
                    method: 'get',
                    type: 'html',
                    data: {
                        '_token':'{{csrf_token()}}',
                        'id':stock_id,
                    },
                    url:'{{route('invoicing.select')}}',
                    success:function (data) {
                        let ids = [];
                        let item_lists = document.querySelectorAll('.item-list');
                        $.each(item_lists,function (key,value) {
                            ids.push(parseInt($(value).attr('id')));
                        });
                        if (ids.indexOf(stock_id) < 1) {
                            $('#append-able-row').append(data);
                            $('#btn-invoicing').removeClass('disabled');
                            //cal total
                            calcTotal();
                            //calcQty
                            calcQty();
                        }

                    }
                })
            })
        })
    </script>
@stop
