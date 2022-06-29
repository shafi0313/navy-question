<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">@lang('app.setting') @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> __('app.setting')])</p>
        <div>
            <input type="checkbox" value="setting-manage" class="flat-red hasChildOptions" data-child_id="childOfManageSettingManage" name="permissions[]" id="ManageSettingManage"
                @if($permissions['setting-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSettingManage">
                @lang('role.yes-allow', ['attribute'=> __('app.settings')])
            </label>
        </div>
        <div style="@if($permissions['setting-manage'] == 1) display:block @else display:none @endif" id="childOfManageSettingManage">
            {{-- <div>
                <input type="checkbox" value="system-manage" class="flat-red " name="permissions[]" id="system-manage"
                    @if($permissions['system-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="system-manage">
                    @lang('setting.system-manage')
                </label>
            </div> --}}
            {{-- <div>
                <input type="checkbox" value="website-manage" class="flat-red " name="permissions[]" id="website-manage"
                    @if($permissions['website-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="website-manage">
                    @lang('setting.website-manage')
                </label>
            </div> --}}
            {{-- <div>
                <input type="checkbox" value="school-manage" class="flat-red " name="permissions[]" id="school-manage"
                    @if($permissions['school-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="school-manage">
                    @lang('setting.school-manage')
                </label>
            </div> --}}
            {{-- <div>
                <input type="checkbox" value="payment-manage" class="flat-red " name="permissions[]" id="payment-manage"
                    @if($permissions['payment-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="payment-manage">
                    @lang('setting.payment-manage')
                </label>
            </div> --}}
            <div>
                <input type="checkbox" value="language-manage" class="flat-red " name="permissions[]" id="language-manage"
                    @if($permissions['language-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="language-manage">
                    @lang('setting.language-manage')
                </label>
            </div>
            {{-- <div>
                <input type="checkbox" value="smtp-manage" class="flat-red " name="permissions[]" id="smtp-manage"
                    @if($permissions['smtp-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="smtp-manage">
                    @lang('setting.smtp-manage')
                </label>
            </div> --}}
            {{-- <div>
                <input type="checkbox" value="about-manage" class="flat-red " name="permissions[]" id="about-manage"
                    @if($permissions['about-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="about-manage">
                    @lang('setting.about-manage')
                </label>
            </div> --}}
            {{-- <div>
                <input type="checkbox" value="sms-manage" class="flat-red " name="permissions[]" id="sms-manage"
                    @if($permissions['sms-manage']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="sms-manage">
                    @lang('setting.sms-manage')
                </label>
            </div> --}}
        </div>
    </div>
</div>
