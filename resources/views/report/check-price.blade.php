@extends('layouts.dashboard')
@section('title')
    បញ្ជីតម្លៃទំនិញ
@stop
@section('content')
    <div class="row">
        <div class="column">
            <div class="ui segments stacked">
                <div class="ui segment">
                    <h5 class="ui header">
                        បញ្ជីតម្លៃទំនិញ
                    </h5>
                </div>
                <div class="ui segment">
                    <table id="user_list" class="ui compact selectable striped celled table tablet stackable datatable">
                        <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th></th>
                            <th>ឈ្មោះ</th>
                            <th>ចំនួនក្នុងស្តុក</th>
                            <th>តម្លៃលក់</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('css')
    <link rel="stylesheet" href="#">
@endpush
@push('js')
    <script src="{{asset('sigware/plugins/datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('sigware/js/customjs/custom-datatable.js')}}"></script>
@endpush
@section('js')
    <script>
        $(function () {
            let productPrice = $('#user_list').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: '{{route('report.check.stock.json')}}',
                    method: 'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'variation.product.image', name: 'variation.product.image',orderable:false,searchcable:false },
                    { data: 'variation.product.productName', name: 'variation.product.productName' },
                    { data: 'remain_qty', name: 'remain_qty' },
                    { data: 'sell_price', name: 'sell_price' }
                ],
            });
        })
    </script>
@stop
