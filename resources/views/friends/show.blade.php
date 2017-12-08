@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

                  @if($summary['contributions'] >= $summary['total_owes'])
                    {{ "You owe " . $friend->name . " Php " . number_format(abs($summary['amount']), 2) }}
                    @if($summary['contributions'] > $summary['total_owes'])
                      <span style="float:right;">
                        <button type="button" class="btn btn-primary btn-sm">Settle</button>
                      </span>
                    @endif
                  @else
                    {{ $friend->name . " owes you Php " . number_format($summary['amount'], 2) }}
                  @endif
                  <hr>
                  Total owes: Php {{ number_format($summary['total_owes'], 2) }} <br>
                  Contributions: Php {{ number_format($summary['contributions'], 2) }} <br>
                  Percentage: {{ $summary['percentage'] }}% <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
