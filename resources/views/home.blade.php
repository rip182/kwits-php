@extends('layouts.app')

@section('content')
<div class="col-md-9 col-md-pull-3">
  <div class="projects">
    @foreach($feed as $item)
      <div class="project-item">
			     <div style="margin-bottom:5px;">
             <span style="margin-right: 3px;"><i class="fa fa-user"></i></span>
             <span><b>{{ $item['paid_by']->name }}</b> {{ $item['expense']->name }} for P{{ number_format(abs($item['expense']->amount), 2)  }} for {{ $item['split_count'] }} persons</span>
             <span style="float:right; color: #ababab; text-transform:uppercase;" ><small> {{ $item['expense']->created_at->diffForHumans() }} </small></span>
           </div>
           <a href="single-project.html">
					    <img src="{{ asset('images') }}/projects/{{ rand(1, 21)}}.jpg" alt="">
					 </a>
           <div class="socials" style="padding-top: 15px !important;">
							<a href=""><i class="fa fa-heart-o fa-lg"></i></a>
							<a href=""><i class="fa fa-comment-o fa-lg"></i></a>
					 </div>
           <div style="margin-top: 5px">{{ rand(2, 100)}} likes</div>
      </div>
    @endforeach
    <!-- Pagination -->
		<div class="pagination-wrap">


		</div>
		<!-- End Pagination -->
  </div>
</div>
@endsection
