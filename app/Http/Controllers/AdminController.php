<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('role', 'admin');
        $session_user = Session::get('username');
        $user = User::where('username', $session_user)->first();
        if($request->session()->has('login') && $user){
                return view('/admin/index');
        }
        else{
            return redirect('/');
        }
    }

    public function order()
    {
        $order = Order::all();
        return view('/admin/order', compact('order'));
    }

    public function detail($id)
    {
        $order = Order::find($id);
        return view('/admin/detail', compact('order'));
    }

    public function detail_change(Request $request, $id)
    {
        $this->validate($request, [
            'konfirmasi' => 'required'
        ]);
        
        $order = Order::find($id);
        if($request->konfirmasi == "Diterima")
        {    
            $hotel_id = $order->hotel_id;
            $kamar = $request->kamar;
            $kamar_hotel = Hotel::select(['kamar'])->where('id', $hotel_id)->first()->kamar;
            $total_kamar = $kamar_hotel - $kamar;
            $update_kamar = DB::table('hotel')->where('id',$hotel_id)
                                ->update(['kamar' => $total_kamar]);
            $update_order = DB::table('order')->where('id',$id)
                                ->update([ 'konfirmasi' => $request->konfirmasi,
                                           'status_checkout' => 'Belum']);
        }

        $update_order = DB::table('order')->where('id',$id)
            ->update([ 'konfirmasi' => $request->konfirmasi]);
        return redirect('/admin/order')->with('msg','Konfirmasi berhasil di update');
    }
}
