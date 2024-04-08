<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid pl-0">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url(config('lte3.dashboard_slug')) }}">Home</a></li>
                    @if(isset($page_title))
                        <li class="breadcrumb-item active">{!! $page_title  !!}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>

@include('admin.parts.callouts')
@include('admin.parts.alerts')
