@extends('layouts.app')

@section('main-content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-home"></i> Dashboard</h1>
                <p>Welcome to SIAL, the largest levis pants sales website in The World.</p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-cube"></i>
                    <div class="info">
                        <h4>Levi's</h4>
                        <p><b>{{ $Levis }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fa fa-list fa-3x"></i>
                    <div class="info">
                        <h4>Type</h4>
                        <p><b>{{ $Type }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-tags fa-3x"></i>
                    <div class="info">
                        <h4>Brand</h4>
                        <p><b>{{ $Brand }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-native')
    @extends('script')
@endsection