@extends('layouts.app')

@section('content')

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    @for ($i = 1; $i < 6; $i++)
    <li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
    @endfor
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="http://localhost:8001/{{ $city }}/{{ $id }}/main.png" alt="">
    </div>
@for ($i = 1; $i < 6; $i++)
    <div class="item">
      <img src="http://localhost:8001/{{ $city }}/{{ $id }}/{{ $i }}.png" alt="">
    </div>
@endfor
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

@endsection