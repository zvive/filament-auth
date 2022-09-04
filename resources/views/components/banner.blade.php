@if (app('impersonate')->isImpersonating())
  <style>
    html,
    body>div>aside {
      margin-top: 40px;
    }

    body>div>aside @media print {
      html {
        margin-top: 0;
      }
    }
  </style>
  @php
    $impersonating = Filament\Facades\Filament::getUserName(auth()->user());
  @endphp
  <div id="impersonating-banner"
    class="print:hidden bg-primary-500 absolute h-10 top-0 w-full flex items-center content-center justify-center text-gray-800">
    <div>
      {{ __('filament-auth::filament-auth.text.impersonating') }}
      <strong>{{ $impersonating }}</strong>
      <a
        href="{{ route('filament-auth.stop.impersonation') }}"><strong>{{ __('filament-auth::filament-auth.text.impersonating.end') }}</strong></a>
    </div>

  </div>
@endIf
