@extends('bookmarks.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Закладки</h1>
        </section>

        <!-- Search form -->
        <form method="POST" action="{{route('bookmarks_search')}}"
              class="form-inline d-flex justify-content-center md-form form-sm mt-0">
            @csrf
            <i class="fas fa-search" aria-hidden="true"></i>
            <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
                   aria-label="Search" name="search">
        </form>


        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Список всех закладок</h3>
                </div>
            @include('errors')
            <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('bookmarks.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="data_table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Дата добавления @include('components.order', ['thisOrderBy' => 'created_at'])</th>
                            <th>Favicon</th>
                            <th>URL страницы @include('components.order', ['thisOrderBy' => 'url_origin'])</th>
                            <th>Заголовок страницы @include('components.order', ['thisOrderBy' => 'title'])</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookmarks as $bookmark)
                            <tr>
                                <td>{{$bookmark->created_at}}</td>
                                <td><img src="{{$bookmark->favicon}}" alt="{{$bookmark->favicon}}" width="32"></td>
                                <td>
                                    <a href="{{$bookmark->url_origin}}" target="_blank">{{$bookmark->url_origin}}</a>
                                </td>
                                <td>
                                    <a href="{{route('bookmarks.show', ['bookmark' => $bookmark->id])}}">{{$bookmark->title}}</a>
                                </td>
                                <td style="display: flex;">
                                    <a href="{{route('bookmarks.show', ['bookmark' => $bookmark->id])}}"><i
                                            class="fas fa-external-link-alt"></i></a>
                                    <a href="{{route('bookmarks.edit', $bookmark->id)}}"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <form method="POST" class="@if(!empty($bookmark->token)) remove_form @endif"
                                          action="{{route('bookmarks.destroy', ['bookmark' => $bookmark->id])}}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" onclick='confirm("are you sure?")' class="delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $bookmarks->links() }}
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <a href="/bookmarks/unload">
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
