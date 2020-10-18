@extends('admin.index')
@section('content')
<div class="content">
            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Input</strong> <small> Data Hotels</small>
                            </div> 
                            <div class="card-body card-block">
                                @if(count($errors) >0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li> {{$error}} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="/admin/hotels" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class=" form-control-label">Nama Hotel</label>
                                        <input class="form-control" type="text" value="{{old('nama_hotel')}}"
                                            name="nama_hotel" placeholder="Masukan Nama Hotel">
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-control-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" 
                                            cols="30" rows="8" placeholder="Masukan Deskripsi">{{old('deskripsi')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-control-label">Foto</label><br>
                                        <input  type="file" name="foto">
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-control-label">Kamar</label>
                                        <input class="form-control" type="number" value="{{old('kamar')}}"
                                            name="kamar" placeholder="Masukan Jumlah kamar" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-control-label">Lokasi</label>
                                        <textarea name="lokasi" class="form-control" 
                                            cols="30" rows="5" placeholder="Masukan Lokasi">{{old('lokasi')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-control-label">Harga</label>
                                        <input class="form-control" type="number" value="{{old('harga')}}"
                                            name="harga" placeholder="Masukan Harga" min="0">
                                    </div><br>
                                    
                                    <input type="submit" name="submit" class="btn btn-success btn-lg" value="Save">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>

  </div>


</div><!-- .animated -->
</div><!-- .content -->
@endsection