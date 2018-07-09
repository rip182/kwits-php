@extends('layouts.app')

@section('content')
  <div class="col-md-9 col-md-pull-3">
    <div class="projects">
      @foreach($travels as $travel)
        <article class="post">
          <div class="post-media">
            <a href="/travels/{{ $travel['id'] }}">
              <img src="{{ asset('images') }}/projects/{{ rand(1, 21)}}.jpg" alt="Post">
            </a>
          </div>
          <div class="post-content">
            <h2 class="title">
              <a href="/travels/{{ $travel['id'] }}">{{ $travel['name'] }}</a>
            </h2>

            <!-- Post Details -->
            <div class="post-details">
              <a href="#" class="post-date">{{ date("M d, Y", strtotime($travel['created_at'])) }}</a>
              <a href="#" class="post-views">P {{ number_format(abs($travel['total_expenses']), 2)  }}</a>
              <a href="#" class="post-comments">03 Comments</a>
            </div>
            <!-- End Post Details -->

            <!-- The Content -->
            <div class="the-excerpt">
              <p>Morbi leo enim, laoreet eget urna id, ullamcorper condimentum urna. Curabitur accumsan sem et nisi ultricies porttitor. Aliquam sed nunc elit. Nunc faucibus interdum mauris at mattis. Phasellus congue volutpat porttitor.
                Vivamus fringilla iaculis ex, et condimentum magna pharetra id. Aliquam erat volutpat. Nam odio velit, egestas vel leo tempus, luctus dapibus mauris.
              </p>
            </div>
            <!-- End The Content -->
          </div>
        </article>
      @endforeach
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
