@extends("layouts.appboss")
@section('title', $title ?? 'Revenue')
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Revenue</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Revenue' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('boss.revenue.index') }}" class="form-inline mb-3">
                                <div class="form-group mr-2">
                                    <label for="filter_type" class="mr-2">Filter by:</label>
                                    <select name="filter_type" id="filter_type" class="form-control" style="width: 100px">
                                        <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Month</option>
                                        <option value="quarter" {{ request('filter_type') == 'quarter' ? 'selected' : '' }}>Quarter</option>
                                        <option value="year" {{ request('filter_type') == 'year' ? 'selected' : '' }}>Year</option>
                                    </select>
                                </div>
                                <div class="form-group mr-2">
                                    <label for="filter_value" class="mr-2">Value:</label>
                                    <input type="number" name="filter_value" id="filter_value" class="form-control" placeholder="Enter month/year"
                                           value="{{ request('filter_value') }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section("pagescript")
    <script>
        const REVENUE_API_URL = "{{ route('boss.revenue.index') }}";
        const revenueData = @json($data);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/boss/revenue/index.js?t='.config('constants.app_version') )}}"></script>
    <script>
        console.log("JS URL:", "{{ asset('js/boss/revenue/index.js') }}");
    </script>
@endsection


