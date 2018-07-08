@extends('layouts.app')
@section('styles')
<style media="screen">
  .panel-default>.panel-heading {
    background-color: transparent !important;
  }
  .panel-default {
    border-color: transparent !important;
  }

  #comments {
    border-top: 0px !important;
  }

  .comment-settled:first-child {
    border-top: 1px solid #eeeeee;
    margin-top: 25px;
  }
</style>
@endsection
@section('content')
<div class="col-md-9 col-md-pull-3">
  <div class="projects">
    <div id="comments">
      @if($total_owes == 0)
        @include('dashboard.titles.settled')
      @elseif($total_owes > 0)
        @include('dashboard.titles.owed')
      @else
        @include('dashboard.titles.owe')
      @endif
      @if($crypto_account)
        @include('dashboard.coins.account')
      @endif
      <div class="comments-inner">
        <ul class="comment-list">
          @foreach($friends as $friend)
            @if($friend['owes'] != 0)
              @include('dashboard.buddies.notsettled')
            @endif
          @endforeach
        </ul>
        <ul class="comment-list">
          @foreach($friends as $friend)
            @if($friend['owes'] == 0)
              @include('dashboard.buddies.settled')
            @endif
          @endforeach
        </ul>
      </div>

    </div>
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
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
  $("#settleModal").on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('name') // Extract info from data-* attributes
    var user_id = button.data('id');
    var amount = button.data('amount').toString().split(",").join("")

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('You owe ' + recipient + " P" + amount);
    modal.find('.modal-body input#recipient-name').val(recipient)
    modal.find('.modal-body input#owe-amount').val(amount)
    modal.find('.modal-body input#user-id').val(user_id)
  })
});

</script>
@endsection
