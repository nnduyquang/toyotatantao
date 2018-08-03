@extends('backend.admin.master')
@section('title-page')
    Cấu Hình Chung
@stop
@section('container')
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    {{--<h2>Cấu Hình Chung</h2>--}}
                </div>
            </div>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Úi!</strong> Hình Như Có Gì Đó Sai Sai.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! Form::open(array('route' => 'config.store','method'=>'POST')) !!}

    @foreach($cauhinhs as $key=>$cauhinh)
        @if($cauhinh->name=='config-contact')
            <div class=" col-md-12">
                <div class="form-group">
                    <label style="font-weight: bold">Nội Dung Liên Hệ:</label>
                    {!! Form::textarea('config-contact',$cauhinh->content, array('placeholder' => 'Nội Dung','id'=>'description-page','class' => 'form-control','rows'=>'10','style'=>'resize:none')) !!}
                    {{ Form::hidden('hd-config-contact', $cauhinh->content) }}
                </div>
            </div>
        @endif
    @endforeach
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button id="btnDanhMuc" type="submit" class="btn btn-primary">Lưu Cấu Hình</button>
    </div>

    {!! Form::close() !!}
@stop