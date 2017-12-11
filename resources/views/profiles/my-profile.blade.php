@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">My Profile</div>
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
                        <small class="text-muted">You paid <strong> {{ $activity->payable->name }} </strong></small>
                        <a href="#"><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></a>
                        <span style="float:right; color:green;"><strong>+ Php {{ number_format($activity->amount, 2) }} </strong></span>

                      </h5>
                    @endif

                    @if($activity->payable_type == "App\Expense")
                      <h5>
                        <small class="text-muted">You seeded for <strong>{{ $activity->payable->name }}</strong> expenses</small>
                        <a href="/expenses/{{ $activity->payable->id }}"><small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small></a>
                        <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                      </h5>
                    @endif
                  </div>
                @endif

                @if($activity->expense)
                  <div class="panel-body">
                      <h5>
                        <small class="text-muted">You leeched
                          @php $names = []; @endphp
                          @foreach($activity->expense->leechers as $key => $leech)
                            @if($leech->user_id != auth()->id())
                              @php $names[] = "<a href='/friends/{$leech->user_id}'>{$leech->user->name}</a>"; @endphp
                            @endif
                          @endforeach
                          @if( ! empty($names))
                            with {!! join(', and ', array_filter(array_merge(array(join(', ', array_slice($names, 0, -1))), array_slice($names, -1)), 'strlen')); !!}
                          @endif
                          for <strong>{{ $activity->expense->name }}</strong> expenses paid by <a href="/friends/"{{$activity->expense->payment->user->id}}>{{ $activity->expense->payment->user->name }}</a></small>
                          <a href="/expenses/{{ $activity->expense->id }}"><small class="text-muted" style="margin-right: 5px;">{{ $activity->created_at->diffForHumans()  }}</small></a>
                        <span style="float:right; color: #bf5329;"><strong>- Php {{ number_format($activity->amount, 2) }}</strong></span>
                      </h5>
                  </div>
                @endif

                @if(class_basename($activity) == "Lending")
                  <div class="panel-body">
                    <h5>
                      <small class="text-muted">You lent money to <strong>{{ $activity->recipient->name }}</strong></small>
                      <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                      <small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small>
                    </h5>
                  </div>
                @endif
            </div>
        </div>
    </div>
  @endforeach
</div>
@endsection
