@extends('backend.admin.master')
@section('title-page')
    Quản Lý Chuyên Mục
@stop
@section('styles')
@stop
@section('scripts')
@stop
@section('container')
    <div class="col-lg-12 margin-tb">
        <div class="row">
            <div class="col-md-8">
                {{--<h2>Quản Lý Chuyên Mục</h2>--}}
            </div>
            <div class="col-md-4 text-right">
                @permission(('page-create'))
                <a class="btn btn-success" href="{{ route('categorypost.create') }}"> Tạo Mới</a>
                @endpermission
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>TT</th>
            <th>ID</th>
            <th>Tên Chuyên Mục</th>
            <th>Ngày Đăng</th>
            <th>Ngày Cập Nhật</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($categoryposts as $key => $data)
            <td>{{ ++$i }}</td>
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->updated_at }}</td>
            <td>
                @permission(('page-edit'))
                <a class="btn btn-primary" href="{{ route('categorypost.edit',$data->id) }}">Cập Nhật</a>
                @endpermission
                @permission(('page-delete'))
                {!! Form::open(['method' => 'DELETE','route' => ['categorypost.destroy', $data->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
                @endpermission
            </td>
            </tr>
        @endforeach
    </table>
    {{--{!! $pages->links() !!}--}}
@stop