@extends('admin.index')
@section('content')
<div class="content">
    <div class="animated fadeIn">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Data Table</strong>
                                </div>
                                <div class="card-body">
                                @if(session('msg'))
                                    <div class="alert alert-success">
                                        <p> {{session('msg')}} </p>
                                    </div>
                                @endif
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Nama Hotel</th>
                                                <th width="20%">Deskripsi</th>
                                                <th width="30%">Foto</th>
                                                <th width="10%">Kamar</th>
                                                <th width="20%">Lokasi</th>
                                                <th width="20%">Harga</th>
                                                <th width="20%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($hotel as $h)
                                            <tr>
                                                <td>{{$h->nama_hotel}}</td>
                                                <td>{{substr($h->deskripsi, 0 ,30)}}...</td>
                                                <td><img src="{{ asset('storage/images/' .$h->foto) }}"
                                                     width="200px" height="100px" alt="Hotels Image"></td>
                                                <td>{{$h->kamar}}</td>
                                                <td>{{$h->lokasi}}</td>
                                                <td>@php echo "Rp." . number_format($h['harga'], 2, ",", "."); @endphp</td>
                                                <td>
                                                    <form method="post" action="/admin/hotels/{{$h->id}}">
                                                        {{ csrf_field() }}
                                                        <a href="/admin/hotels/{{$h->id}}/edit" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-edit"></i>Edit</a>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <a href="/admin/hotels/create" class="btn btn-success">Tambah Data</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
    </div>
@endsection