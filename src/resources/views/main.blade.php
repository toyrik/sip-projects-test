@extends('layouts.app')
@section('content')
    <div class="card col-md-10">
        <div class="card-body">
            <form action="upload" method="POST" enctype="multipart/form-data">
                @CSRF
                <input type="file" name="file-name" class="form-control mt-2">
                <input type="submit" value="Сохранить" class="btn btn-outline-primary mt-2">
            </form>
        </div>
    </div>
    <div>
        @if(!empty($result['data']) ?? [])
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">
                            Dowload
                        </th>
                        <th scope="col">
                            Size
                        </th>
                        <th scope="col">
                            Time create
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result['data'] as $file)
                        <tr>
                            <td>
                                <a href="{{ route('download').'?path='.$file['name'] }}"> {{ $file['name'] }} </a></td>
                            <td>{{ $file['size'] }}</td>
                            <td>{{ $file['created_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if (!empty($countPage ?? 0))
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="{{route('home') . '?page=' . ($page-1)}}">Previous</a>
                        </li>

                        @for ($i = 1; $i <= $countPage; $i++)
                            @if ($i == $page)
                                <li class="page-item active">
                                    <a class="page-link" href="{{route('home') . '?page=' . $i}}">{{$i}}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{route('home') . '?page=' . $i}}">{{$i}}</a>
                                </li>
                            @endif
                        @endfor

                        <li class="page-item">
                            <a class="page-link" href="{{route('home') . '?page=' . ($page+1)}}">Next</a>
                        </li>
                    </ul>
                </nav>
            @endif
        @else
            <h5>Здесь ничего нет!</h5>
        @endif
    </div>
@endsection
