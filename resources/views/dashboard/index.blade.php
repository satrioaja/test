@extends('layouts.app')

@section('title', 'Dashboard')

@section('box')
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $data_pelatihan }}</h3>

        <p>Pelatihan</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{ route('pelatihan.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $data_latih }}</h3>

        <p>Data Latih</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="{{ route('data-latih.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $data_pengujian }}</h3>

        <p>Pengujian</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="{{ route('pengujian.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $data_uji }}</h3>

        <p>Data Uji</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('data-uji.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
@endsection

@section('content')
<div class="row mb-2">
  <div class="col-sm-12">
      @if($pengujian)
      <h3 class="text-center">{{ $pengujian->nama }}</h3>
      <canvas id="myChart" style="width:100%"></canvas>
      @endif
  </div>
</div>
@endsection

@section('js')
<script>
let xValues = [];

for (let i = 1; i < {{ count($hasil_prediksi) }}; i++) {
  xValues.push(i);
}

let hasil_prediksi = @json($hasil_prediksi);
let data_uji = @json($target);

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      label: 'Hasil Prediksi',
      data: hasil_prediksi,
      borderColor: "red",
      fill: false
    },{
      label: 'Data Uji',
      data: data_uji,
      borderColor: "green",
      fill: false
    }]
  },
  options: {
    legend: {
        display: true,
    }
  }
});
</script>
@endsection