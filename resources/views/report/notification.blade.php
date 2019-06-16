<div class="header">
    ទំនិញមិនទាន់មាន ឬអស់ពីស្តុក
</div>
@foreach($notification_html as $item)
    <div class="item">
        <img class="ui avatar image" src="{{asset($item->product->image)}}" alt="label-image" />
        {{$item->product->productName}}
    </div>
    @endforeach
<div class="ui divider"></div>
<a class="item" href="{{route('report.check.stock.index')}}">បង្ហាញទាំអស់</a>
