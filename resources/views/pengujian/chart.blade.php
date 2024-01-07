@extends('layouts.app')

@section('title', 'Grafik Perbandingan')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <h3 class="text-center">{{ $pengujian->nama }}</h3>
            <canvas id="myChart" style="width:100%"></canvas>
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
let data_uji = @json($data_uji);

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