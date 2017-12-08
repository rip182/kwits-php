@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($friends as $friend)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading"><a href="{{ $friend['path'] }}">{{ $friend['name'] }}</a></div>

                  <div class="panel-body">

                    @if($friend['owes'] >= 0)
                      {{ $friend['name'] . " owes you Php" . number_format($friend['owes'], 2) }}
                    @else
                      {{ "You owe " . $friend['name'] . " Php" . number_format(abs($friend['owes']), 2) }}
                    @endif
                  </div>
              </div>
          </div>
      </div>
    @endforeach
</div>
@endsection
