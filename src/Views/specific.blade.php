@extends(config('links.layout'))

@section('title', "Link: $link->slug - $specific_value - Links - Automatic links statistics")

@section('bigTitle', "$specific_value Link Statistics")

@section('subtitle', $link->shortered())

@section('actions')
    <a class="btn btn-secondary" href="{{ route('links::links') }}">All Links</a>
    <a class="btn btn-secondary" href="{{ route('links::link', ['slug' => $link->slug]) }}">Disable Filter</a>
@endsection

@section('content')
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ count($views) }}</span><br>
                                <span class="statistic-text">Views</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ count(collect($views)->groupBy('ip')) }}</span><br>
                                <span class="statistic-text">Unique Views</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <?php
                                    if ($specific == 'browser') {
                                        $title = "$specific_value Version";
                                        $grouper = 'browser_version';
                                    } else {
                                        $title = "$specific_value used browsers";
                                        $grouper = 'browser';
                                    }
                                ?>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($views, 'donut', 'morris')
                                        ->setTitle($title)->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy($grouper)->render();
                                !!}
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <?php
                                    if ($specific == 'os') {
                                        $title = "$specific_value Version";
                                        $grouper = 'os_version';
                                    } else {
                                        $title = "$specific_value used Operating Systems";
                                        $grouper = 'os';
                                    }
                                ?>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($views, 'donut', 'morris')
                                        ->setTitle($title)->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy($grouper)->render();
                                !!}
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <?php
                                    if ($specific == 'languages') {
                                        $title = "$specific_value Version";
                                        $grouper = 'language_version';
                                    } else {
                                        $title = "$specific_value used languages";
                                        $grouper = 'language';
                                    }
                                ?>
                                {!!
                                    ConsoleTVs\Charts\Charts::database($views, 'donut', 'morris')
                                        ->setTitle($title)->setDimensions(0, 300)->setResponsive(false)
                                        ->groupBy($grouper)->render();
                                !!}
                            </center>
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
                                        @foreach($o_views = ConsoleTVs\Links\Models\View::where(['link_id' => $link->id, $specific => $raw_specific_value])->paginate(10) as $view)
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
                                {{ $o_views->links('links::pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
@endsection
