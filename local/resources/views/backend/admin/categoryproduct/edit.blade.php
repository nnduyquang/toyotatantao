@extends('backend.admin.master')
@section('title-page')
    ập Nhật Chuyên Mục Sản Phẩm
@stop
@section('styles')
@stop
@section('scripts')
@stop
@section('container')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8">
                {{--<h2>Cập Nhật Chuyên Mục Sản Phẩm</h2>--}}
            </div>
            <div class="col-md-4 text-right">
                <a class="btn btn-primary" href="{{ route('categoryproduct.index') }}"> Back</a>
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
    {!! Form::model($categoryproduct,array('route' => ['categoryproduct.update',$categoryproduct->id],'method'=>'PATCH')) !!}
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Tên Chuyên Mục:</strong>
                            {!! Form::text('name',null, array('placeholder' => 'Tên','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <strong>Menu Cấp</strong>
                            <select class="form-control" name="parent">'
                                @foreach($dd_category_products as $key=>$data) {
                                @if($data['index']===$categoryproduct->parent_id)
                                    <option value="{{$data['index']}}" selected>{{$data['value']}}</option>
                                @else
                                    <option value="{{$data['index']}}">{{$data['value']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <strong>Mô Tả Ngắn:</strong>
                            {!! Form::textarea('description',null,array('placeholder' => '','id'=>'description-page','class' => 'form-control','rows'=>'10','style'=>'resize:none')) !!}
                        </div>
                        <div class="form-group">
                            <strong>Thứ Tự:</strong>
                            {!! Form::text('order',null, array('placeholder' => 'Thứ Tự','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Hình Đại Diện: </strong>
                            {!! Form::text('image', url('/').'/'.$categoryproduct->image, array('class' => 'form-control','id'=>'pathImage')) !!}
                            <br>
                            {!! Form::button('Tìm', array('id' => 'btnBrowseImage','class'=>'btn btn-primary')) !!}
                        </div>
                        <div class="form-group">
                            {{ Html::image($categoryproduct->image,'',array('id'=>'showHinh','class'=>'show-image'))}}
                        </div>
                        <div class="form-group">
                            <strong>Hình Đại Diện Trên Mobile: </strong>
                            {!! Form::text('image_mobile', url('/').'/'.$categoryproduct->image_mobile, array('class' => 'form-control','id'=>'pathImageMobile')) !!}
                            <br>
                            {!! Form::button('Tìm', array('id' => 'btnBrowseImageMobile','class'=>'btn btn-primary')) !!}
                        </div>
                        <div class="form-group">
                            {{ Html::image($categoryproduct->image_mobile,'',array('id'=>'showHinhMobile','class'=>'show-image'))}}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div id="seo-part" class="col-md-12 p-0">
                <h3>SEO</h3>
                <div class="content">
                    <div class="show-pattern">
                        <span class="title">{{$categoryproduct->seos->seo_title}}</span>
                        <span class="link">{{URL::to('/')}}/{{$categoryproduct->path}}</span>
                        <span class="description">{{$categoryproduct->seos->seo_description}}</span>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Từ khóa cần SEO</strong>
                            {!! Form::text('seo_keywords',$categoryproduct->seos->seo_keywords, array('placeholder' => 'keywords cách nhau dấu phẩy','class' => 'form-control')) !!}
                            <ul class="error-notice">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <strong>Tiêu Đề (title):</strong>
                        {!! Form::text('seo_title',$categoryproduct->seos->seo_title, array('placeholder' => 'Tên','class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-12 form-group">
                        <strong>Mô Tả (description):</strong>
                        {!! Form::textarea('seo_description',$categoryproduct->seos->seo_description,array('placeholder' => '','id'=>'seo-description-post','class' => 'form-control','rows'=>'10','style'=>'resize:none')) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <strong>Kích Hoạt:</strong>
                <input {{$categoryproduct->isActive==1?'checked':''}} name="page_is_active" data-on="Có"
                       data-off="Không" type="checkbox" data-toggle="toggle">
            </div>
            <div class="col-md-12" style="text-align:  center;">
                <button id="btnDanhMuc" type="submit" class="btn btn-primary">Cập Nhật Chuyên Mục Sản Phẩm</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop