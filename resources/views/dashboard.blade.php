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
</style>
@endsection
@section('content')
<div class="col-md-9 col-md-pull-3">
  <div class="projects">
    <div id="comments">
      <h2 class="title">
        {{ ($total_owes >= 0) ? "You are owed: " : "You owe: " }}
        <span style="color: {{ ($total_owes >= 0 ? "green;" : "#bf5329;") }}">
          <strong>P {{ number_format(abs($total_owes), 2)  }}</strong>
        </span>
      </h2>
      <div class="comments-inner">
        <ul class="comment-list">
          @foreach($friends as $friend)
            <li class="comment">
              <div class="comment-body">
                <div class="comment-avatar image" style="background-image: url(images/avatar-150px.jpg);">
                  <img alt="avatar" src="{{ asset('images') }}/{{ rand(1, 4)}}.jpg">
                </div>
                <div class="comment-context">
                  <div class="comment-head">
                    <h2 class="title"><a href="{{ $friend['path'] }}">{{ $friend['name'] }}</a></h2>
                    <span class="comment-date">Joined {{ $friend['joined'] }}</span>
                  </div>
                  <div class="comment-content">
                    @if($friend['owes'] >= 0)
                      <p>Owes you P {{ number_format(abs($friend['owes']), 2)  }}</p>
                    @else
                      <p>You owe P {{ number_format(abs($friend['owes']), 2)  }}</p>
                    @endif
                  </div>
                  <div class="reply">
                    @if($friend['owes'] >= 0)
                      <span class="comment-reply"><a class="comment-reply-link" href="#">Notify</a></span>
                    @else
                      <span class="comment-reply">
                        <a href="#" data-toggle="modal" data-target="#settleModal" data-id="{{ $friend['id'] }}" data-name="{{ $friend['name'] }}" data-amount="{{ number_format(abs($friend['owes']), 2) }}" class="comment-reply-link">Settle</a>
                      </span>
                    @endif
                  </div>
                </div>
              </div>
            </li>
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
