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

    {{-- @TODO - christian find a way to hide this form on initial load, and only display this via a modal when a button is clicked.  --}}
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            @include("groups.splits.options", ["members" => $members])
          </div>
        </div>
      </div>
    </div>

    @foreach($payments as $date => $payment)
      <div class="col-md-8 col-md-offset-2">
        <h3 class="page-header">{{ ($date == date("Y-m-d") ? "Today" : date("M d, Y", strtotime($date))) }}</h3>
      </div>
      @foreach($payment as $activity)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                    <div class="panel-body">
                        <h5>
                          <small class="text-muted">{{ ($activity->user_id == Auth::user()->id ? "You" : $activity->user->name) }} paid for <strong>{{ $activity->payable->name }}</strong> expenses</small>
                          <a href="/expenses/{{ $activity->payable->id }}"><small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small></a>
                          <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                        </h5>
                    </div>
              </div>
          </div>
      </div>
    @endforeach
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
