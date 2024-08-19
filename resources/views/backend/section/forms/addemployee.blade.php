@extends('backend.layouts.layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>Yeni </h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">General</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card card-success w-50">
                        <div class="card-header">
                            <h3 class="card-title">Yeni Kataqoriya Əlavə Et</h3>
                        </div>
                        <form action="{{route('addpemployee')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="employeenameid">İşçi Adı</label>
                                    <input type="text" name="empname" class="form-control" id="employeenameid"
                                        placeholder="İşçi Adı">
                                </div>
                                <div class="form-group">
                                    <label for="employeesurnameid">İşçi Soydı</label>
                                    <input type="text" name="empsurname" class="form-control" id="employeesurnameid"
                                        placeholder="İşçi Adı">
                                </div>
                                <div class="form-group">
                                    <label for="employeeroleid">Vəzifəsi</label>
                                    <input type="text" name="empsurrole" class="form-control" id="employeeroleid"
                                        placeholder="İşçi Adı">
                                </div>
                                <div class="form-group">
                                    <label for="employeeimgid">
                                        <input type="file" name="empimg" id="employeeimgid">
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="empcheck" class="form-check-input" id="employeecheckid">
                                    <label class="form-check-label" for="employeecheckid">Statusu</label>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">İşçini əlavə edin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

