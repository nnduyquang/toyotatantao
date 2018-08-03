<div id="test_info">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <button id="addMoreMenu" type="button" class="btn btn-primary w-100">Thêm Menu Chính</button>
                <button id="addSubMenu" type="button" class="btn btn-primary w-100">Thêm Menu Con</button>
                <div id="tree"></div>
            </div>
            <div class="col-md-9">
                <div class="test_info_right">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="title">Tạo Mới Menu</h3>

                        </div>
                        <div class="col-md-6 text-right">
                            <button id="deleteMenu" type="button" class="btn btn-primary" style="display: none;">Xóa
                                Menu
                            </button>
                            <button id="sumbitFormThuNghiem" type="button" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                    <hr>
                    {!! Form::open(array('id'=>'frmCreateThuNghiem','route' => 'menu.store','method'=>'POST')) !!}

                    {{ Form::hidden('_method', 'POST') }}
                    {{ Form::hidden('state', 'insert') }}
                    {{ Form::hidden('parentId', '') }}
                    {{ Form::hidden('mainId', '') }}
                    {{ Form::hidden('level', '') }}
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Tên Menu <span class="thunghiem"></span>
                        </div>
                        <div class="col-9">
                            <input name="name" class="form-control" type="text" value="" id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Kích Hoạt?
                        </div>
                        <div class="col-9 col-form-label">
                            <div class="form-check">
                                <input name="menu_is_active" class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Chế Độ Hiển Thị Menu
                        </div>
                        <div class="col-9 col-form-label">
                            <select name="type_state_menu" class="custom-select mb-2 mr-sm-2 mb-sm-0"
                                    id="test_info_state_menu">
                                <option value="1" selected>Trang</option>
                                <option value="2">Sản Phẩm</option>
                            </select>
                        </div>
                    </div>
                    <div id="menu_state_page">
                        <div class="form-group row">
                            <div class="col-3 col-form-label">
                                Thuộc Chuyên Mục Bài Viết?
                            </div>
                            <div class="col-9 col-form-label">
                                <div class="form-check">
                                    <input name="state_menu_category" class="form-check-input" type="checkbox"
                                           id="select_state_menu_category">
                                </div>
                            </div>
                        </div>

                        <div id="menu_state_page_category" class="form-group row">
                            <div class="col-3 col-form-label">
                                Chọn Chuyên Mục Bài Viết
                            </div>
                            <div class="col-9 col-form-label">
                                <select name="category_id" class="custom-select mb-2 mr-sm-2 mb-sm-0"
                                        id="inlineFormCustomSelect">
                                    @foreach($category_posts as $key=>$data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="menu_state_page_single" class="form-group row">
                            <div class="col-3 col-form-label">
                                Chọn Trang
                            </div>
                            <div class="col-9 col-form-label">
                                <select name="page_id" class="custom-select mb-2 mr-sm-2 mb-sm-0"
                                        id="inlineFormCustomSelect">
                                    <option value="0">Mặc Định(Không Liên Kết)</option>
                                    @foreach($pages as $key=>$data)
                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Sắp Xếp
                        </div>
                        <div class="col-9 col-form-label">
                            <input name="order" class="form-control w-25" type="text" value="" id="example-text-input">
                        </div>
                    </div>
                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>
</div>