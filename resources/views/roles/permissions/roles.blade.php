<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">@lang('role.role') @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> __('role.role')])</p>
        <div>
            <input type="checkbox" value="role-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageRole" name="permissions[]" id="ManageRole"
                @if($permissions['role-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageRole">
                @lang('role.yes-allow', ['attribute'=> __('role.roles')])
            </label>
        </div>
        <div style="@if($permissions['role-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageRole">
            <div>
                <input type="checkbox" value="role-add" class="flat-red " name="permissions[]" id="createRole"
                    @if($permissions['role-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createRole">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="role-edit" class="flat-red " name="permissions[]" id="editRole"
                    @if($permissions['role-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editRole">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="role-delete" class="flat-red " name="permissions[]" id="deleteRole"
                    @if($permissions['role-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteRole">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
