<div id="product_review">
    <label class="control-label">Kết Quả Đánh Giá Lao Động</label>

    <div class="ibox float-e-margins" id="productReviews">
        <div class="ibox-title">
            <div class="ibox-tools">
                <a class="collapse-link" id="product-review"><i class="fa fa-chevron-down"></i></a>
            </div>
        </div>

        <div class="row" style="margin-top: 10px">
            <div class="col-lg-12">
                <fieldset>
                    <div class="form-group locale-element">
                        <label class="col-lg-1 control-label">Phòng</label>

                        <div class="col-lg-2">
                            <select class="form-control input-sm valid" id="room_id" name="room_id"
                                    aria-invalid="false">
                                <option value=""></option>
                                @foreach(\App\Helpers\Room::getListRoom() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-lg-1 control-label">Tháng</label>

                        <div class="col-lg-2">
                            <input type="date" id="thang_id" name="thang_id">
                            {{--<select class="form-control input-sm valid" id="thang_id" name="thang_id"--}}
                                    {{--aria-invalid="false">--}}
                                {{--<option value=""></option>--}}
                                {{--@foreach(\App\Helpers\Month::getAllMonth() as $key => $value)--}}
                                    {{--<option value="{{$key}}">{{$value}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        </div>
                        @if(\App\Helpers\VaiTro::getEditBan())
                            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                                 id="un_apply_all" name="un_apply_all">
                                <i class="fa-yoast"></i>
                                <span class="bold" data-toggle="modal" data-target="#apply_all">Bỏ Duyệt Toàn Đơn Vị</span>
                            </div>
                            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                                 id="apply_all" name="apply_all">
                                <i class="fa-yoast"></i>
                                <span class="bold" data-toggle="modal" data-target="#apply_all">Duyệt Toàn Đơn Vị</span>
                            </div>
                            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                                 id="un_apply" name="un_apply">
                                <i class="fa-yoast"></i>
                                <span class="bold" data-toggle="modal" data-target="#apply">Bỏ Duyệt</span>
                            </div>
                            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                                 id="apply" name="apply">
                                <i class="fa-yoast"></i>
                                <span class="bold" data-toggle="modal" data-target="#apply">Duyệt</span>
                            </div>
                        @endif
                    </div>
                    <div class="hr-line-dashed"></div>
                </fieldset>
            </div>
        </div>

        <div>
            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                 id="export_execel" name="export_execel">
                <i class="fa fa-download"></i>
                <span class="bold" data-toggle="modal" data-target="#add_new_tiendo">Xuất File</span>
            </div>
            <div class="btn btn-sm btn-info download-button right" style="margin-left: 10px"
                 id="export_all_execel" name="export_all_execel">
                <i class="fa fa-download"></i>
                <span class="bold" data-toggle="modal" data-target="#add_new_tiendo">In Tất Cả</span>
            </div>
            <div id="reviewGrid"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#contentReview").css("display", "block");
        $("#staffs-grid-content").css("display", "block");
        getGrid();
        $('#product-review').one('click', function () {
            getGrid();
        });
        $('#room_id').change(function () {
            getGrid();
        });
        $('#thang_id').change(function () {
            getGrid();
        });
        $('#export_execel').click(function () {
            var room_id = $('#room_id').val();
            var thang_id = $('#thang_id').val();
            window.location.assign("/result/export?room_id=" + room_id + "&thang_id=" + thang_id);
        });
        $('#export_all_execel').click(function () {
            var room_id = $('#room_id').val();
            var thang_id = $('#thang_id').val();
            if (isNaN(parseInt($thang_id))) {
                alert('bạn chưa chọn tháng để in kết quả đánh giá');
                return;
            }
            window.location.assign("/result/printketqua?room_id=" + room_id + "&thang_id=" + thang_id);
        });
        $('#apply').click(function () {
            var thang_id = $('#thang_id').val();
            var room_id = parseInt($('#room_id').val());
            if (isNaN(parseInt(thang_id)) || isNaN(room_id)){
                alert('bạn chưa chọn tháng hoặc phòng để duyệt đánh giá');
                return
            }

            $.ajax({
                data: {
                    'room_id': room_id,
                    'thang_id': thang_id
                },
                url: "/result/apply",
                beforeSend: function () {
                    $('#ajax-loading-mask').show();
                    $('#ajax-loading').show();
                },
                success: function (response) {
                    $('#ajax-loading-mask').hide();
                    $('#ajax-loading').hide();
                    alert('Đã duyệt thành công  đánh giá cho ' + thang_id);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");
        });
        $('#apply_all').click(function () {
            var thang_id = $('#thang_id').val();
            if (isNaN(parseInt(thang_id))) {
                alert('bạn chưa chọn tháng để duyệt đánh giá');
                return;
            }
            $.ajax({
                data: {
                    'thang_id': thang_id
                },
                url: "/result/apply-all",
                beforeSend: function () {
                    $('#ajax-loading-mask').show();
                    $('#ajax-loading').show();
                },
                success: function (response) {
                    $('#ajax-loading-mask').hide();
                    $('#ajax-loading').hide();
                    alert('Đã duyệt thành công đánh giá toàn đơn vị cho ' + thang_id);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");

        })


        $('#un_apply').click(function () {
            var thang_id = $('#thang_id').val();
            var room_id = parseInt($('#room_id').val());

            if (isNaN(parseInt(thang_id)) || isNaN(room_id)){
                alert('bạn chưa chọn tháng hoặc phòng để duyệt đánh giá');
                return
            }

            $.ajax({
                data: {
                    'room_id': room_id,
                    'thang_id': thang_id,
                    'un_apply' : 1,
                },
                url: "/result/apply",
                beforeSend: function () {
                    $('#ajax-loading-mask').show();
                    $('#ajax-loading').show();
                },
                success: function (response) {
                    $('#ajax-loading-mask').hide();
                    $('#ajax-loading').hide();
                    alert('Đã bỏ duyệt thành công  đánh giá cho ' + thang_id);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");
        });
        $('#un_apply_all').click(function () {
            var thang_id = $('#thang_id').val();
            if (isNaN(parseInt(thang_id))) {
                alert('bạn chưa chọn tháng để duyệt đánh giá');
                return;
            }
            $.ajax({
                data: {
                    'thang_id': thang_id,
                    'un_apply' : 1
                },
                url: "/result/apply-all",
                beforeSend: function () {
                    $('#ajax-loading-mask').show();
                    $('#ajax-loading').show();
                },
                success: function (response) {
                    $('#ajax-loading-mask').hide();
                    $('#ajax-loading').hide();
                    alert('Đã bỏ duyệt thành công đánh giá toàn đơn vị cho ' + thang_id);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");

        })

//        $(document).on('click', 'table tbody tr', function () {
//            alert('abc');
//        });
//        $('div.ibox-content table tbody tr').click(function () {
//            alert('a');
//        });
//        $("tr").click(function () {
////            $(this).closest("tr").siblings().removeClass("highlighted");
////            $(this).toggleClass("highlighted");
//            alert('a');
//        });
        function getGrid() {
            var room_id = $('#room_id').val();
            var thang_id = $('#thang_id').val();
            $.ajax({
                data: {
                    'room_id': room_id,
                    'thang_id': thang_id
                },
                url: "/result/reviews",
                beforeSend: function () {
                    $('#ajax-loading-mask').show();
                    $('#ajax-loading').show();
                },
                success: function (response) {
                    $('#ajax-loading-mask').hide();
                    $('#ajax-loading').hide();
                    $('#reviewGrid').html(response);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");
        }
    });
</script>