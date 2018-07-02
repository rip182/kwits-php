@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($feeds as $feed)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading"><a href="#">{{ $feed['paid_by']->name }}</a></div>

                  <div class="panel-body">
                      <small>Posted {{ $feed['expense']->created_at->diffForHumans() }}</small> <br>
                      {{ $feed['expense']->name }} for
                      <span style="color:green;">
                        <strong>Php {{ number_format(abs($feed['expense']->amount), 2)  }}</strong>
                      </span>
                      for {{ $feed['split_count'] }} persons.
                  </div>
              </div>
          </div>
      </div>
    @endforeach
</div>
@endsection
