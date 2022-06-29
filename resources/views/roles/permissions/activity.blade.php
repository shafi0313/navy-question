<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">@lang('activity.activity') @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> __('activity.activity')])</p>
        <div>
            <input type="checkbox" value="activity-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageactivity" name="permissions[]" id="Manageactivity"
                @if($permissions['activity-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="Manageactivity">
                @lang('role.yes-allow', ['attribute'=> __('activity.activity')])
            </label>
        </div>
        <div style="@if($permissions['activity-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageactivity">
            <div>
                <input type="checkbox" value="activity-add" class="flat-red " name="permissions[]" id="createactivity"
                    @if($permissions['activity-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createactivity">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="activity-edit" class="flat-red " name="permissions[]" id="editactivity"
                    @if($permissions['activity-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editactivity">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="activity-delete" class="flat-red " name="permissions[]" id="deleteactivity"
                    @if($permissions['activity-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteactivity">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
