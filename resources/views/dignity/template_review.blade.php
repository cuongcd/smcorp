<div id="product_review">

    <div class="modal fade bs-example-modal-lg tax" id="add_new_cv" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow-y: hidden;">
        <div class="modal-dialog modal-lg tax">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Thêm Mới Phẩm Chất Cá Nhân</h4>
                </div>
                <div class="modal-body">
                    <label class="col-lg-3 control-label">Tên:</label>

                    <div class="col-lg-9">
                        <input type="text" class="form-control" id='newname' name="newname">
                    </div>
                </div>
                <div class="modal-body">
                    <label class="col-lg-3 control-label">Điểm Trừ :</label>

                    <div class="col-lg-9">
                        <input type="number" class="form-control" id='diemtru' name="diemtru" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_cv" class="btn btn-success" data-dismiss="modal">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <label class="control-label">Phẩm Chất Cá Nhân</label>
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
                            <select class="form-control input-sm valid" id="room_id" name="room_id" aria-invalid="false">
                                <option value=""></option>
                                @foreach(\App\Helpers\Room::getListRoom() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>


                        <label class="col-lg-2 control-label">Chức Danh</label>

                        <div class="col-lg-2">
                            <select class="form-control input-sm valid" id="position_id" name="position_id" aria-invalid="false">

                            </select>
                        </div>
                        <label class="col-lg-1 control-label">Bậc</label>

                        <div class="col-lg-2">
                            <select class="form-control input-sm valid" id="level_id" name="level_id" aria-invalid="false">
                                @foreach(\App\Helpers\Level::getListLevel() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <div class="btn btn-sm btn-primary right" style="margin-left: 10px"
                                 id="add_new_key">
                                <i class="fa fa-plus"></i>
                                <span class="bold" data-toggle="modal" data-target="#add_new_cv">Thêm </span>
                            </div>
                        </div>
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
        $("#progress-grid-content").css("display", "block");
        getGrid();
        $('#product-review').one('click', function () {
            getGrid();
        });
        $('#room_id').change(function(){

            $("#ajax-loading-mask").show();
            $("#ajax-loading").show();
            $.ajax({
                type: "GET",
                data: {'_id': $('#room_id').val()},
                url: 'positions/getlist',
                success: function (response) {
                    $('#position_id').html(response);
                    $("#position_id").val($("#position_id option:first").val());
                    $("#ajax-loading-mask").hide();
                    $("#ajax-loading").hide();
                }, error: function (response) {
                    $("#ajax-loading-mask").hide();
                    $("#ajax-loading").hide();
                }
            });
            getGrid();
        });
        $('#position_id').change(function(){
            getGrid();
        });
        $('#level_id').change(function(){
            getGrid();
        });

        $('#save_cv').click(function(){
            var room_id = parseInt($('#room_id').val());
            var level_id = parseInt($('#level_id').val());
            var position_id = parseInt($('#position_id').val());
            var name = $('#newname').val();
            var heso = parseInt($('#diemtru').val());
            if(room_id <= 0 || isNaN(room_id)) {
                alert('bạn chưa chọn phòng!!!');
                return;
            }
            if(level_id <= 0 || isNaN(level_id)) {
                alert('bạn chưa chọn bậc!!!');
                return;
            }
            if(position_id <= 0 || isNaN(position_id)){
                alert('bạn chưa chọn chức danh!!!');
                return;
            }
            if(heso <= 0 || isNaN(heso))
            {
                alert('bạn chứa điền hệ số !!!');
                return;
            }
            if(name.length < 3)
            {
                alert('bạn chưa điền tên công việc');
                return;
            }

            $.ajax({
                data: {
                    'room_id': room_id,
                    'level_id': level_id,
                    'chucdanh_id': position_id,
                    'name' : name,
                    'diemtru' : heso,
                },
                url: "/dignities/addnew",
                beforeSend: function () {

                },
                success: function (response) {
                    alert('Thêm thành công');
                    getGrid();

                }
            });

        });
        function getGrid(){
            if(typeof($('#position_id').val()) === "null" )
                return;
            var room_id = $('#room_id').val();
            var level_id = $('#level_id').val();
            var position_id = $('#position_id').val();
            $.ajax({
                data: {'room_id': room_id,
                    'level_id': level_id,
                    'position_id': position_id,
                },
                url: "/dignities/reviews",
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
            $("#progress-grid-content").css("display", "block");
        }
    });
</script>