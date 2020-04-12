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
            <form method="POST" action="{{route('bookmarks.store')}}">
                @csrf

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Добавляем закладку</h3>
                        @include('errors')
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url_origin">URL новой закладки</label>
                                <input type="text" class="form-control" id="url_origin" name="url_origin"
                                       value="{{old('url_origin')}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a class="btn btn-default" href="{{route('bookmarks.index')}}">Назад</a>
                        <button class="btn btn-success pull-right">Добавить</button>
                    </div>

                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
