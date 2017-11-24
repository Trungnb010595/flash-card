<div id="login_popup" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login to continue...</h4>
            </div>
            <div class="modal-body">
                <div class="form-group clearfix" style="padding-top: 20px; padding-bottom: 20px">
                    <div class="col-md-6 btn_login btn_login_face text-right">
                        <a href="{{route('facebook.login')}}">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            <div class="text_description">Đăng nhập qua facebook</div>
                        </a>
                    </div>
                    <div class="col-md-6 btn_login btn_login_gg text-left">
                        <a href="{{route('google.login')}}">
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                            <div class="text_description">Đăng nhập qua google</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    #login_popup .text_description{
        display: inline-block;
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding-left: 10px;
        line-height: 16px;
        font-size: 12px;
        margin-left: 9px;
    }
    #login_popup .btn_login a{
        padding: 11px 13px 13px 13px;
        color: #fff;
        text-decoration: none;
        border-radius: 2px;
    }
    #login_popup .btn_login_face a{
        background: #516eab;
    }
    #login_popup .btn_login_gg a{
        background: #eb4026;
    }

</style>