<div style="clear:both;"></div>
  <h5>
    <small class="text-muted">You leeched
      @php $names = []; @endphp
      @foreach($activity->subject->expense->leechers as $key => $leech)
        @if($leech->user_id != auth()->id())
          @php $names[] = "<a href='/friends/{$leech->user_id}'>{$leech->user->name}</a>"; @endphp
        @endif
      @endforeach
      @if( ! empty($names))
        with {!! join(', and ', array_filter(array_merge(array(join(', ', array_slice($names, 0, -1))), array_slice($names, -1)), 'strlen')); !!}
      @endif
      for <strong>{{ $activity->subject->expense->name }}</strong> expenses paid by <a href="/friends/"{{$activity->subject->expense->payment->user->id}}>{{ $activity->subject->expense->payment->user->name }}</a></small>
      <a href="/expenses/{{ $activity->subject->expense->id }}"><small class="text-muted" style="margin-right: 5px;">{{ $activity->created_at->diffForHumans()  }}</small></a>
    <span style="float:right; color: #bf5329;"><strong>- Php {{ number_format($activity->subject->amount, 2) }}</strong></span>
  </h5>
