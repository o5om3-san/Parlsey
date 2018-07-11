<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Item;
use App\Otsukai;
use App\User;
use App\Shop;
use DateTime;

class OtsukaisController extends Controller
{
    public function index()
    { 
        
        if (\Auth::check()) {

            $otsukai = new Otsukai();
            $dt = new DateTime();
            $otsukais = $otsukai->orderBy('deadline', 'asc')->paginate(10);
           
            $data = [
                'otsukais' => $otsukais,
            ];
            return view('otsukais.index', $data);
        } else {
            return view('welcome');
        }
    }   
    
    public function create()
    {
        $otsukai = new Otsukai;
        $shops = Shop::all();
        $dt = new DateTime();
        
        return view('otsukais.create',[
                'otsukai' => $otsukai,
                'shops' => $shops,
                'dt' => $dt,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shop_id' => 'required|max:191',
            'capacity' => 'required|max:191',
            'deliverPlace' => 'required|max:191',
        ]);
        $dt = new DateTime();
        $time = $dt->format('Y-m-d').' '.$request->from_hour.':'.$request->from_minutes.':00';
       
        $request->user()->otsukai_nobita()->create([
            'deadline' => $time,
            'shop_id' => $request->shop_id,
            'capacity' => $request->capacity,
            'deliverPlace' => $request->deliverPlace,
        ]);

        return redirect('/');
    }
    
    public function store_request(Request $request)
    {
        $this->validate($request, [
            'item' => 'required|max:191',
            'amount' => 'required|max:191',
        ]);

        $request->user()->otsukai_giant()->request([
            'item' => $request->item,
            'amount' => $request->amount,
        ]);

        return redirect('/');
    }

    public function show($id)
    {
        $otsukai = Otsukai::find($id);
        $otsukai_giants = $otsukai->user_giant;
        // exit;
        
        if ($otsukai != null && \Auth::user()->id === $otsukai->user_id){
            return view('otsukais.show', [
                'otsukai' => $otsukai,
                'otsukai_giants' => $otsukai_giants,
            ]);
        }else{
            return redirect('/');
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $otsukai = \App\Otsukai::find($id);

        if (\Auth::user()->id === $otsukai->user_id) {
            $otsukai->delete();
        }
        return redirect('/');
    }
    
    public function request($id)
    {    
        $otsukai = Otsukai::find($id);
        $shop = $otsukai->shop;
        $items =$otsukai->shop->item;
        $user = $otsukai->user;
        
        return view('otsukais.request',[
                'items' => $items,
                'shop' => $shop,
                'otsukai' =>$otsukai,
                'user' =>$user,
        ]);
    }
    
    public function requesting_user($id)
    {
        $requesting_users = $otsukai->user->name;

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }
    
}
