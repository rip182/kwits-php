@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">{{ $friend->name }}'s Activities</div>
          </div>
      </div>
  </div>
  @foreach($activities_sorted as $activity)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if($activity->payable)
                  <div class="panel-body">
                    @if($activity->payable_type == "App\User")
                      <h5>{{ date("m/d/Y", strtotime($activity->created_at))  }} <span style="float:right; color:green;">+ Php {{ number_format($activity->amount, 2) }}</span></h5>
                    @endif

                    @if($activity->payable_type == "App\Expense")
                      <h5>{{ date("m/d/Y", strtotime($activity->created_at))  }} <span style="float:right;">+ Php {{ number_format($activity->amount, 2) }}</span></h5>
                    @endif
                  </div>
                @endif

                @if($activity->expense)
                  <div class="panel-body">
                      <h5>{{ date("m/d/Y", strtotime($activity->created_at))  }} <span style="float:right; color: #bf5329;">- Php {{ number_format($activity->amount, 2) }}</span></h5>
                  </div>
                @endif
            </div>
        </div>
    </div>
  @endforeach
</div>
@endsection
