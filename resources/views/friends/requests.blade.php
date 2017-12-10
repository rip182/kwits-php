@extends('layouts.app')

@section('content')
<div class="container">
  @foreach($friend_requests as $request)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  <h5>
                    {{ $request->sender->name }} sent you a friend request
                    <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
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
