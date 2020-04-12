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
            <form method="POST" action="{{route('bookmarks.update', ['bookmark' => $bookmark->id])}}">
                @method('PUT')
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Обновляем закладку</h3>
                        @include('admin.errors')
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{$bookmark->title}}" required>

                                <label for="slug">Код</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       value="{{$bookmark->slug}}">

                                <label for="url_origin">URL</label>
                                <input type="text" class="form-control" id="url_origin" name="url_origin"
                                       value="{{$bookmark->url_origin}}">

                                <img src="{{$bookmark->getImage('favicon')}}" class="img-responsive" width="64" alt="">
                                <label for="favicon">favicon</label>
                                <input type="file" id="favicon" name="favicon">

                                <label for="meta_description">meta_description</label>
                                <input type="text" class="form-control" id="meta_description" name="meta_description"
                                       value="{{$bookmark->meta_description}}">

                                <label for="meta_keywords">meta_keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                       value="{{$bookmark->meta_keywords}}">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-warning pull-right">Изменить</button>
                    </div>
                </div>
                <!-- /.box -->
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
