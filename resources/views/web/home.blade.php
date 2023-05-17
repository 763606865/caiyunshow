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
<div class="p-t-box">
    <div class="p-t-name">
        <h2>服务项目</h2>
        <p>APP定制开发，互联网从业者必备</p>
    </div>
    <div class="p-t-item">
        <ul>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/56444f072681ac0c1379a0017e74fa3f.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>AI人工智能</h5>
                    <p>通过AI人工智能技术为用户提供指纹识别，人脸识别，自动规划，智能搜索、自动程序设计，智能控制等方面的服务。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/a7cce4ff5823bce9825b933951a78bf0.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>云计算服务</h5>
                    <p>运用分布式计算、效用计算、负载均 衡、虚拟化等计算机技术为用户提供基础 设施即服务(IaaS)、平台即服务(PaaS) 和软件即服务(SaaS)。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/e94449cd812a194bec118a984000507a.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>大数据技术服务</h5>
                    <p>通过对大数据的采集、预处理、存储及 管理、分析及挖掘、展现和应用等技术 手段为企业业务分析和发展带来了新的 思维角度。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/bec7c06629d6f30952c3000034824552.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>物联网</h5>
                    <p>基于专用装置和技术开发，通过网络接入，实现物与物、物与人的泛在连接，实现用户对产品和过程的智能化感知、识别和管理。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/f45db5fde5efc8f273ebd5e05ebad694.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>集成系统</h5>
                    <p>为企业提供营销系统、管理系统服务系统等平台系统的开发搭建及网定制等系统配套服务。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/6cb0e135ce35c4de96877df63e4737bb.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>智能软硬件开发</h5>
                    <p>提供企业级智能软硬件开发解决方案， 通过软件开发实现硬件产品的网络化、 智能化。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/059eafd82e3a92ff49f4d47ce3f375ff.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>微信应用开发</h5>
                    <p>覆盖各商业领域的微信小程序开发、 轻量化微信服务应用等服务，满足用户多样化需求。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
            <li>
                <div class="p-t-img">
                    <img src="{{ asset('/assets/images/66111ba4f50ab232d67468db32e55812.png') }}" alt="">
                </div>
                <div class="p-t-content">
                    <h5>APP定制开发</h5>
                    <p>提供基于IOS、Android和鸿蒙OS系统 的移动APP应用设计与开发。</p>
                </div>
                <div class="p-t-btn"><a class="btn btn-outline-primary" href="">立即咨询</a></div>
            </li>
        </ul>
    </div>
</div>
{{--<div class="i_m">--}}
{{--    <div class="i_name">--}}
{{--        <h1>服务项目</h1>--}}
{{--        <p>APP定制开发，互联网从业者必备</p>--}}
{{--    </div>--}}
{{--    <ul class="i_ma clearfix">--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/wuguan.png') }}" alt=""/>--}}
{{--                <span>AI人工智能</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic1.jpg" alt=""/></a></div>--}}
{{--            <div class="des">通过AI人工智能技术为用户提供指纹识别，人脸识别，自动规划，智能搜索、自动程序设计，智能控制等方面的服务。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'ai']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/wechat.png') }}" alt=""/>--}}
{{--                <span>微信应用开发</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic2.jpg" alt=""/></a></div>--}}
{{--            <div class="des">覆盖各商业领域的微信小程序开发、 轻量化微信服务应用等服务，满足用户多样化需求。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'wechat']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/apple.png') }}" alt=""/>--}}
{{--                <span>APP定制开发</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic3.jpg" alt=""/></a></div>--}}
{{--            <div class="des">提供基于IOS、Android和鸿蒙OS系统 的移动APP应用设计与开发。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/qiye.png') }}" alt=""/>--}}
{{--                <span>企业门户</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic4.jpg" alt=""/></a></div>--}}
{{--            <div class="des">企业门户解决方案。适合大型服务、实体经济、项目投标等企业。致力于帮助企业在互联网领域填砖加瓦，企业信息公开化，自媒体宣传推广，最终实现互联网转型。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/wulianwang.png') }}" alt=""/>--}}
{{--                <span>物联网</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic5.jpg" alt=""/></a></div>--}}
{{--            <div class="des">物联网应用解决方案提供硬件与软件互联解决方案，硬件通过WiFi、GPRS、4G、蓝牙等多种连接方式与APP、小程序、公众号等互联，实现移动终端无线控制硬件，极大提供用户体验，产品竞争力。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="{{ asset('assets/icon/fangjiachaxun.png') }}" alt=""/>--}}
{{--                <span>电商零售</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic6.jpg" alt=""/></a></div>--}}
{{--            <div class="des">社交电商\零售解决方案致力于为自媒体、新零售企业提供社交电商解决方案，通过自建商城，以及分销系统、营销会员系统、社会团购、直播导购等帮助企业搭建新一代社交销售体系，快速实现去中心化流量聚合，客户粉丝沉淀。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}
{{--<div class="i_m">--}}
{{--    <div class="i_name">--}}
{{--        <h1>产品类型</h1>--}}
{{--        <p>多行业多场景多类型产品开发，为企业提供适合的解决方案</p>--}}
{{--    </div>--}}
{{--    <ul class="i_ma clearfix">--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="Assets/images/icon3.jpg" alt=""/>--}}
{{--                <span>AI人工智能</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic1.jpg" alt=""/></a></div>--}}
{{--            <div class="des">通过AI人工智能技术为用户提供指纹识别，人脸识别，自动规划，智能搜索、自动程序设计，智能控制等方面的服务。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'ai']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="Assets/images/icon4.jpg" alt=""/>--}}
{{--                <span>微信应用开发</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic2.jpg" alt=""/></a></div>--}}
{{--            <div class="des">覆盖各商业领域的微信小程序开发、 轻量化微信服务应用等服务，满足用户多样化需求。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'wechat']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <div class="title">--}}
{{--                <img src="Assets/images/icon5.jpg" alt=""/>--}}
{{--                <span>APP定制开发</span>--}}
{{--            </div>--}}
{{--            <div class="tu"><a href=""><img src="Assets/upload/pic3.jpg" alt=""/></a></div>--}}
{{--            <div class="des">提供基于IOS、Android和鸿蒙OS系统 的移动APP应用设计与开发。</div>--}}
{{--            <a href="{{ url('/introduction/project',['type' => 'app']) }}" class="more">+查看详情</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}
@include('web/public/footer')
