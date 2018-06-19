@extends('layouts.app')

@section('styles')
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form action="/groups" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <input name="name" type="text" class="form-control" placeholder="Group Name">
          </div>
          <div class="form-group">
            <select id="members" name="user_id[]" class="form-control selectpicker" data-actionsBox="true" data-live-search="true" multiple data-selected-text-format="count > 3">
              @foreach($friends as $friend)
                <option value="{{ $friend->id }}">{{ $friend->name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
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
