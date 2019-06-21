@extends('layouts.dashboard')
@section('title')
    របាយការណ៍ - ថ្លៃឈ្នួល
@stop
@section('content')
    <div class="row">
        <div class="sixteen wide tablet sixteen wide computer column">
            <div class="ui segments stacked">
                <div class="ui segment">
                    <h5 class="ui header">ថ្លៃឈ្នួល</h5>
                </div>
                <div class="ui segment">
                    <div class="ui input">
                        <div id="reportrange"
                             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="icon calendar"></i>&nbsp;
                            <span></span> <i class="icon caret down"></i>
                        </div>
                    </div>
                </div>
                <div class="ui segment grid">
                    <div class="row">
                        <div class="eight wide tablet eight wide computer column">

                            <div class="ui segment left aligned">

                                <div class="ui  statistic">
                                    <div class="value counter">
                                        $<span id="income-note">0.00</span>
                                    </div>
                                    <div class="label">
                                        ថ្លៃឈ្លល
                                    </div>
                                    <i class="icon ion-cash teal statisticIcon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('sigware/css/daterangepicker.css')}}"/>
@endpush
@push('js')
    <script type="text/javascript" src="{{asset('sigware/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('sigware/js/daterangepicker.min.js')}}"></script>
@endpush
@section('js')
    <script>
        $(function () {
            //import
            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $.ajax({
                    method: 'post',
                    type: 'json',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'start': start.format('MMMM D, YYYY'),
                        'end': end.format('MMMM D, YYYY'),
                    },
                    url: '{{route('report.invoice.income.note.range')}}',
                    success: function (data) {
                        $('#income-note').text(parseFloat(data).toFixed(2));
                    }
                });

            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'ថ្ងៃនេះ': [moment(), moment()],
                    'ម្សិលមិញ': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'ប្រាំពីរថ្ងៃមុន': [moment().subtract(6, 'days'), moment()],
                    'សាមសិបថ្ងៃមុន': [moment().subtract(29, 'days'), moment()],
                    'ខែនេះ': [moment().startOf('month'), moment().endOf('month')],
                    'ខែមុន': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'ឆ្នាំនេះ': [moment().startOf('year'), moment().endOf('year')],
                    'ឆ្នាំមុន': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                }
            }, cb);
            cb(start, end);
        })
    </script>
@stop
