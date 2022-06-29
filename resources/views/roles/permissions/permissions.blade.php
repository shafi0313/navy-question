<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">@lang('role.permission') @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> __('role.permission')])</p>
        <div>
            <input type="checkbox" value="permission-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManagePermission" name="permissions[]" id="ManagePermission"
                @if($permissions['permission-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManagePermission">
                @lang('role.yes-allow', ['attribute'=> __('role.permissions')])
            </label>
        </div>
        <div style="@if($permissions['permission-manage'] == 1) display:block @else display:none @endif"
            id="childOfManagePermission">
            <div>
                <input type="checkbox" value="permission-add" class="flat-red " name="permissions[]" id="createPerm"
                    @if($permissions['permission-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createPerm">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="permission-edit" class="flat-red " name="permissions[]" id="editPerm"
                    @if($permissions['permission-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editPerm">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="permission-delete" class="flat-red " name="permissions[]" id="deletePerm"
                    @if($permissions['permission-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deletePerm">
                    @lang('app.delete')
                </label>
            </div>
            <div>
                <input type="checkbox" value="permission-change" class="flat-red " name="permissions[]" id="deleteCng"
                    @if($permissions['permission-change']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteCng">
                    @lang('role.permission') @lang('app.change')
                </label>
            </div>
        </div>
    </div>
</div>
