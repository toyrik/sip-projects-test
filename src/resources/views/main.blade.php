@extends('layouts.app')
@section('content')
    <div class="card col-md-10">
        <div class="card-body">
            <form action="saveFile" method="POST" enctype="multipart/form-data">
                @CSRF

                <input type="file" name="file-name" class="form-control mt-2">

                <input type="submit" value="Сохранить" class="btn btn-outline-primary mt-2">
            </form>
        </div>
    </div>
@endsection
