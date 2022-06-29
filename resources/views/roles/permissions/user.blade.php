<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">@lang('user.user') @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> __('user.user')])</p>
        <div>
            <input type="checkbox" value="user-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageUser" name="permissions[]" id="ManageUser"
                @if($permissions['user-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageUser">
                @lang('role.yes-allow', ['attribute'=> __('user.users')])
            </label>
        </div>
        <div style="@if($permissions['user-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageUser">
            <div>
                <input type="checkbox" value="user-add" class="flat-red " name="permissions[]" id="createUser"
                    @if($permissions['user-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createUser">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="user-edit" class="flat-red " name="permissions[]" id="editUser"
                    @if($permissions['user-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editUser">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="user-delete" class="flat-red " name="permissions[]" id="deleteUser"
                    @if($permissions['user-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteUser">
                    @lang('app.delete')
                </label>
            </div>
            <div>
                <input type="checkbox" value="user-impersonate" class="flat-red " name="permissions[]" id="deleteImp"
                    @if($permissions['user-impersonate']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteImp">
                    @lang('user.impersonate')
                </label>
            </div>
        </div>
    </div>
</div>
