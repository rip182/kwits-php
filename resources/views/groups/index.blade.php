@extends('layouts.app')

@section('content')
<div class="container">

    {{-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  <span>
                    {{ ($total_owes >= 0) ? "You are owed: " : "You owe: " }}
                    <span style="color: {{ ($total_owes >= 0 ? "green;" : "#bf5329;") }}">
                      <strong>Php {{ number_format(abs($total_owes), 2)  }}</strong>
                    </span>
                  </span>
                </div>
            </div>
        </div>
    </div> --}}

    @foreach($groups as $group)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading"><a href="/groups/{{ $group->id }}">{{ $group->name }}</a></div>

                  <div class="panel-body">
                    @if(1 >= 0)
                      <small>Published</small>
                      <span style="color:green;">
                        <strong><small> {{ $group->created_at->diffForHumans() }}</small></strong>
                      </span>
                    @else
                      {{-- You owe
                      <span style="color:#bf5329;">
                        <strong>Php {{ number_format(abs($friend['owes']), 2)  }}</strong>
                      </span>
                      <span style="float:right;">
                        <button type="button" data-toggle="modal" data-target="#settleModal" data-id="{{ $friend['id'] }}" data-name="{{ $friend['name'] }}" data-amount="{{ number_format(abs($friend['owes']), 2) }}" class="btn btn-primary btn-sm">Settle</button>
                      </span> --}}
                    @endif
                  </div>
              </div>
          </div>
      </div>
    @endforeach

    <div class="modal fade" id="settleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="/payments">
            <div class="modal-body">

                {{ csrf_field() }}
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Recipient:</label>
                  <input type="text" class="form-control" id="recipient-name">
                  <input type="hidden" name="user_id" id="user-id" value="">
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">Amount:</label>
                  <input type="number" class="form-control" id="owe-amount" name="amount" value="" step=".01">
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Pay</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $('#settleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('name') // Extract info from data-* attributes
    var user_id = button.data('id');
    var amount = button.data('amount').toString().split(",").join("")

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input#recipient-name').val(recipient)
    modal.find('.modal-body input#owe-amount').val(amount)
    modal.find('.modal-body input#user-id').val(user_id)
  })
</script>
@endsection
