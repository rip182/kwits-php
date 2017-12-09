@extends('layouts.app')
@section('styles')
  <style media="screen">
    #progressbar {
      /*margin: 20px;*/
      width: 200px;
      height: 200px;
      position: relative;
    }
  </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                  @if($summary['contributions'] >= $summary['total_owes'])
                    <a href="/friends/{{ $friend->id }}/activities">{{ "You owe " . $friend->name . " Php " . number_format(abs($summary['amount']), 2) }}</a>
                    @php $color = "#F44336"; @endphp
                    @if($summary['contributions'] > $summary['total_owes'])
                      <span style="float:right;">
                        <button type="button" data-toggle="modal" data-target="#settleModal" data-id="{{ $friend->id }}" data-name="{{ $friend->name }}" data-amount="{{ number_format(abs($summary['amount']), 2) }}" class="btn btn-primary btn-sm">Settle</button>
                      </span>
                    @endif
                  @else
                    @php $color = "#1cead6"; @endphp
                    <a href="/friends/{{ $friend->id }}/activities">{{ $friend->name . " owes you Php " . number_format($summary['amount'], 2) }}</a>
                  @endif
                  <hr>
                  <div class="row" style="margin-top: 75px;">
                      <div class="col-md-2 col-sm-2 col-sm-offset-4 col-xs-2 col-xs-offset-2 col-md-offset-4"><div id="progressbar" class="text-center"></div></div>
                  </div>
                  <div class="row" style="margin-top: 75px; margin-bottom: 75px;">
                      <div class="col-md-4 col-md-offset-4">
                        <p class="text-center">
                          @if($summary['contributions'] >= $summary['total_owes'])
                            <small class="text-muted"> YOU OWE </small>
                          @else
                            <small class="text-muted"> OWES YOU </small>
                          @endif
                        </p>
                        <h2 class="text-center">Php {{ number_format(abs($summary['amount']), 2) }}</h2>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <h5>
                          <strong>Php {{ number_format($summary['total_owes'], 2) }}</strong>
                          <small class="text-muted">LEECH</small>

                        </h5>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <h5 class="text-right">
                          <strong>Php {{ number_format($summary['contributions'], 2) }}</strong>
                          <small class="text-muted">SEED</small>
                        </h5>
                      </div>
                  </div>
                </div>
            </div>
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
  <script type="text/javascript" src="{{ asset('js/progressbar.js') }}"></script>
  <script>
  var bar = new ProgressBar.Circle(progressbar, {
    color: '#aaa',
    // This has to be the same size as the maximum width to
    // prevent clipping
    strokeWidth: 4,
    trailWidth: 1,
    easing: 'easeInOut',
    duration: 1400,
    text: {
      autoStyleContainer: false
    },
    from: { color: '#aaa', width: 1 },
    to: { color: '{{ $color }}', width: 4 },
    // Set default step function for all animate calls
    step: function(state, circle) {
      circle.path.setAttribute('stroke', state.color);
      circle.path.setAttribute('stroke-width', state.width);

      var value = Math.round(circle.value() * 100);
      if (value === 0) {
        circle.setText('');
      } else {
        circle.setText(value + ' %');
      }

    }
  });
  bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
  bar.text.style.fontSize = '3.7rem';

  bar.animate({{ $summary['percentage'] / 100 }});  // Number from 0.0 to 1.0
  </script>
@endsection
