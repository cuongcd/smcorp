<div id="product_review">
    <label class="control-label">Danh Sách Công Việc Được Giao</label>

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
                        <label class="col-lg-1 control-label">Tháng</label>
                        <div class="col-lg-2">
                            <input type="date" id="month_id" name = "month_id">
                            {{--<select class="form-control input-sm valid" id="month_id" name="month_id"--}}
                                    {{--aria-invalid="false">--}}
                                {{--<option value=""></option>--}}
                                {{--@foreach(\App\Helpers\Month::getAllMonth() as $key => $value)--}}
                                    {{--<option value="{{$key}}">{{$value}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        </div>
                        <label class="col-lg-3 control-label" style="color: red">Tháng Hiện Tại: {{\App\Helpers\Month::getCurrentMonth()->name}} </label>
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
        function getGrid() {
            var month_id = $('#month_id').val();
            $.ajax({
                data: {
                    'thang_id' : month_id
                },
                url: "/job/job",
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