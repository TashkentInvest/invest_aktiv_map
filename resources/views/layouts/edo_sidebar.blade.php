<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            {{-- Tash<span>Invest</span> --}}
            <img style="width: 130px; padding:20px; margin: 20px 0 !important;" src="{{ asset('edo_template/assets/TIC_white.png') }}"
                alt="">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">

            <li class="nav-item nav-category">Dashboard</li>
            @if (auth()->user()->roles[0]->name == 'Super Admin')
                {{-- <li class="pc-item">
                <a class="nav-link" href="{{ route('aktivs.kadastr_index') }}">
                    Кадастр
                </a>
            </li> --}}

                <li class="nav-item">
                    <a href="{{ route('userIndex') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Фойдаланучилар</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('aktivs.kadastrTumanlarCounts') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Кадастр (Туман)</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('aktivs.userTumanlarCounts') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title" title="Хатловда аниқланган активлар туманлар кесимида">Туманлар
                            кесимида</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('aktivs.kadastrBorlar') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title" title="Муниципиал активлар туманлар кесимида (Перечень)">Туманлар
                            кесимида 2</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager')
                <li class="nav-item">
                    <a href="{{ route('aktivs.userAktivCounts') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Фойдаланувчи Активлари</span>
                    </a>
                </li>
            @endif


            @if (auth()->user()->roles->first()->name == 'Manager')
                <li class="nav-item">
                    <a href="{{ route('aktivs.index', ['district_id' => auth()->user()->district_id]) }}"
                        class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Активлар
                            ҳақида маълумот</span>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('aktivs.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Активлар ҳақида маълумот</span>
                    </a>
                </li>
            @endif




            @if (auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager')
                <li class="nav-item">
                    <form action="{{ route('aktivs.export') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary my-3">Excel</button>
                    </form>
                </li>
            @endif




            </li>
            <li class="nav-item nav-category">Support</li>
            <li class="nav-item">
                <a target="_blank" href="https://t.me/az_etc" target="_blank"
                    class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Қоллаб қуватлаш</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
