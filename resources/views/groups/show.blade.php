@extends('layouts.app')

@section('styles')
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  <h4 style="float:left;">
                    {!! $group->name !!}
                  </h4>
                  <span style="float:right;">
                    Total Expenses:
                    <span style="color:green;">
                      <strong>Php {{ number_format(abs($total_expenses), 2)  }}</strong>
                    </span>
                  </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <form action="/expenses" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="group_id" value="{!! $group->id !!}">
              <div class="form-group">
                <input name="amount" type="number" class="form-control" placeholder="0.00" autofocus>
              </div>
              <div class="form-group">
                <input name="name" type="text" class="form-control" placeholder="e.g. Dinner, Bus Fare, etc.">
              </div>
              <div class="form-group">
                <select id="members" name="user_id[]" class="form-control selectpicker" data-actionsBox="true" data-live-search="true" multiple data-selected-text-format="count > 3">
                  @foreach($members as $member)
                    <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @foreach($payments as $payment)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  {{-- @if($activity->payable) --}}
                    <div class="panel-body">
                      {{-- @if($activity->payable_type == "App\Expense") --}}
                        <h5>
                          <small class="text-muted">{{ ($payment->user_id == Auth::user()->id ? "You" : $payment->user->name) }} paid for <strong>{{ $payment->payable->name }}</strong> expenses</small>
                          <a href="/expenses/{{ $payment->payable->id }}"><small class="text-muted">{{ $payment->created_at->diffForHumans()  }}</small></a>
                          <span style="float:right;">Php {{ number_format($payment->amount, 2) }}</span>
                        </h5>
                      {{-- @endif --}}
                    </div>
                  {{-- @endif --}}

                  {{-- @if($activity->expense)
                    <div class="panel-body">
                        <h5>
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
                            <a href="/expenses/{{ $activity->expense->id }}"><small class="text-muted" style="margin-right: 5px;">{{ $activity->created_at->diffForHumans()  }}</small></a>
                          <span style="float:right; color: #bf5329;"><strong>- Php {{ number_format($activity->amount, 2) }}</strong></span>
                        </h5>
                    </div>
                  @endif --}}

                  {{-- @if(class_basename($activity) == "Lending")
                    @if($activity->recipient_id == auth()->id())
                      <div class="panel-body">
                        <h5>
                          <small class="text-muted"><strong>{{ $activity->user->name }}</strong> lent you money</small>
                          <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                          <small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small>
                        </h5>
                      </div>
                    @endif
                  @endif --}}
              </div>
          </div>
      </div>
    @endforeach
</div>
@endsection

@section('scripts')
  {{-- <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script> --}}
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".selectpicker").selectpicker({
        'actionsBox' : true
      });
      $(".selectpicker").selectpicker('selectAll');
    });
  </script>
@endsection
