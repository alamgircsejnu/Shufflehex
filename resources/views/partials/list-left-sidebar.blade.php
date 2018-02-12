<div id="left-sidebar" class="col-md-2 plr-0">
    <div id="list-left-sidebar">
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-unstyled">
                    <li><a href="{{ url('/post/latest') }}">Latest Stories</a></li>
                    <li><a href="{{ url('/post/top') }}">Top Stories</a></li>
                    <li><a href="{{ url('/post/popular') }}">Popular Stories</a></li>
                    <li><a href="{{ url('/post/trending') }}">Trending Stories</a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar-panel-divider"></div>
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-unstyled">
                    <li><a href="{{ url('/post') }}">All</a></li>
                    <li><a href="{{ url('/post/web') }}">Web</a></li>
                    <li><a href="{{ url('/post/images') }}">Images</a></li>
                    <li><a href="{{ url('/post/videos') }}">Videos</a></li>
                    <li><a href="{{ url('/post/articles') }}">Articles</a></li>
                    <li><a href="{{ url('/post/lists') }}">Lists</a></li>
                    <li><a href="{{ url('/post/polls') }}">Polls</a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar-panel-divider"></div>
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-unstyled">
                    @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('pages/register') }}">Register</a></li>
                    
                    @else
                    <li><a href="user/profile.php">My Profile</a></li>
                    <li><a href="{{ url('/saved') }}">Saved Stories</a></li>
                    <li><a href="{{ url('/folders') }}">Folders</a></li>
                    <li><a href="{{ url('/post/create') }}">Add Story</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            @endif
                </ul>
            </div>
        </div>
    </div>
</div>