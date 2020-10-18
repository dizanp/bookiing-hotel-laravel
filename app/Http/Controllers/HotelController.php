<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $session_user = Session::get('username');
        $user = User::where('username', $session_user)->first();
        $hotel = Hotel::all();
        return view('admin/hotels.index', compact('user','hotel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $session_user = Session::get('username');
        $user = User::where('username', $session_user)->first();
        return view('admin/hotels.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'nama_hotel' => 'required|min:3',
            'deskripsi'  => 'required|min:5|max:255',
            'foto'       => 'mimes:jpeg,jpg,png|max:3000',
            'kamar'      => 'required',
            'lokasi'     => 'required|min:5|max:50',
            'harga'      => 'required|min:6',
        ]);

        //validasi slug
        $slug = str_slug($request->nama_hotel, '-');
        //cek slug ngga kembar
        if(Hotel::where('slug', $slug)->first() != null)
          $slug = $slug . '-' . time();

        $fileName = time() . '.png';
        $request->file('foto')->storeAs('public/images', $fileName);

        $lowongan = Hotel::create([
            'nama_hotel'        => $request->nama_hotel,
            'slug'              => $slug,
            'deskripsi'         => $request->deskripsi,
            'foto'              => $fileName,
            'kamar'             => $request->kamar,
            'lokasi'            => $request->lokasi,
            'harga'             => $request->harga
          ]);
  
           return redirect('/admin/hotels')->with('msg', 'Data Hotel berhasil di submit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $session_user = Session::get('username');
        $user = User::where('username', $session_user)->first();
        $hotel = Hotel::findOrFail($id);
        return view('/admin/hotels.edit', compact('user','hotel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'nama_hotel' => 'required|min:3',
            'deskripsi'  => 'required|min:5|max:255',
            'foto'       => 'mimes:jpeg,jpg,png|max:3000',
            'kamar'      => 'required',
            'lokasi'     => 'required|min:5|max:50',
            'harga'      => 'required|min:6',
        ]);
        $slug = str_slug($request->nama_hotel, '-');
        
        //cek slug ngga kembar
        if(Hotel::where('slug', $slug)->first() != null)
          $slug = $slug . '-' . time();

        $hotels = Hotel::find($id);
        if($request->foto == null)
        {
            $fileName = $hotels->foto;
        }
        else{
            $filename = $hotels->foto;
            $del = Storage::delete('public/images/'.$filename);
            $fileName = time() . '.png';
            $request->file('foto')->storeAs('public/images', $fileName);
        }

        $files = $fileName;

        $hotel = Hotel::findOrFail($id);
        $hotel->Update([
            'nama_hotel'        => $request->nama_hotel,
            'slug'              => $slug,
            'deskripsi'         => $request->deskripsi,
            'foto'              => $files,
            'kamar'             => $request->kamar,
            'lokasi'            => $request->lokasi,
            'harga'             => $request->harga
        ]);
  
           return redirect('/admin/hotels')->with('msg', 'Data Hotel berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $hotel = Hotel::findOrFail($id);
        $filename = $hotel->foto;
        $del = Storage::delete('public/images/'.$filename);
        $hotel->delete();
        return redirect('/admin/hotels')->with('msg', 'Data Hotel berhasil di hapus');
    }
}
