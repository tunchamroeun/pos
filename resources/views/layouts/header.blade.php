<div class="navslide navwrap">
    <div class="ui menu icon borderless grid" data-color="inverted white">
        <a class="item labeled openbtn">
            <i class="ion-navicon-round big icon"></i>
        </a>
        <a class="item labeled expandit" onclick="toggleFullScreen(document.body)">
            <i class="ion-arrow-expand big icon"></i>
        </a>
        <div class="item ui colhidden">
            <div class="ui icon input">
                <input type="text" placeholder="Search...">
                <i class="search icon"></i>
            </div>
        </div>
        <div class="right menu colhidden">
            <div class="ui dropdown item labeled icon">
                <i class="bell icon"></i>
                <div class="ui red label small circular" id="notification-count">0</div>
                <div class="menu" id="stock-notification"></div>
            </div>
            <div class="ui dropdown item">
                @if(Auth::user()->profile==='មិនបានដាក់ជូន')
                    <img class="ui mini circular image" src="{{asset('sigware/img/avatar/people/enid.png')}}"
                         alt="label-image"/>
                @else
                    <img class="ui mini circular image" src="{{asset(Auth::user()->profile)}}" alt="label-image"/>
                @endif
                <div class="menu">
                    {{--<a class="item" href="mail.html">Inbox</a>
                    <a class="item" href="profile.html">Profile</a>
                    <a class="item" href="settings.html">Settings</a>
                    <div class="ui divider"></div>
                    <a class="item">Need Help?</a>--}}
                    <a class="item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
