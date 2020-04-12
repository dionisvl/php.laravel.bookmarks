@extends('bookmarks.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Закладки</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Список всех закладок</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('bookmarks.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="data_table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Дата добавления</th>
                            <th>Favicon</th>
                            <th>URL страницы</th>
                            <th>Заголовок страницы</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookmarks as $bookmark)
                            <tr>
                                <td>{{$bookmark->created_at}}</td>
                                <td><img src="" alt="{{$bookmark->favicon}}" width="64"></td>
                                <td>{{$bookmark->url_origin}}</td>
                                <td>
                                    <a href="{{route('bookmarks.show', ['bookmark' => $bookmark->id])}}">{{$bookmark->title}}</a>
                                </td>
                                <td>
                                    <a href="{{route('bookmarks.edit', $bookmark->id)}}"><i
                                            class="fas fa-pencil-alt"></i></a>

                                    <form method="POST"
                                          action="{{route('bookmarks.destroy', ['bookmark' => $bookmark->id])}}">
                                        @method('delete')
                                        @csrf
                                        {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

                                        <button onclick="return confirm('are you sure?')" type="submit" class="delete">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                    <a href="{{route('bookmarks.show', ['bookmark' => $bookmark->id])}}"><i
                                            class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <a href="/bookmarks/download">
                        <i class="fas fa-file-excel"></i> Скачать в EXCEL <i class="fas fa-file-download"></i>
                    </a>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection