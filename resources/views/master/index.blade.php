@extends('layouts.master')

@section('title', __('common.master_title'))

@section('css')
    <style>
        .master-border {
            border-radius: .5rem;
            border: 1px solid #715f19;
            padding: 2rem 0;
        }

        .master-icon {
            /* //  background: #e5e1ce; */
            border-radius: .5rem;
            color: #0070A5;
            font-size: 28px;
            margin-left: 48px;
        }
        .col-half-offset {
            margin-left: 30px;
        }

        .master-div {
            padding: 20px;
            border-radius: 4px;
            height: 136px;
            box-shadow: 2px 4px #888888;
        }

        .master-heading {
            font-size: 18px;
            height: 45px;
            color: #000;
            text-align: center;
        }

    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-2 col-half-offset">
                <a href="{{ route('delivery_location.index') }}">
                <div class="master-div widget-bg-color-white margin-bottom-20 bordered">
                    <h4 class="master-heading">{{__('common.masters.label.delivery_location')}}</h4>
                    <div class="widget-thumb-wrap">
                        <span class="master-icon">
                            <i class="fa fa-map-marker-alt"></i>
                        </span>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-md-2 col-half-offset">
                <a href="{{ route('commodity.index') }}">
                <div class="master-div widget-bg-color-white margin-bottom-20 bordered">
                    <h4 class="master-heading">{{__('common.masters.label.commodity')}}</h4>
                    <div class="widget-thumb-wrap">
                        <span class="master-icon">
                            <i class="fa fa-balance-scale"></i>
                        </span>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-2 col-half-offset">
                <a href="{{ route('specification.index') }}">
                <div class="master-div widget-bg-color-white margin-bottom-20 bordered">
                    <h4 class="master-heading">{{__('common.masters.label.specification')}}</h4>
                    <div class="widget-thumb-wrap">
                        <span class="master-icon">
                            <i class="fa fa-info-circle"></i>
                        </span>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-2  col-half-offset">
                <a href="{{ route('variety.index') }}">
                <div class="master-div widget-bg-color-white margin-bottom-20 bordered">
                    <h4 class="master-heading">{{__('common.masters.label.variety')}}</h4>
                    <div class="widget-thumb-wrap">
                        <span class="master-icon">
                            <i class="fa fa-cubes"></i>
                        </span>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-2  col-half-offset">
                <a href="{{ route('country.index') }}">
                <div class="master-div widget-bg-color-white margin-bottom-20 bordered">
                    <h4 class="master-heading">{{__('common.masters.label.country')}}</h4>
                    <div class="widget-thumb-wrap">
                        <span class="master-icon">
                            <i class="fa fa-globe"></i>
                        </span>
                    </div>
                </div>
                </a>
            </div>




        </div>

    </div>
@endsection
