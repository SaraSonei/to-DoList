@props(['name'])
@error($name)
<p style="color: red ; font-style: italic ; font-size: 11px">{{ $message }}</p>
@enderror
<p ></p>
