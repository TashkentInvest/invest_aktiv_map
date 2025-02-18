<nav class="pc-sidebar">
    <div class="navbar-wrapper">

        <div class="m-header">
            <a href="#!" class="b-brand text-primary">
                <img src="{{ asset('assets/images/light_logo.png') }}"alt="" style="width:140px;" class="logo">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Меню</label>
                    <i class="ph-duotone ph-gauge"></i>
                </li>
                @if (auth()->user()->roles[0]->name == 'Super Admin')
                    {{-- <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.kadastr_index') }}">
                            Кадастр
                        </a>
                    </li> --}}

                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('userIndex') }}">
                            Фойдаланучилар
                        </a>
                    </li>

                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.userTumanlarCounts') }}">
                            Хатловда аниқланган активлар туманлар кесимида
                        </a>
                    </li>

                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.kadastrTumanlarCounts') }}">
                            Кадастр (Свотник)
                        </a>
                    </li>
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.kadastrBorlar') }}">
                            Муниципиал активлар туманлар кесимида (Перечень)
                        </a>
                    </li>
                @endif

                @if (auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager')
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.userAktivCounts') }}">
                            Фойдаланувчилар Активлари
                        </a>
                    </li>
                @endif


                @if (auth()->user()->roles->first()->name == 'Manager')
                    <li class="pc-item">

                        <a class="pc-link"
                            href="{{ route('aktivs.index', ['district_id' => auth()->user()->district_id]) }}">Активлар
                            ҳақида маълумот</a>
                    </li>
                @else
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.index') }}">
                            Активлар ҳақида маълумот
                        </a>
                    </li>
                @endif

                <li class="pc-item">
                    <a class="pc-link btn btn-primary text-light mt-3" target="_blank" href="https://t.me/az_etc">
                        Қоллаб қуватлаш
                    </a>
                </li>


                @if (auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager')
                    <li class="pc-item">
                        <form action="{{ route('aktivs.export') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary my-3">Excel</button>
                        </form>
                    </li>

                @endif
            </ul>
        </div>
    </div>
</nav>
