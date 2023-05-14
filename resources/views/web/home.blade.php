@include('web/public/header')
<!--幻灯片-->
<div id="banner" class="banner">
    <div id="owl-demo" class="owl-carousel">
        @foreach($banners as $banner)
        <a class="item" target="_blank" href="{{ $banner['link'] ?? '' }}" style="background-color:{{ $banner['background_color'] }};">
            <img src="{{ asset($banner['image']) }}" alt="" style="width:100%;">
        </a>
        @endforeach
    </div>
</div>
<!--幻灯片-->
<div class="i_m">
    <div class="i_name">
        <h1>服务项目</h1>
        <p>APP定制开发，互联网从业者必备</p>
    </div>
    <ul class="i_ma clearfix">
        <li>
            <div class="title">
                <img src="Assets/images/icon1.jpg" alt=""/>
                <span>AI人工智能</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic1.jpg" alt=""/></a></div>
            <div class="des">通过AI人工智能技术为用户提供指纹识别，人脸识别，自动规划，智能搜索、自动程序设计，智能控制等方面的服务。</div>
            <a href="{{ url('/introduction/project',['type' => 'ai']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon2.jpg" alt=""/>
                <span>微信应用开发</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic2.jpg" alt=""/></a></div>
            <div class="des">覆盖各商业领域的微信小程序开发、 轻量化微信服务应用等服务，满足用户多样化需求。</div>
            <a href="{{ url('/introduction/project',['type' => 'wechat']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon3.jpg" alt=""/>
                <span>APP定制开发</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic3.jpg" alt=""/></a></div>
            <div class="des">提供基于IOS、Android和鸿蒙OS系统 的移动APP应用设计与开发。</div>
            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon4.jpg" alt=""/>
                <span>企业门户</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic4.jpg" alt=""/></a></div>
            <div class="des">企业门户解决方案。适合大型服务、实体经济、项目投标等企业。致力于帮助企业在互联网领域填砖加瓦，企业信息公开化，自媒体宣传推广，最终实现互联网转型。</div>
            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon5.jpg" alt=""/>
                <span>物联网</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic5.jpg" alt=""/></a></div>
            <div class="des">物联网应用解决方案提供硬件与软件互联解决方案，硬件通过WiFi、GPRS、4G、蓝牙等多种连接方式与APP、小程序、公众号等互联，实现移动终端无线控制硬件，极大提供用户体验，产品竞争力。</div>
            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon6.jpg" alt=""/>
                <span>电商零售</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic6.jpg" alt=""/></a></div>
            <div class="des">社交电商\零售解决方案致力于为自媒体、新零售企业提供社交电商解决方案，通过自建商城，以及分销系统、营销会员系统、社会团购、直播导购等帮助企业搭建新一代社交销售体系，快速实现去中心化流量聚合，客户粉丝沉淀。</div>
            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>
        </li>
    </ul>
</div>
<div class="i_m">
    <div class="i_name">
        <h1>产品类型</h1>
        <p>多行业多场景多类型产品开发，为企业提供适合的解决方案</p>
    </div>
    <ul class="i_ma clearfix">
        <li>
            <div class="title">
                <img src="Assets/images/icon3.jpg" alt=""/>
                <span>AI人工智能</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic1.jpg" alt=""/></a></div>
            <div class="des">通过AI人工智能技术为用户提供指纹识别，人脸识别，自动规划，智能搜索、自动程序设计，智能控制等方面的服务。</div>
            <a href="{{ url('/introduction/project',['type' => 'ai']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon4.jpg" alt=""/>
                <span>微信应用开发</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic2.jpg" alt=""/></a></div>
            <div class="des">覆盖各商业领域的微信小程序开发、 轻量化微信服务应用等服务，满足用户多样化需求。</div>
            <a href="{{ url('/introduction/project',['type' => 'wechat']) }}" class="more">+查看详情</a>
        </li>
        <li>
            <div class="title">
                <img src="Assets/images/icon5.jpg" alt=""/>
                <span>APP定制开发</span>
            </div>
            <div class="tu"><a href=""><img src="Assets/upload/pic3.jpg" alt=""/></a></div>
            <div class="des">提供基于IOS、Android和鸿蒙OS系统 的移动APP应用设计与开发。</div>
            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>
        </li>
    </ul>
</div>
@include('web/public/footer')
