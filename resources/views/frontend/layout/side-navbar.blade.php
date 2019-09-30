@php
  $link_nav = [
    'dashboard' => '#',
    'project' => '#',
    'marketing' => '#',
    'pemesanan' => '#',
    'laporan' => '#'
  ]
@endphp

@if( session()->has('isMarketing') )
  @php
    $link_nav = [
      'dashboard' => route('marketing_dashboard_page'),
      'project' => '#',
      'marketing' => '#',
      'pemesanan' => route('marketing_request_unit'),
      'laporan' => '#'
    ]
  @endphp
@else
  @php
    $link_nav = [
      'dashboard' => '#',
      'project' => route('developer_manage_project'),
      'marketing' => route('developer_manage_marketing'),
      'pemesanan' => '#',
      'laporan' => '#'
    ]
  @endphp
@endif

<div class="uk-card uk-card-body uk-height-viewport side-navbar">
  <div class="uk-margin">
    <div class="uk-text-center">
      <a href="{{ route('homepage') }}"><img class="uk-width-1-2" src="{{ asset('images/brand/logo_maps_secondary.png') }}" alt=""></a>
    </div>
  </div>
  <ul class="uk-nav-default side-nav" uk-nav>
    @if( session()->has('isMarketing') )
    <li>
      <a href="{{ route('marketing_dashboard_page') }}"><span class="uk-margin-small-right" uk-icon="icon: home; ratio: 1"></span> Dashboard</a>
    </li>
    <li class="uk-parent">
      <a href="#"><span class="uk-margin-small-right" uk-icon="icon: clock; ratio: 1"></span> Meeting <span class="uk-float-right" uk-icon="icon: chevron-down; ratio: 1"></span> </a>
      <ul class="uk-nav-sub side-nav-sub">
        <li><a href="{{ route('marketing_meeting_list') }}"><span class="uk-margin-small-right" uk-icon="icon: list; ratio: 1"></span> Jadwal Meeting</a></li>
        <li><a href="{{ route('marketing_create_schedule') }}"><span class="uk-margin-small-right" uk-icon="icon: plus; ratio: 1"></span> Buat Jadwal Meeting</a></li>
      </ul>
    </li>
    <li>
      <a @if( $hasRequest ) uk-tooltip="Anda memiliki pengajuan pemesanan" @endif href="{{ $link_nav['pemesanan'] }}"><span class="uk-margin-small-right" uk-icon="icon: cart; ratio: 1"></span> Pemesanan
        @if( $hasRequest )
          <span class="uk-float-right" uk-icon="icon: info; ratio: 1"></span>
        @endif
      </a>
    </li>
    <li>
      <a href="{{ route('auth_logout_mkt') }}"><span class="uk-margin-small-right" uk-icon="icon: sign-out; ratio: 1"></span> Keluar</a>
    </li>
    @else
    <li>
      <a href="{{ $link_nav['dashboard'] }}"><span class="uk-margin-small-right" uk-icon="icon: home; ratio: 1"></span> Dashboard</a>
    </li>
    <li class="uk-parent">
      <a href="#"><span class="uk-margin-small-right" uk-icon="icon: link; ratio: 1"></span> Proyek <span class="uk-float-right" uk-icon="icon: chevron-down; ratio: 1"></span> </a>
      <ul class="uk-nav-sub side-nav-sub">
        <li><a href="{{ route('developer_manage_project') }}"><span class="uk-margin-small-right" uk-icon="icon: list; ratio: 1"></span> Daftar Proyek</a></li>
        <li><a href="{{ route('developer_add_project_page') }}"><span class="uk-margin-small-right" uk-icon="icon: plus; ratio: 1"></span> Buat Proyek Baru</a></li>
      </ul>
    </li>
    <li>
      <a href="{{ $link_nav['pemesanan'] }}"><span class="uk-margin-small-right" uk-icon="icon: cart; ratio: 1"></span> Pemesanan</a>
    </li>
    <li>
      <a href="{{ $link_nav['marketing'] }}"><span class="uk-margin-small-right" uk-icon="icon: users; ratio: 1"></span> Marketing</a>
    </li>
    <li>
      <a href="#"><span class="uk-margin-small-right" uk-icon="icon: clock; ratio: 1"></span>Meeting</a>
    </li>
    <li class="uk-parent">
      <a href="#"><span class="uk-margin-small-right" uk-icon="icon: file-text; ratio: 1"></span> Laporan <span class="uk-float-right" uk-icon="icon: chevron-down; ratio: 1"></span></a>
      <ul class="uk-nav-sub side-nav-sub">
        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: list; ratio: 1"></span> Unit Terjual</a></li>
        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: list; ratio: 1"></span> Unit Dipesan</a></li>
        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: list; ratio: 1"></span> Hasil Meeting</a></li>
      </ul>
    </li>
    <li>
      <a href="{{ route('auth_logout_dev') }}"><span class="uk-margin-small-right" uk-icon="icon: sign-out; ratio: 1"></span> Keluar</a>
    </li>
    @endif
  </ul>
</div>
