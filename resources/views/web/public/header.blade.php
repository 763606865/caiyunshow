<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
    <title>彩云网络</title>
    <link rel="stylesheet" type="text/css" href="Assets/css/reset.css"/>
    <script type="text/javascript" src="Assets/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="Assets/js/js_z.js"></script>
    <script type="text/javascript" src="Assets/js/banner.js"></script>
    <link rel="stylesheet" type="text/css" href="Assets/css/thems.css">
    <link rel="stylesheet" type="text/css" href="Assets/css/responsive.css">
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
