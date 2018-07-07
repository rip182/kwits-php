<li class="comment">
  <div class="comment-body">
    <div class="comment-avatar image" style="background-image: url({{ asset('images') }}/{{ rand(1, 4)}}.jpg);">
      <img alt="avatar" src="{{ asset('images') }}/{{ rand(1, 4)}}.jpg">
    </div>
    <div class="comment-context">
      <div class="comment-head">
        <h2 class="title"><a href="{{ $friend['path'] }}">{{ $friend['name'] }}</a></h2>
        <span class="comment-date">Joined {{ $friend['joined'] }}</span>
      </div>
      <div class="comment-content">
        @if($friend['owes'] > 0)
          <p>Owes you P {{ number_format(abs($friend['owes']), 2)  }}</p>
        @else
          <p>You owe P {{ number_format(abs($friend['owes']), 2)  }}</p>
        @endif
      </div>
      <div class="reply">
        @if($friend['owes'] > 0)
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
