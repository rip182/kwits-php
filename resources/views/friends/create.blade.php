@extends('layouts.app')

@section('styles')

@endsection

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form action="/friends" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <input name="email" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Email Address">
          </div>
          <button type="submit" class="btn btn-primary">Send Friend Request</button>
        </form>
      </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
