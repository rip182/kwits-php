@extends('layouts.app')

@section('styles')

@endsection

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h5>
              <strong>{{ $expense->name }}</strong>
              <span style="float:right;"><strong>Php {{ number_format($expense->amount, 2) }}<strong></span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h5>
              <a href="/friends/{{ $expense->payment->user_id }}">{{ $expense->payment->user->name }}</a> <small class="text-muted">seeded</small>
              <span style="float:right;">Php {{ number_format($expense->amount, 2) }}</span>
            </h5>
          </div>
        </div>
      </div>
    </div>

    @foreach($expense->leechers as $leech)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h5>
              <small class="text-muted">{{ $leech->user->name }} leeched </small>
              <span style="float:right;">Php {{ number_format($leech->amount, 2) }}</span>
            </h5>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')

@endsection
