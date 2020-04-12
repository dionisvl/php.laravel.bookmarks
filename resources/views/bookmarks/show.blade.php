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
                <div class="box-header with-border">
                    <h3 class="box-title">Детальная информация о закладке</h3>
                </div>

                @if($bookmark)
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <div type="text" class="border border-primary rounded" id="title"
                                     name="title">{{$bookmark->title}}</div>

                                <label for="url_origin">URL</label>
                                <div type="text" class="border border-primary rounded" id="url_origin"
                                     name="url_origin"><a href="{{$bookmark->url_origin}}"
                                                          target="_blank">{{$bookmark->url_origin}}</a></div>

                                <label for="favicon">favicon</label>
                                <div type="file" id="favicon" name="favicon" class="border border-primary rounded">
                                    <img src="{{$bookmark->favicon}}" id="favicon" class="img-responsive" width="64"
                                         alt="{{$bookmark->favicon}}">
                                </div>

                                <label for="meta_description">meta_description</label>
                                <div type="text" class="border border-primary rounded" id="meta_description"
                                     name="meta_description">{{$bookmark->meta_description}}</div>

                                <label for="meta_keywords">meta_keywords</label>
                                <div type="text" class="border border-primary rounded" id="meta_keywords"
                                     name="meta_keywords">{{$bookmark->meta_keywords}}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="box-footer">
                    <a class="btn btn-info" href="{{route('bookmarks.index')}}">Назад</a>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
