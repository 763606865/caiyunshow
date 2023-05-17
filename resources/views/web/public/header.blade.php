<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
    <title>彩云网络</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/reset.css') }}"/>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.8.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/js_z.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/banner.js') }}"></script>
    <link rel="stylesheet" crossorigin="anonymous" href="{{ asset('assets/css/bootstrap.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/thems.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <script language="javascript">
        $(function(){
            $('#owl-demo').owlCarousel({
                items: 1,
                navigation: true,
                navigationText: ["上一个","下一个"],
                autoPlay: true,
                stopOnHover: true
            }).hover(function(){
                $('.owl-buttons').show();
            }, function(){
                $('.owl-buttons').hide();
            });
        });
    </script>
</head>
<body>
<!--头部-->
<div class="header">
    <div class="head clearfix">
        <div class="logo"><a href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="彩云网络"/></a></div>
        <div class="nav_m">
            <ul class="nav clearfix">
                @foreach($menus as $first)
                    <li>
                        <a href="{{ $first['link'] }}">{{ $first['name'] ?? '' }}</a>
                        @if(!empty($first['children']))
                            <div class="er">
                                <div class="er_m">
                                    <i>&nbsp;</i>
                                    <ul>
                                        @foreach($first['children'] as $children)
                                        <li><a href="{{ $children['link'] ?? 'javescript:(0);' }}">{{ $children['name'] ?? '' }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="nav_phone">
            <div class="phone"><img src="{{ asset('assets/images/phone.png') }}" alt=""></div>
            <div class="phone_text">
                <div class="phone_text_tit">全国服务热线</div>
                <div class="phone_text_number">16601063460</div>
            </div>
        </div>
    </div>
</div>
<!--头部-->
@include('web/public/tab')
