
<h5 style="float:left;">Paid</h5>
<div class="dropdown" style="float:right;">
  <i type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
      <li>
        <a data-toggle="modal" data-target="#deletePaymentModal" data-payment-id="{{ $activity->subject->id }}" href="#">Delete</a>
      </li>
  </ul>
</div>
<div style="clear:both;"></div>
<h5>
  <small class="text-muted">You paid {{ ($activity->subject->payable_type == "App\User" ? "" : "for" )}} <strong> {{ $activity->subject->payable->name }} </strong></small>
  <a href="#"><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></a>
  <span style="float:right; color:green;"><strong>+ Php {{ number_format($activity->subject->amount, 2) }} </strong></span>
</h5>
