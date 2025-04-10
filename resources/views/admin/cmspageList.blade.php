@extends('admin.includes.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">CMS Pages</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Manage CMS</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <input class="form-control px-5" type="search" placeholder="Search Page">
                    <span
                        class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">

            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="{{route('managecms') }}" class="btn btn-primary px-4"><i
                            class="bi bi-plus-lg me-2"></i>Manage CMS</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Pages URL</th>
                            <th>Meta Title</th>
                            <th>Meta Keywords</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach ($cmspages as $key=>$pagedata)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $pagedata->title }}</td>
                            <td>{{ $pagedata->url }}</td>
                            <td>{{ $pagedata->meta_title }}</td>
                            <td>{{ $pagedata->meta_keywords }}</td>
                            <td>{{ $pagedata->status }}</td>
                            <td>
                            <a href="{{ route('managecms', $pagedata->id) }}" class="btn btn-success btn-sm">Edit</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</main>

@endsection