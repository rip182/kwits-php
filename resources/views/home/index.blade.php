@extends('layouts.app')

@section('content')
<div class="col-md-9 col-md-pull-3">
  <div class="projects">
    <?php $random = rand(1, ($feed->count() + 5)); ?>
    @foreach($feed as $key => $item)
      @if( $key == $random && $user->access_token == null)
        @include('home.ads')
      @else
        @include('home.feed')
      @endif
    @endforeach
    <!-- Pagination -->
		<div class="pagination-wrap">


		</div>
		<!-- End Pagination -->
  </div>
</div>
@endsection
