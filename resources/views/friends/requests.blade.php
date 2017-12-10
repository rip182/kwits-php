@extends('layouts.app')

@section('content')
<div class="container">
  @foreach($friend_requests as $request)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  <h5>
                    <small class="text-muted" style="margin-right: 5px;">{{ date("m/d/Y", strtotime($request->created_at))  }}</small>
                    {{ $request->sender->name }}
                    <form class="form-group" action="/friend-requests" method="post" style="float:right;">
                      {{ csrf_field() }}
                      <input type="hidden" name="sender_id" value="{{ $request->sender->id }}">
                      <button type="submit" class="btn btn-primary btn-sm" name="button">Accept</button>
                    </form>
                  </h5>
                </div>
            </div>
        </div>
    </div>
  @endforeach
</div>
@endsection
