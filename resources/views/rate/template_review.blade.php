<div id="product_review">
    <label class="control-label">Danh Sách Nhân Viên</label>

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
                                @foreach(\App\Helpers\Room::getRoomPhuTrach() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-lg-1 control-label">Tháng</label>

                        <div class="col-lg-2">
                            <input type="date" id="month_id" name="month_id" >
                            {{--<select class="form-control input-sm valid" id="month_id" name="month_id" --}}
                                    {{--aria-invalid="false">--}}
                                {{--<option value=""></option>--}}
                                {{--@foreach(\App\Helpers\Month::getAllMonth() as $key => $value)--}}
                                    {{--<option value="{{$key}}">{{$value}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}

                            {{--<input type="text" name="city" list="cityname">--}}
                            {{--<datalist id="cityname">--}}
                                {{--<option value="Boston">--}}
                                {{--<option value="Cambridge">--}}
                            {{--</datalist>--}}
                        </div>
                        <label class="col-lg-3 control-label" style="color: red">Tháng Đánh Giá: {{\App\Helpers\Month::getCurrentMonth()->name}} </label>
                        @if(\App\Helpers\VaiTro::getEditPhong())
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
        $('#month_id').change(function(){
            getGrid()
        });

        $('#un_apply').click(function () {
            var thang_id = $('#month_id').val();
            var room_id = parseInt($('#room_id').val());
            var thang_name = thang_id;

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
                    alert('Đã bỏ duyệt thành công  đánh giá cho ' + thang_name);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");
        });
        $('#apply').click(function () {
            var thang_id = $('#month_id').val();
            var room_id = parseInt($('#room_id').val());
            var thang_name = thang_id;
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
                    alert('Đã duyệt thành công  đánh giá cho ' + thang_name);
                }
            });
            $("#contentReview").css("display", "block");
            $("#staffs-grid-content").css("display", "block");
        });
        function getGrid() {
            var room_id = parseInt($('#room_id').val());
            var month_id = $('#month_id').val();
            if(isNaN(room_id))
                return;
            $.ajax({
                data: {
                    'room_id': room_id,
                    'thang_id' : month_id
                },
                url: "/rates/reviews",
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
        $(document).on('click', 'table tbody [name="editdanhgia"]', function () {
            alert('abc');

        });
    });
</script>