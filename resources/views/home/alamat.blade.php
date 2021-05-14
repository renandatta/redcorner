@extends('layouts.home')

@section('title')
    Alamat
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">
                        Alamat
                    </h3>
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-md-8">
                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        <div class="alert-body">{{ session('success') }}</div>
                                    </div>
                                @endif
                                <form action="{{ route('alamat.save') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control" required>{!! $alamat->alamat ?? '' !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="kodepos">Kodepos</label>
                                        <input name="kodepos" id="kodepos" class="form-control" value="{{ $alamat->kodepos ?? '' }}" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_penerima">Nama Penerima</label>
                                        <input name="nama_penerima" id="nama_penerima" class="form-control" value="{{ $alamat->nama_penerima ?? '' }}" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="notelp">No.Telp (Ada Whatsapp)</label>
                                        <input name="notelp" id="notelp" class="form-control" value="{{ $alamat->notelp ?? '' }}" required />
                                    </div>
                                    <button class="btn btn-danger" type="submit">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
