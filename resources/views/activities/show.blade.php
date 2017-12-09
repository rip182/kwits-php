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
                      <h5>
                        <a href="#"><small class="text-muted" style="margin-right: 5px;">{{ date("m/d/Y", strtotime($activity->created_at))  }}</small></a>
                        <small class="text-muted">Paid You</small>
                        <span style="float:right; color:green;"><strong>+ Php {{ number_format($activity->amount, 2) }} </strong></span>
                      </h5>
                    @endif

                    @if($activity->payable_type == "App\Expense")
                      <h5>
                        <a href="/expenses/{{ $activity->payable->id }}"><small class="text-muted" style="margin-right: 5px;">{{ date("m/d/Y", strtotime($activity->created_at))  }}</small></a>
                        <small class="text-muted">Seeded for <strong>{{ $activity->payable->name }}</strong> expenses</small>
                        <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                      </h5>
                    @endif
                  </div>
                @endif

                @if($activity->expense)
                  <div class="panel-body">
                      <h5>
                        <a href="/expenses/{{ $activity->expense->id }}"><small class="text-muted" style="margin-right: 5px;">{{ date("m/d/Y", strtotime($activity->created_at))  }}</small></a>
                        <small class="text-muted">Leeched you
                          @php $names = []; @endphp
                          @foreach($activity->expense->leechers as $key => $leech)
                            @if($leech->user_id != $friend->id)
                              @php $names[] = "<a href='/friends/{$leech->user_id}'>{$leech->user->name}</a>"; @endphp
                            @endif
                          @endforeach
                          @if( ! empty($names))
                            with {!! join(', and ', array_filter(array_merge(array(join(', ', array_slice($names, 0, -1))), array_slice($names, -1)), 'strlen')); !!}
                          @endif
                          for <strong>{{ $activity->expense->name }}</strong> expenses</small>
                        <span style="float:right; color: #bf5329;"><strong>- Php {{ number_format($activity->amount, 2) }}</strong></span>
                      </h5>
                  </div>
                @endif
            </div>
        </div>
    </div>
  @endforeach
</div>
@endsection
