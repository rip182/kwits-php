<h5 style="float:left;">Lent</h5>
<div class="dropdown" style="float:right;">
  <i type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
      <li>
        <a data-toggle="modal" data-target="#deleteLendModal" data-lending-id="{{ $activity->subject->id }}" href="#">Delete</a>
      </li>
  </ul>
</div>
<div style="clear:both;"></div>
<h5>
  <small class="text-muted">You lent money to <strong>{{ $activity->subject->recipient->name }}</strong></small>
  <span style="float:right;">Php {{ number_format($activity->subject->amount, 2) }}</span>
  <small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small>
</h5>
