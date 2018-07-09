
  <h5 class="page-header">{{ date("M d, Y", strtotime($date)) }}</h5>

@foreach($activity as $record)
  <div class="row" id="record{{$record->id}}">

          <div class="panel panel-default">
            <div class="panel-body" style="padding: 0px;">
              @if(view()->exists("profiles.activities.{$record->type}"))
                @include("profiles.activities.{$record->type}", ['activity' => $record])
              @endif
            </div>
          </div>

  </div>
@endforeach
