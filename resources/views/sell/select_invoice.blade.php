@foreach($stock_details as $value)
<tr id="{{$value->id}}" class="item-list">
    <td class="p-1">{{$value->id}}</td>
    <td class="p-1">
        <div class="ui input fluid m-0">
            <input required value="{{$value->variation->product->productName}}" readonly name="invoice[{{$value->id}}][name]" class="rounded-0" type="text">
        </div>
    </td>
    <td class="p-1">
        <div class="ui input fluid m-0">
            <input required value="{{$value->remain_qty}}" readonly id="qty-in-stock" class="rounded-0" type="number">
        </div>
    </td>
    <td class="p-1">
        <div class="ui input fluid m-0">
            <input required value="1" min="1" max="{{$value->remain_qty}}" id="qty" name="invoice[{{$value->id}}][qty]" class="rounded-0" type="number" step="any">
        </div>
    </td>
    <td class="p-1">
        <div class="ui input fluid m-0">
            <input required value="{{$value->sell_price}}" id="sell" name="invoice[{{$value->id}}][sell]" class="rounded-0" type="number" step="any">
        </div>
    </td>
    <td class="p-1">
        <div class="ui input fluid m-0">
            <input required value="{{$value->sell_price}}" id="amount" name="invoice[{{$value->id}}][amount]" readonly class="rounded-0" type="number"
                   step="any" placeholder="តម្លៃរុប">
        </div>
    </td>
    <td></td>
</tr>
@endforeach
