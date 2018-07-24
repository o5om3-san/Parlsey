@extends('layouts.app')

@section('content')

<link href="css/timeline.css" rel="stylesheet" type="text/css">

    <div class="row">
       <div class='col-sm-4'>
            <div class='shopWrapper new-create-card'>
                <div class='row'>
                    <div class='col-xs-3'>
                        <img class='shop-image' src="images/532.png"  alt="" width='80'>
                    </div>
                    <div class='col-xs-9'>
                        <div class='shopdetail'>
                            <h2>NEW</h2>
                        </div>
                    </div>
                </div>
            <div class='card_row'>                    
                <table>
                    <tr>
                        <td class='d_left'><i class="far fa-clock"></i></td>
                        <td class='d_right new-card'>　受付締め切り</td>
                    </tr>
                    <tr>
                        <td class='d_left'><i class="fas fa-coffee"></i></td>
                        <td class='d_right new-card'>　買いに行く店</td>
                    </tr>
                    <tr>
                        <td class='d_left'><i class="fas fa-shopping-cart"></i></td>
                        <td class='d_right new-card'>　受け付け個数</td>
                    </tr>
                    <tr>
                        <td class='d_left'><i class="fas fa-map-marker-alt"></i></td>
                        <td class='d_right new-card'>　手渡す場所</td>
                    </tr>                   
                </table>    
            </div>
            <div class="row card_button">
                {!! link_to_route('otsukais.create', 'つくる', null, ['class' => 'btn btn-default btn-xs']) !!}
            </div>
        </div>
    </div>     
   
    @foreach ($otsukais as $key => $otsukai)
        <?php $user = $otsukai->user; ?>
        <div class='col-sm-4'>
            <div class='shopWrapper'>
                <div class='row'>
                    <div class='col-xs-3'>
                        <img class='shop-image' src="images/532.png"  alt="" width='80'>
                    </div>
                    <div class='col-xs-9'>
                        <div class='shopdetail'>
                           <h2>{{ $otsukai->user->name }}</h2>
                        </div>
                    </div>
                </div>                 
                <div class='card_row order_card'>                    
                    <table>
                        <tr>
                            <td class='d_left'><i class="far fa-clock"></i></td>
                            <td class='d_right'>　<span class="memo-deadline"><?php echo date ("H:i", strtotime($otsukai->deadline)); ?></span> まで</td>
                        </tr>
                        <tr>
                            <td class='d_left'><i class="fas fa-coffee"></i></td>
                            <td class='d_right'>　{{ $otsukai->shop->name }}</td>
                        </tr>
                        <tr>
                            <td class='d_left'><i class="fas fa-shopping-cart"></i></td>
                            <td class='d_right'>
                                <span class="nokori">　
                                    @if($otsukai->capacity-$amounts[$key]==0)
                                        受付終了
                                    @else
                                        残り{{$otsukai->capacity-$amounts[$key]}}個
                                    @endif
                                </span>
                            </td>
                        </tr>
                         <tr>
                            <td class='d_left'><i class="fas fa-map-marker-alt"></i></td>
                            <td class='d_right'>　キャビネット {{ $otsukai->deliverPlace }}</td>
                        </tr>                   
                    </table>    
                </div>     
                <div class="row card_buttons">
                    @if (Auth::user()->id != $otsukai->user_id)
                        {!! link_to_route('otsukais.show', '詳細', ['id' => $otsukai->id], ['class' => 'btn btn-default btn-xs tl_buttons']) !!}
                        @if ($otsukai->capacity-$amounts[$key] > 0)
                            {!! link_to_route('requests.create', 'おつかいを頼む', ['id' => $otsukai->id], ['class' => 'btn btn-default btn-xs tl_buttons']) !!}
                        @else
                            <a><div class='btn btn-danger'>　　受付終了　　</div></a>
                        @endif
                    @endif
                </div>
                @if (Auth::user()->id == $otsukai->user_id)
                    <div class="card_button">
                        {!! link_to_route('otsukais.show', '詳細', ['id' => $otsukai->id], ['class' => 'btn btn-default btn-xs tl_buttons']) !!}
                    </div>
                @endif
            </div>
        </div>
    @endforeach

<p class='clearfixed'><center>{!! $otsukais->render() !!}</center></p>

@endsection