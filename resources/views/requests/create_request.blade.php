@extends('layouts.app')

@section('content')


{!! Form::open( ['route' => ['requests.confirm_create_request', $otsukai->id]]) !!}

    <div class='col-sm-6'>    
        <div class='row shopWrapper'>
            <div class='row'>
                <div class='col-xs-3'>
                    <img class='shop-image' src="/images/532.png"  alt="" width='80'>
                </div>
                <div class='col-xs-9'>
                    <div class='shopdetail'>
                        <h2>注文画面</h2>
                    </div>
                </div>
            </div>
            <div class='card_row'>                    
                <table>
                    <tr>
                        <td class='d_left'>商品：</td>
                        <td class='d_right'>
                                <select name='item'>
                                        <option value=''>　　　　　　　　　　　　　</option>
                                    @foreach ($items as $item)
                                        <option value={{$item->id}}> {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class='d_left'>注文数：</td>
                        <td class='d_right'>
                                {!! Form::selectRange('amount', 1, $otsukai->capacity-$amount, null) !!}
                        </td>
                    </tr>
                     <tr>
                        <td class='d_left'>備考：</td>
                        <td class='d_right'>
                            {!! Form::textarea('comment', null, ['size' => '30x2', 'placeholder' => '例：砂糖、ミルクは不要']) !!}
                        </td>
                    </tr>                   
                </table>    
                </div>     
            <div class="row card_button">
                {!! Form::submit('注文確認', ['class' => 'btn btn-default btn_link request_button btn-lg']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class = 'menue col-sm-6 pull-right'>
        <h3>メニュー表</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
            </table>
    </div>
@endsection