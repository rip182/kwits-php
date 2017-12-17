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
  @forelse($activities as $date => $activity)
    <div class="col-md-8 col-md-offset-2">
      <h3 class="page-header">{{ $date }}</h3>
    </div>
    @foreach($activity as $record)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                <div class="panel-body">
                  @include("profiles.activities.{$record->type}", ['activity' => $record])
                </div>
              </div>
          </div>
      </div>
    @endforeach
  @empty
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                      <p>No activity yet.</p>
                </div>
            </div>
        </div>
    </div>
  @endforelse
  {{-- Include below modals in partials above --}}
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
  <div class="modal fade" id="deleteLendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="deleteLendForm">
          <div class="modal-body">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="hidden" name="lending_id" id="lending-id" value="">
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
  <div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="deletePaymentForm">
          <div class="modal-body">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="hidden" name="payment_id" id="payment-id" value="">
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
      modal.find('.modal-title').text('Are you sure you want to delete ' + expense_name + ' expense?')
      modal.find('.modal-body input#expense-id').val(expense_id)
      modal.find('#deleteExpenseForm').attr('action', '/expenses/'+expense_id);
    })

    $('#deleteLendModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var lending_id = button.data('lending-id');

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('Are you sure?')
      modal.find('.modal-body input#lending-id').val(lending_id)
      modal.find('#deleteLendForm').attr('action', '/lendings/'+lending_id);
    })

    $('#deletePaymentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var payment_id = button.data('payment-id');

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('Are you sure?')
      modal.find('.modal-body input#payment-id').val(payment_id)
      modal.find('#deletePaymentForm').attr('action', '/payments/'+payment_id);
    })
  </script>
@endsection
