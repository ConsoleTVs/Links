@extends(config('links.layout'))

@section('title', 'Link: ' . $link->slug . ' - Links - Automatic links statistics')

@section('bigTitle', 'Link Statistics')

@section('subtitle', $link->shortered())

@section('actions')
    <a class="btn btn-secondary" href="{{ route('links::links') }}">All Links</a>
@endsection

@section('content')

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ $link->totalViews() }}</span><br>
                                <span class="statistic-text">Views</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ $link->totalUniqueViews() }}</span><br>
                                <span class="statistic-text">Unique Views</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ $link->mostUsedBrowser() }}</span><br>
                                <span class="statistic-text">Most used browser</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ $link->mostUsedOS() }}</span><br>
                                <span class="statistic-text">Most used OS</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ $link->mostUsedLanguage(true) }}</span><br>
                                <span class="statistic-text">Most used language</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($link->views, 'donut', 'morris')
                                        ->setTitle($t = 'Used browsers')->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy('browser')->render();
                                !!}
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($link->views, 'donut', 'morris')
                                        ->setTitle($t = 'Used Operating Systems')->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy('os')->render();
                                !!}
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($link->views, 'donut', 'morris')
                                        ->setTitle($t = 'Used Languages')->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy('language')->render();
                                !!}
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive" style='margin-top: 15px;'>
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Browser</th>
                                            <th>Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($link->usedBrowsers() as $browser => $value)
                                        <tr>
                                            <td>{{ $browser }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive" style='margin-top: 15px;'>
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Operating System</th>
                                            <th>Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($link->usedOSs() as $os => $value)
                                        <tr>
                                            <td>{{ $os }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive" style='margin-top: 15px;'>
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($link->usedLanguages(true) as $lang => $value)
                                        <tr>
                                            <td>{{ $lang }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            {!!
                                ConsoleTVs\Charts\Charts::database($link->views, 'line', 'morris')
                                    ->setTitle($t = 'Views')->setDimensions(0, 300)->setResponsive(false)
                                    ->setElementLabel($t)->setColors(['#0275d8'])->lastByDay(7, true)->render();
                            !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            {!!
                                ConsoleTVs\Charts\Charts::database($link->uniqueViews(), 'line', 'morris')
                                    ->setTitle($t = 'Unique Views')->setDimensions(0, 300)->setResponsive(false)
                                    ->setElementLabel($t)->setColors(['#0275d8'])->lastByDay(7, true)->render();
                            !!}
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="column col-md-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Visit Date</th>
                                            <th>Browser</th>
                                            <th>Operating System</th>
                                            <th>Language</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($views = ConsoleTVs\Links\Models\View::where('link_id', $link->id)->orderBy('id', 'desc')->paginate(10) as $view)
                                        <tr>
                                            <td>{{ $view->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('links::specific', ['slug' => $link->slug, 'specific' => 'browser', 'specific_value' => $view->browser]) }}">
                                                    {{ $view->browser }} {{ $view->browser_version }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('links::specific', ['slug' => $link->slug, 'specific' => 'os', 'specific_value' => $view->os]) }}">
                                                    {{ $view->os }} {{ $view->os_version }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('links::specific', ['slug' => $link->slug, 'specific' => 'language', 'specific_value' => $view->language]) }}">
                                                    {{ $view->languageFancy() }}
                                                </a>
                                            </td>
                                            <td>{{ $view->ip }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $views->links('links::pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
@endsection
