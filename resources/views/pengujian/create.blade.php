@extends('layouts.app')

@section('title', 'Lakukan Pengujian')

@section('content')
    <form method="POST" action="{{ route('pengujian.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Pengujian</label>
            <input type="text" class="form-control" name="nama">
        </div>
        <div class="form-group">
            <label>Model</label>
            <select class="form-control" name="pelatihan_id">
                @foreach ($pelatihan as $item)
                    <option value="{{ $item->id }}">{{ $item->file_model }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>File Data Uji <span class="text-danger">*.csv</span></label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            <i class="fas fa-save"></i>
            Submit
        </button>
    </form>
@endsection
