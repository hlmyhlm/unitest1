@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                            </tr>
                            @foreach ($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->alamat }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
