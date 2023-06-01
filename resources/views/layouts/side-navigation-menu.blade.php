<div id="sidebar-wrapper" class="border-right">
    <ul class="sidebar-nav list-group">

        @include('layouts.logged-in-user-info-side')

        @yield('side-navigation-menu')

    </ul>
    <div class="footer footer-socials-block">



            <div class="social-media-button">
                <div class="icons">
                    <div class="icons-line">
                        <span>
                            <i class="fa fa-facebook-f" aria-hidden="true"></i>
                        </span>
                        <span>
                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                        </span>

                        <span>
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </span>
                        <span class="image-animate"><img src="{{asset('images/landmark_logo_icon.png')}}"></span>

                    </div>
                </div>
                <div class="pulsation"></div>
                <div class="pulsation"></div>
            </div>





        <!-- <a class="companyUrl" href="{!! $generalSettings->company_url !!}"><span>{{$generalSettings->company_url}}</span></a>
        <p class="footer-address">{!! nl2br($generalSettings->company_address) !!}</p>
        <p class="footer-company"><span>&copy;</span> {{$generalSettings->company_name}}</p> -->
        <!-- <ul class="footer-social">
            <li><a href="{{$socialNetworks['facebook']}}"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
            <li><a href="{{$socialNetworks['linkedin']}}"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="{{$socialNetworks['instagram']}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        </ul> -->
    </div>
</div>
