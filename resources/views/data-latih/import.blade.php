@extends('layouts.app')

@section('title', 'Import Data Latih')

@section('content')
    <form method="POST" action="{{ route('data-latih.import-post') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputFile">File Excel</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
