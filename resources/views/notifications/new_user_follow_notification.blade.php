<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{$notification->unread() ? '/notifications/'.$notification->id.'?redirect_url='.$notification->data['name'] : $notification->data['name']}}">
        {{ $notification->data['name'] }}
    </a> 关注了你。
</li> 