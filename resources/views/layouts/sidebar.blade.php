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
                <li class="pc-item">
                    <a class="pc-link" href="{{ route('userIndex') }}">
                        Фойдаланучилар
                    </a>
                </li>
                <li class="pc-item">
                    <a class="pc-link" href="{{ route('aktivs.index') }}">
                        Активлар ҳақида маълумот
                    </a>
                </li>

                @if (auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Manager')
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.userAktivCounts') }}">
                            Фойдаланувчилар Активлари
                        </a>
                    </li>
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('aktivs.userTumanlarCounts') }}">
                            Туман Активлари
                        </a>
                    </li>
                @endif



                <li class="pc-item">
                    <a class="pc-link btn btn-primary text-light mt-3" target="_blank" href="https://t.me/az_etc">
                        Қоллаб қуватлаш
                    </a>
                </li>


                @if (auth()->user()->roles[0]->name == 'Super Admin')
                    <li class="pc-item">
                        <form action="{{ route('aktivs.export') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary my-3">Excel</button>
                        </form>
                    </li>


                    <li class="pc-item">
                        <form action="{{ route('userUpdateNames') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="excel_file" class="form-label">Upload Excel File</label>
                                <input type="file" name="excel_file" id="excel_file" class="form-control"
                                    accept=".xlsx,.xls" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update User Names</button>
                        </form>
                    </li>
                @endif

            </ul>




            {{-- <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                    <i class="ph-duotone ph-gauge"></i>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-gauge"></i>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        <span class="pc-badge">2</span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('analytics.index') }}">Analytics</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('analytics.statistic') }}">Statistics</a>
                        </li>
                    </ul>
                </li>

                <li class="pc-item pc-caption">
                    <label>Widget</label>
                    <i class="ph-duotone ph-chart-pie"></i>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-steps"></i>
                        </span>
                        <span class="pc-mtext">Жараён</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        <span class="pc-badge">5</span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('clientIndex') }}">
                                Субъект ҳақида маълумот
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('obyekt.index') }}">
                                Объект ҳақида маълумот
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('orders.index') }}">
                                Ариза
                            </a>
                        </li>
            <li class="pc-item">
                <a class="pc-link" href="{{ route('shartnoma.index') }}">
                    Шартнома расмийлаш-тириш учун
                </a>
            </li>
            <li class="pc-item">
                <a class="pc-link" href="{{ route('monitoring.index') }}">
                    Мониторинг
                </a>
            </li>

            <li class="pc-item">
                <a class="pc-link" href="{{ route('excel.excel_Index') }}">
                    Fakticheskiy Razdel
                </a>
            </li>

            </ul>
            </li>

            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-map-pin-line"></i>
                    </span>
                    <span class="pc-mtext">Манзиллар</span>
                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    <span class="pc-badge">3</span>
                </a>
                <ul class="pc-submenu">
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('regionIndex') }}">
                            Худуд
                        </a>
                    </li>
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('districtIndex') }}">
                            Район
                        </a>
                    </li>
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('streetIndex') }}">
                            Мфй
                        </a>
                    </li>
                    <li class="pc-item">
                        <a class="pc-link" href="{{ route('substreetIndex') }}">
                            Кўча
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-gauge"></i>
                    </span>
                    <span class="pc-mtext">Справочники</span>
                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    <span class="pc-badge">12</span>
                </a>

                <ul class="pc-submenu" style="display: block; box-sizing: border-box;">
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">Coeffifient<span class="pc-arrow"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg></span></a>
                        <ul class="pc-submenu"
                            style="display: block; box-sizing: border-box; transition-property: height, margin, padding; transition-duration: 200ms; height: 0px; overflow: hidden; padding-top: 0px; padding-bottom: 0px; margin-top: 0px; margin-bottom: 0px;">
                            <li class="pc-item"><a class="pc-link" href="{{ route('kjIndex') }}">Qurilish turi
                                    (Kt)</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('koIndex') }}">Obyekt turi
                                    (Ko)</a>
                            <li class="pc-item"><a class="pc-link" href="{{ route('ktIndex') }}">Obyekt
                                    joylashuvi (Kj)</a>
                            <li class="pc-item"><a class="pc-link" href="{{ route('kzIndex') }}">Hududiy zonalar
                                    (Kz)</a>
                        </ul>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('ruxsatnomaTuriIndex') }}">Ruxsatnoma
                            Turi</a></li>
                    <li class="pc-item"><a class="pc-link"
                            href="{{ route('ruxsatnomaBerilganIshTuriIndex') }}">Ruxsatnoma berilgan ish turi</a>
                    <li class="pc-item"><a class="pc-link" href="{{ route('ruxsatnomaKimTamonidanIndex') }}">Ruxsatnoma
                            kim tamonidan</a>
                    <li class="pc-item"><a class="pc-link" href="{{ route('subyektShakliIndex') }}">Subyekt
                            Shakli</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('xujjatTuriIndex') }}">Shaxsni tasdiqlovchi
                            xujjat turi</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('subyektShakliIndex') }}">Subyekt
                            Shakli</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('xujjatBerilganJoyiIndex') }}">Xujjatning
                            berilgan joyi</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('bankIndex') }}">Bank</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('backup.index') }}">Backup</a>
                    </li>

                    <li class="pc-item"><a class="pc-link" href="{{ route('orderAtkazIndex') }}">Order Atkaz</a>
                    </li>
                </ul>
            </li>

            <li class="pc-item pc-caption">
                <label>Application</label>
                <i class="ph-duotone ph-buildings"></i>
            </li>

            <li class="pc-item">
                <a href="{{ route('generate_doc') }}" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-file"></i>
                    </span>
                    <span class="pc-mtext">Generate Doc</span></a>
            </li>

            <li class="pc-item">
                <a href="{{ route('calendar.index') }}" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-calendar-blank"></i>
                    </span>
                    <span class="pc-mtext">Calendar</span></a>
            </li>
            </ul> --}}
        </div>
    </div>
</nav>
