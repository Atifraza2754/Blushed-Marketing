<style>
    .active {
        color: blue !important;
    }
</style>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{ URL::to('/admin/settings/profile') }}" class="{{ $tab == 'profile' ? 'active' : '' }}">Profile</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="{{ URL::to('/admin/settings/password') }}" class="{{ $tab == 'password' ? 'active' : '' }}">Password</a>
</li>
{{-- <li class="breadcrumb-item active" aria-current="page">
    <a href="{{ URL::to('/admin/settings/site') }}" class="{{ $tab == 'site' ? 'active' : '' }}">Site Settings</a>
</li> --}}
