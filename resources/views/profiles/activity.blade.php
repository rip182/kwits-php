<div class="col-md-8 col-md-offset-2">
  <h3 class="page-header">{{ $date }}</h3>
</div>
@foreach($activity as $record)
  <div class="row" id="record{{$record->id}}">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-body">
              @if(view()->exists("profiles.activities.{$record->type}"))
                @include("profiles.activities.{$record->type}", ['activity' => $record])
              @endif
            </div>
          </div>
      </div>
  </div>
@endforeach
