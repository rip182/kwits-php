<expense inline-template :attributes="{{ $activity }}">
  <div class="expense">
    <h5 style="float:left;">Seeded</h5>
    <div class="dropdown" style="float:right;">
      <i id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
      <ul class="dropdown-menu" aria-labelledby="dLabel">
          <li>
            <a data-toggle="modal" data-target="#deleteExpenseModal{{ $activity->subject->id }}" data-expense-name="{{ $activity->subject->name }}" data-expense-id="{{ $activity->subject->id }}" href="#">Delete</a>
          </li>
      </ul>
    </div>
    <div style="clear:both;"></div>
    <h5>
      <small class="text-muted">You seeded for <strong>{{ $activity->subject->name }}</strong> expenses</small>
      <a href="/expenses/{{ $activity->subject->id }}"><small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small></a>
      <span style="float:right;">Php {{ number_format($activity->subject->amount, 2) }}</span>
    </h5>
    @include("profiles.modals.delete_expense")
  </div>
</expense>
