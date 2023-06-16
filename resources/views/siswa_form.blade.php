@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        {!! Form::model($model, [
                            'route' => 'siswa.store',
                            'method' => 'post',
                        ]) !!}
                        <div class="form-group">
                            <label for="nama">nama</label>
                            {!! Form::text('nama', null, ['class' => 'form-control', 'id' => 'nama']) !!}
                        </div>
                        <div class="form-group">
                            <label for="alamat">alamat</label>
                            {!! Form::text('alamat', null, ['class' => 'form-control', 'id' => 'alamat']) !!}
                        </div>
                        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
