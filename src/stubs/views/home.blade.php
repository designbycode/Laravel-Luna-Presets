@extends('layouts.app')

@section('content')
<div class="wrapper">
    @if (session('status'))
        <div class="row">
            <div class="col">
                    <div class="notify notify--success" role="alert">
                        {{ session('status') }}
                    </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="md-col-12">
            <div class="panel panel--default">
                <div class="panel__header">{{ __('Dashboard') }}</div>
                <div class="panel__body">
                    <p>Learn more about <strong>Luna-sass</strong></p>
                    <a href="#" class="btn btn--primary">DOCUMENTATION</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
