@extends('layouts.app')

    @section('styles')

    @endsection

    @section('content')
    <div class="container-fluid landingpage-content">
        <div class="title">
            <p class="h4 text-left">In sollicitudin sollicitudin felis, sit amet lacinia sapien</p>
        </div>
        <div class="row center-landing-image">
            <img id="landing-image" src="{{ asset('images/landingpage2.png') }}" alt="">
        </div>
    </div>
    @endsection

    @section('signup/login')
    <div class="row form-alignment" >

        <form action="#" class="fh5co-form animate-box form-border" data-animate-effect="fadeInRight" >
            <h2>Kwits</h2>
               <h4 class="text-center">
                   To Share with your friends Sign Up With
               </h4>

            <button type="button" class="btn btn-fb"><i class="fa fa-facebook pr-1"> <span>Facebook</span> </i> </button>
            <button type="button" class="btn btn-tw"><i class="fa fa-twitter pr-1"> <span>Twitter</span></i></button>
            <button type="button" class="btn btn-ins"><i class="fa fa-instagram pr-1"> <span>Instagram</span> </i> </button>

            <div class='hr'>
                <span class='hr-title'>Or</span>
            </div>

            <div class="form-group"></div>
            {{--<div class="form-group">--}}
                {{--<div class="alert alert-success" role="alert">Your info has been saved.</div>--}}
            {{--</div>--}}
            <div class="form-group">
                <label for="name" class="sr-only">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="re-password" class="sr-only">Re-type Password</label>
                <input type="password" class="form-control" id="re-password" placeholder="Re-type Password" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="remember"><input type="checkbox" id="remember"> Remember Me</label>
            </div>
            <div class="form-group">
                <p>Already registered? <a href="index3.html">Sign In</a></p>
            </div>
            <div class="form-group">
                <button type="submit" value="Sign Up" class="btn btn-primary btn-block"> Sign up</button>
            </div>
        </form>

    </div>
    @endsection