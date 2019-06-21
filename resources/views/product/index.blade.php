@extends('layouts.dashboard')
@section('title')
    បញ្ញីទំនិញ
@stop
@section('content')
    <div class="row">
        <div class="column">
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="product-list"><i class="icon cubes"></i>បញ្ជីទំនិញ</a>
                <a class="item" data-tab="add-new-product"><i class="icon add"></i>បន្ថែមទំនិញ</a>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="product-list">
                <div class="ui segments stacked">
                    <div class="ui segment">
                        <h5 class="ui header">
                            បញ្ញីទំនិញ
                        </h5>
                    </div>
                    <div class="ui segment">
                        <table id="product_list"
                               class="ui compact selectable striped celled table tablet stackable datatable">
                            <thead>
                            <tr>
                                <th>ល.រ</th>
                                <th></th>
                                <th>ឈ្មោះ</th>
                                <th>ប្រភេទ</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ui bottom attached tab segment" data-tab="add-new-product">
                <form action="{{route('manage.stock.store')}}" method="post" class="ui segments">
                    <div class="ui segment">
                        {{csrf_field()}}
                        <table class="ui celled table">
                            <thead>
                            <tr>
                                <th class="single line">ល.រ / No</th>
                                <th class="single line">បរិយាយ / Description</th>
                                <th class="single line">ចំនួន / Quantity</th>
                                <th class="single line">តម្លៃទិញចូល / Purchase ($)</th>
                                <th class="single line">តម្លៃលក់ចេញ / Sell ($)</th>
                                <th class="single line">តម្លៃរុប / Total ($)</th>
                                <th>
                                    <span class="ui mini button teal" id="add-row"><i class="icon add"></i></span>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="append-able-row">
                            <tr>
                                <td class="p-1">1</td>
                                <td class="p-1">
                                    <div class="ui input fluid m-0">
                                        <input required name="product[0][desc]" class="rounded-0" type="text"
                                               placeholder="បរិយាយ">
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="ui input fluid m-0">
                                        <input required id="qty" name="product[0][qty]" class="rounded-0" type="number"
                                               placeholder="ចំនួន">
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="ui input fluid m-0">
                                        <input required id="purchase" name="product[0][pur]" class="rounded-0" type="number" step="any"
                                               placeholder="តម្លៃទិញចូល">
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="ui input fluid m-0">
                                        <input required name="product[0][sell]" class="rounded-0" type="number" step="any"
                                               placeholder="តម្លៃលក់ចេញ">
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="ui input fluid m-0">
                                        <input required id="amount" name="product[0][amount]" readonly class="rounded-0" type="number"
                                               step="any" placeholder="តម្លៃរុប">
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                            <tfoot class="hiddenui">
                            <tr>
                                <th colspan="4"></th>
                                <th class="single line right aligned">សរុប / Grand Total ($)</th>
                                <th class="single line">
                                    <div class="ui input fluid m-0">
                                        <input required id="total" name="total" class="rounded-0" readonly type="number"​ step="any" placeholder="សរុប">
                                    </div>
                                </th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="ui segment">
                        <button class="ui button olive"><i class="icon save"></i>រក្សាទុក</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="ui standard test modal transition" style="margin-top: -234px;">
        <div class="header p-header">
        </div>
        <div class="ui grid">
            <div class="row m-2">
                <div class="five wide column">
                    <img class="p-image">
                </div>
                <div class="eleven wide column">
                    <table class="ui compact celled definition table tablet stackable">
                        <thead>
                        <tr>
                            <th colspan="2">
                                ពត៌មានទំនិញទូទៅ
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="right aligned">
                                ឈ្មោះទំនិញ
                            </td>
                            <td class="p-name">
                            </td>
                        </tr>
                        <tr>
                            <td class="right aligned">
                                ប្រភេទទំនិញ
                            </td>
                            <td class="p-category">
                            </td>
                        </tr>
                        <thead>
                        <tr>
                            <th colspan="2">
                                បម្រែបម្រួលទំនិញ
                            </th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="right aligned">
                                តម្លៃប្រែប្រួល
                            </td>
                            <td>
                                <table class="ui compact celled table tablet stackable">
                                    <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>តម្លៃ</th>
                                    </tr>
                                    </thead>
                                    <tbody id="p-variations">
                                    <tr>
                                        <td>328248</td>
                                        <td>XL</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
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
                    url: '{{route('product.json')}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image', orderable: false, searchcable: false},
                    {data: 'productName', name: 'productName'},
                    {data: 'category', name: 'category'},
                    {data: 'action', name: 'action'}
                ],
            });
            $(document).on('click', '.modalshow', function () {
                let product_id = $(this).attr('id');
                product_id = product_id.replace('product-', '');
                product_id = parseInt(product_id);
                $.ajax({
                    type: 'get',
                    url: '{{route('product.view.json')}}',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'product_id': product_id,
                    },
                    success: function (data) {
                        console.log(data);
                        $('.p-header').html(data.productName);
                        $('.p-name').html(data.productName);
                        $('.p-category').html(data.category);
                        $('.p-image').attr('src', '{{asset('/')}}' + data.image);
                        let variation_row = [];
                        $.each(data.variations, function (key, value) {
                            variation_row.push('<tr>\n' +
                                '                                        <td>' + value.barcode + '</td>\n' +
                                '                                        <td>' + value.variationName + '</td>\n' +
                                '                                    </tr>');
                        });
                        $('#p-variations').html(variation_row);
                    }
                });
                $(".ui.modal").modal({
                    inverted: true,
                    blurring: false
                }).modal("show");
            });
            //Manage Stock
            let i = 1;
            $(document).on('click', '#add-row', function () {
                $('#append-able-row').append(`<tr>
                                                    <td class="p-1">${i + 1}</td>
                                                    <td class="p-1">
                                                        <div class="ui input fluid m-0">
                                                            <input required name="product[${i}][desc]" class="rounded-0" type="text" placeholder="បរិយាយ">
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <div class="ui input fluid m-0">
                                                            <input required id="qty" name="product[${i}][qty]" class="rounded-0" type="number" placeholder="ចំនួន">
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <div class="ui input fluid m-0">
                                                            <input required id="purchase" name="product[${i}][pur]" class="rounded-0" type="number" step="any" placeholder="តម្លៃទិញចូល">
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <div class="ui input fluid m-0">
                                                            <input required name="product[${i}][sell]" class="rounded-0" type="number" step="any" placeholder="តម្លៃលក់ចេញ">
                                                        </div>
                                                    </td>
                                                    <td class="p-1">
                                                        <div class="ui input fluid m-0">
                                                            <input required id="amount" name="product[${i}][amount]" readonly class="rounded-0" type="number" step="any" placeholder="តម្លៃរុប">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span id="remove-row" class="ui mini button pink"><i class="icon remove"></i></span>
                                                    </td>
                                            </tr>`);
                i++;
            });
            //change calculate
            $(document).on('change keyup keypress blur', '#purchase',function () {
                let amount_selector = $(this.parentNode.parentNode.parentNode).find('#amount');
                let qty_value = parseInt($(this.parentNode.parentNode.parentNode).find('#qty').val());
                let purchase = parseFloat($(this).val());
                amount_selector.val(parseFloat(qty_value*purchase).toFixed(2));
                //cal total
                calcTotal();
            });
            //qty
            $(document).on('change keyup keypress blur', '#qty',function () {
                let amount_selector = $(this.parentNode.parentNode.parentNode).find('#amount');
                let purchase_value = parseInt($(this.parentNode.parentNode.parentNode).find('#purchase').val());
                let qty = parseFloat($(this).val());
                amount_selector.val(parseFloat(qty*purchase_value).toFixed(2));
                //cal total
                calcTotal();
            });
            //remove row
            $(document).on('click','#remove-row',function () {
               $(this.parentNode.parentNode).remove();
                //cal total
                calcTotal();
            });
            function calcTotal() {
                let total = 0;
                let amount = document.querySelectorAll('#amount');
                $.each(amount,function (key,val) {
                    total +=parseFloat($(val).val());
                });
                $('#total').val(total.toFixed(2));
            }
        })
    </script>
@stop
