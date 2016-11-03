@extends(config('links.layout'))

@section('title', 'Links - Automatic links statistics')

@section('bigTitle', 'Links')

@section('subtitle', 'Automatic links statistics')

@section('content')

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ count($links = ConsoleTVs\Links\Models\Link::all()) }}</span><br>
                                <span class="statistic-text">Total Links</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <span class="statistic">{{ count($views = ConsoleTVs\Links\Models\View::all()) }}</span><br>
                                <span class="statistic-text">Total Views</span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <?php
                                    $unique_views = [];
                                    foreach ($links as $link) {
                                        $unique_views = array_merge($unique_views, $link->uniqueViews()->toArray());
                                    }
                                ?>
                                <span class="statistic">{{ count($unique_views) }}</span><br>
                                <span class="statistic-text">Total Unique Views</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            {!!
                                ConsoleTVs\Charts\Charts::database($views, 'line', 'morris')
                                    ->setTitle($t = 'Total Views')->setDimensions(0, 300)->setResponsive(false)
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
                                            <th>#</th>
                                            <th>Slug</th>
                                            <th>Views</th>
                                            <th>Unique Views</th>
                                            <th>Original URL</th>
                                            <th>Short URL</th>
                                            <th>Statistics</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($links = ConsoleTVs\Links\Models\Link::paginate(10) as $link)
                                        <tr>
                                            <td>{{ $link->id }}</td>
                                            <td>{{ $link->slug }}</td>
                                            <td>{{ $link->totalViews() }}</td>
                                            <td>{{ $link->totalUniqueViews() }}</td>
                                            <td>
                                                <a href="{{ $link->url }}" class="btn btn-secondary btn-sm btn-block" data-toggle="tooltip" data-placement="bottom" title="{{ $link->url }}">Visit</a>
                                            </td>
                                            <td>
                                                <a href="{{ $link->shortered() }}" class="btn btn-secondary btn-sm btn-block" data-toggle="tooltip" data-placement="bottom" title="{{ $link->shortered() }}">Visit</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('links::link', ['slug' => $link->slug]) }}" class="btn btn-primary btn-sm btn-block">Statistics</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $links->links('links::pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
