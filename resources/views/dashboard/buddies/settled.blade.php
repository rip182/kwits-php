<li class="comment" style="border-top: 1px solid #eeeeee; margin-top: 25px;">
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
        <p style="color: #ababab;">Settled</p>
      </div>
    </div>
  </div>
</li>
