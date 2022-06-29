<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Subject @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>Do you want to allow members of this role to manage subject plugin.</p>
        <div>
            <input type="checkbox" value="subject-manage" class="flat-red hasChildOptions" data-child_id="childOfManageSubject" name="permissions[]" id="ManageSubject"
                @if($permissions['subject-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSubject">
                Yes, allow members in this role to manage Subject.
            </label>
        </div>
        <div style="@if($permissions['subject-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSubject">
            <div>
                <input type="checkbox" value="subject-add" class="flat-red " name="permissions[]" id="createSubject"
                    @if($permissions['subject-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createSubject">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="subject-edit" class="flat-red " name="permissions[]" id="editSubject"
                    @if($permissions['subject-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editSubject">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="subject-delete" class="flat-red " name="permissions[]" id="deleteSubject"
                    @if($permissions['subject-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteSubject">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
