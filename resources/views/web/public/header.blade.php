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
<body>
<!--头部-->
<div class="header">
    <div class="t_bg">
        <div class="top">
            <div class="lang">
                <a href="" class="on">中 文</a>|
                <a href="">English</a>
            </div>
            <div class="search">
                <input name="" type="text" placeholder="请输入关键字">
                <input name="" type="submit" value="">
            </div>
        </div>
    </div>
    <div class="head clearfix">
        <div class="logo"><a href=""><img src="Assets/images/logo.png" alt="路必康"/></a></div>
        <div class="nav_m">
            <div class="n_icon">导航栏</div>
            <ul class="nav clearfix">
                <li><a href="index.html">首页</a></li>
                <li class="now">
                    <a href="about.html">关于我们</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">公司简介</a></li>
                                <li><a href="">组织架构</a></li>
                                <li><a href="">公司历程</a></li>
                                <li><a href="">公司理念</a></li>
                                <li><a href="">业界肯定</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="product.html">代理产品</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">推介产品</a></li>
                                <li><a href="">消费类电子</a></li>
                                <li><a href="">移动通讯电子</a></li>
                                <li><a href="">工业电子</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="friend.html">合作伙伴</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">供应商</a></li>
                                <li><a href="">主要客户</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="join.html">人力资源</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">人才招聘</a></li>
                                <li><a href="">员工福利</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="news.html">新闻活动</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">公司活动</a></li>
                                <li><a href="">行业新闻</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="contact.html">联系我们</a>
                    <div class="er">
                        <div class="er_m">
                            <i>&nbsp;</i>
                            <ul>
                                <li><a href="">联系我们</a></li>
                                <li><a href="">客户留言</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--头部-->
