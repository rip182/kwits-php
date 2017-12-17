@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">My Profile</div>
          </div>
      </div>
  </div>
  @foreach($activities_sorted as $activity)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if($activity->payable)
                  <div class="panel-body">
                    @if($activity->payable_type == "App\User")
                      <h5>
                        <small class="text-muted">You paid <strong> {{ $activity->payable->name }} </strong></small>
                        <a href="#"><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></a>
                        <span style="float:right; color:green;"><strong>+ Php {{ number_format($activity->amount, 2) }} </strong></span>

                      </h5>
                    @endif

                    @if($activity->payable_type == "App\Expense")
                      <h5 style="float:left;">{{ $activity->payable->name }} expense</h5>
                      <div class="dropdown" style="float:right;">
                        <i id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon-ellipsis-horizontal"></i>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>
                              <a data-toggle="modal" data-target="#deleteExpenseModal" data-expense-name="{{ $activity->payable->name }}" data-expense-id="{{ $activity->payable->id }}" href="#">Delete</a>
                            </li>
                        </ul>
                      </div>
                      <div style="clear:both;"></div>
                      <h5>
                        <small class="text-muted">You seeded for <strong>{{ $activity->payable->name }}</strong> expenses</small>
                        <a href="/expenses/{{ $activity->payable->id }}"><small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small></a>
                        <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                      </h5>
                    @endif
                  </div>
                @endif

                @if($activity->expense)
                  <div class="panel-body">
                      <h5>
                        <small class="text-muted">You leeched
                          @php $names = []; @endphp
                          @foreach($activity->expense->leechers as $key => $leech)
                            @if($leech->user_id != auth()->id())
                              @php $names[] = "<a href='/friends/{$leech->user_id}'>{$leech->user->name}</a>"; @endphp
                            @endif
                          @endforeach
                          @if( ! empty($names))
                            with {!! join(', and ', array_filter(array_merge(array(join(', ', array_slice($names, 0, -1))), array_slice($names, -1)), 'strlen')); !!}
                          @endif
                          for <strong>{{ $activity->expense->name }}</strong> expenses paid by <a href="/friends/"{{$activity->expense->payment->user->id}}>{{ $activity->expense->payment->user->name }}</a></small>
                          <a href="/expenses/{{ $activity->expense->id }}"><small class="text-muted" style="margin-right: 5px;">{{ $activity->created_at->diffForHumans()  }}</small></a>
                        <span style="float:right; color: #bf5329;"><strong>- Php {{ number_format($activity->amount, 2) }}</strong></span>
                      </h5>
                  </div>
                @endif

                @if(class_basename($activity) == "Lending")
                  <div class="panel-body">
                    <h5>
                      <small class="text-muted">You lent money to <strong>{{ $activity->recipient->name }}</strong></small>
                      <span style="float:right;">Php {{ number_format($activity->amount, 2) }}</span>
                      <small class="text-muted">{{ $activity->created_at->diffForHumans()  }}</small>
                    </h5>
                  </div>
                @endif
            </div>
        </div>
    </div>
  @endforeach
  <div class="modal fade" id="deleteExpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="deleteExpenseForm">
          <div class="modal-body">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="hidden" name="expense_id" id="expense-id" value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('#deleteExpenseModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var expense_name = button.data('expense-name') // Extract info from data-* attributes
      var expense_id = button.data('expense-id');

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('You sure you want to delete ' + expense_name + ' expense?')
      modal.find('.modal-body input#expense-id').val(expense_id)
      modal.find('#deleteExpenseForm').attr('action', '/expenses/'+expense_id);
    })
  </script>
@endsection
