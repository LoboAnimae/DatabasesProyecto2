@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: rgb(0, 138, 230); color: white;">Dashboard</div>

                <div class="card-body" style="background: white">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged as {{$user->name}}, with {{$user->email}} as an email! <br>
                    <a href="http://projectobases.test/profile">Go to your Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
