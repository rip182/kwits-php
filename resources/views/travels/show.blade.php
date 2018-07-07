@extends('layouts.app')

@section('styles')
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
  <style media="screen">
    .members {
      font-size: 24px !important;
      padding-top: 0 !important;
      border: none !important;
      border-bottom: 1px solid #000000 !important;
      height: 50px !important;
      border-radius: 0px !important;
      background-color: white;
    }
  </style>
@endsection

@section('content')
  <div class="col-md-9 col-md-pull-3">
    {{-- @include("travels.splits.options", ["members" => $members]) --}}

    <div class="projects">
      <div class="project" style="margin-left: 6px; width: 578px;">
        <div class="detail-content">
          <h2 class="title">
            {!! $travel->name !!}
          </h2>
          <div class="project-attributes">
            <table>
              <tbody>
                <tr>
                  <tr>
                    <td class="name">Year</td>
                    <td class="value">{{ date("m/Y", strtotime($travel->created_at)) }}</td>
                  </tr>
                  <tr>
                    <td class="name">Location</td>
                    <td class="value">Siargao, Philippines</td>
                  </tr>
                  <tr>
                    <td class="name">Travel Buddies</td>
                    <td class="value">
                      {{ rtrim($names, ', ') }}
                    </td>
                  </tr>
                  <tr>
                    <td class="name">Total Expenses</td>
                    <td class="value">P {{ number_format(abs($total_expenses), 2)  }}</td>
                  </tr>
                  <tr>
                    <td class="name">Share</td>
                    <td class="value">
                      <div class="socials">
                        <div class="kd-sharing-post-social">
                          <a href="#"><i class="fa fa-facebook"></i></a>
                          <a href="#"><i class="fa fa-twitter"></i></a>
                          <a href="#"><i class="fa fa-instagram"></i></a>
                          <a href="#"><i class="fa fa-google-plus"></i></a>
                          <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <div class="tiled-gallery">
        @foreach($payments as $date => $payment)
          @foreach($payment as $activity)
            <div class="project-item">
              <a href="single-project.html">
                <img src="{{ asset('images') }}/projects/{{ rand(1, 21)}}.jpg" alt="">
              </a>
              <h2 class="title">
                <a href="#">P {{ number_format($activity->amount, 2) }} - {{ $activity->payable->name }}</a>
              </h2>
            </div>
          @endforeach
        @endforeach
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  {{-- <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script> --}}
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".selectpicker").selectpicker({
        'actionsBox' : true
      });
      $(".selectpicker").selectpicker('selectAll');
    });
  </script>
@endsection
