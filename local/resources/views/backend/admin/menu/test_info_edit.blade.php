<div id="test_info">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100">Thêm Menu Chính</button>
                <button type="button" class="btn btn-primary w-100">Thêm Menu Con</button>
            </div>
            <div class="col-md-9">
                <div class="test_info_right">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Tên Menu</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                    <hr>
                    {{ Form::open() }}
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Tên Menu
                        </div>
                        <div class="col-9">
                            <input class="form-control" type="text" value="" id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Kích Hoạt?
                        </div>
                        <div class="col-9 col-form-label">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Chế Độ Hiển Thị Menu
                        </div>
                        <div class="col-9 col-form-label">
                            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="test_info_state_menu">
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
                                    <input class="form-check-input" type="checkbox" id="select_state_menu_category">
                                </div>
                            </div>
                        </div>

                        <div id="menu_state_page_category" class="form-group row">
                            <div class="col-3 col-form-label">
                                Chọn Chuyên Mục Bài Viết
                            </div>
                            <div class="col-9 col-form-label">
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">
                                    <option value="1" selected>Hỏi Đáp Google</option>
                                    <option value="2">Hỏi Đáp Website</option>
                                    <option value="2">Hỏi Đáp Facebook</option>
                                </select>
                            </div>
                        </div>
                        <div  id="menu_state_page_single" class="form-group row">
                            <div class="col-3 col-form-label">
                                Chọn Trang
                            </div>
                            <div class="col-9 col-form-label">
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">
                                    <option value="1" selected>Giới Thiệu</option>
                                    <option value="2">Trang A</option>
                                    <option value="2">Trang B</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            Sắp Xếp
                        </div>
                        <div class="col-9 col-form-label">
                            <input class="form-control w-25" type="text" value="" id="example-text-input">
                        </div>
                    </div>
                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>
</div>