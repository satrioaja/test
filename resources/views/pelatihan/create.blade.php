@extends('layouts.app')

@section('title', 'Buat Model')

@section('content')
    <form method="POST" action="{{ route('pelatihan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Model</label>
            <input type="text" class="form-control" name="nama">
        </div>
        <div class="form-group">
            <label>File Data Latih <span class="text-danger">*.csv</span></label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Neuron</label>
            <input type="text" class="form-control" name="neuron">
        </div>
        <div class="form-group">
            <label>Layer</label>
            <input type="text" class="form-control" name="layer">
        </div>
        <div class="form-group">
            <label>Learning Rate</label>
            <input type="text" class="form-control" name="learning_rate">
        </div>
        {{-- onclick disabled --}}
        <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            <i class="fas fa-save"></i>
            Submit
        </button>
    </form>
@endsection
