
<span class="label
    {{ $level == 'user' ? 'label-info' : '' }}
    {{ $level == 'vendor' ? 'label-primary' : '' }}
    {{ $level == 'company' ? 'label-success' : '' }}
">
    {{ __('admin.' . $level) }}
</span>


