@props(['active'=>false])

{{--<a class="{{$active?'active':'text-gray-300 hover:bg-gray-700 hover:text-white'}}nav-item"--}}
{{--   aria-current="{{$attributes?'page':'false'}}" {{$attributes}}>--}}
{{--{{$slot}}--}}
{{--</a>--}}


<hr class="sidebar-divider">
<li class="{{$active?'active':''}} nav-item">
    <a class="nav-link" {{$attributes}}>
        {{$slot}}
    </a>
</li>
