@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  <span>
                    {{ ($total_owes >= 0) ? "You are owed: " : "You owe: " }}
                    <span style="color: {{ ($total_owes >= 0 ? "green;" : "#bf5329;") }}">
                      Php {{ number_format(abs($total_owes), 2)  }}
                    </span>
                  </span>
                </div>
            </div>
        </div>
    </div>

    @foreach($friends as $friend)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading"><a href="{{ $friend['path'] }}">{{ $friend['name'] }}</a></div>

                  <div class="panel-body">
                    @if($friend['owes'] >= 0)
                      Owes you
                      <span style="color:green;">
                        Php {{ number_format(abs($friend['owes']), 2)  }}
                      </span>
                    @else
                      You owe
                      <span style="color:#bf5329;">
                        Php {{ number_format(abs($friend['owes']), 2)  }}
                      </span>
                    @endif
                  </div>
              </div>
          </div>
      </div>
    @endforeach
</div>
@endsection
