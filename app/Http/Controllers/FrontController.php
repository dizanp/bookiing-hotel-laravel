<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTime;



class FrontController extends Controller
{
    //
    public function index()
    {
        $hotel = Hotel::orderBy('id','DESC')->limit(3)->get();
        return view('/index', compact('hotel'));
    }

    public function data()
    {
        $hotel = Hotel::paginate(5);
        return view('/data', compact('hotel'));
    }

    public function item($slug)
    {
        $total_harga = "";
        $hotel = Hotel::where('slug', $slug)->get();
        return view('/item', compact('hotel','total_harga'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('/register');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function order(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_checkin' => 'required',
            'tgl_checkout' => 'required',
            'kamar' => 'required',
            'tempat_tidur' => 'required',
            'harga_hotel' => 'required',
            'harga' => 'required'
        ]);
        $hotel = Hotel::find($id);
        if($request->tgl_checkin < date("Y-m-d")){
            return redirect('/item/'.$hotel->slug)->with('msg','Tanggal Check In tidak boleh lewat dari hari ini');
        }else if($request->tgl_checkout < $request->tgl_checkin){
            return redirect('/item/'.$hotel->slug)->with('msg','Tanggal Check Out tidak boleh lewat dari Tanggal Check In');
        }
        $hotel_id = $hotel->id;
        $session_user = Session::get('id');
        $data = new Order();
        $data->tgl_checkin = $request->tgl_checkin;
        $data->tgl_checkout = $request->tgl_checkout;
        $data->kamar = $request->kamar;
        $data->tempat_tidur = $request->tempat_tidur;
        $data->total_harga = $request->harga_hotel;
        $data->user_id = $session_user;
        $data->hotel_id = $hotel_id;

        $data->save();
        return redirect('/order')->with('msg','Kamu berhasil Memesan Kamar');
    }

    public function list_order()
    {
        $session_user = Session::get('id');
        $order = Order::where('user_id', $session_user)->orderBy('id', 'desc')->get();
        return view('order', compact('order'));
    }

    public function upload_bukti(Request $request, $id)
    {
        $this->validate($request, [
            'bukti_bayar'  => 'required|mimes:jpeg,jpg,png|max:3000',
        ]);

        $order = Order::find($id);
        $order_id = $order->id;

        $fileName = 'bukti'. time() . '.png';
        $request->file('bukti_bayar')->storeAs('public/images', $fileName);

        $update = DB::table('order')->where('id',$order_id)
            ->update([
                'bukti_bayar' => $fileName]);
        
        return redirect('/order')->with('msg', 'Upload bukti berhasil di submit');
    }

    public function checkout(Request $request, $id)
    {
        $order = Order::find($id);
        $hotel_id = $order->hotel_id;
        $kamar = $request->kamar;
        $kamar_hotel = Hotel::select(['kamar'])->where('id', $hotel_id)->first()->kamar;
        $total_kamar = intval($kamar) + intval($kamar_hotel);
        $update_kamar = DB::table('hotel')->where('id',$hotel_id)
                                ->update(['kamar' => $total_kamar]);
        $update_order = DB::table('order')->where('id',$id)
                                ->update([ 'status_checkout' => 'Sudah']);
        return redirect('/order')->with('msg','Anda berhasil Checkout');

    }

}
