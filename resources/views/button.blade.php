@if ($type == 'ajax-edit')
<button data-route="{{$route}}" data-value="{{$row->id}}" class='btn btn-primary btn-sm mb-2' onclick="ajaxEdit(this)" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-original-title="@lang("app.edit")" title='@lang("app.edit")'><i
        class='fa fa-edit'></i></button>
@endif

@if ($type == 'edit')
<a href="{{route($route.'.edit', $row->id)}}" class='btn btn-primary btn-sm mb-2' data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang("app.edit")"
    title='@lang("app.edit")'><i class='fa fa-edit'></i> </a>
@endif

@if ($type == 'delete')
<button data-route="{{route($route.'.destroy', $row->id)}}" class='_delete btn btn-sm btn-danger mb-2' data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.cannot-undo')"  title='@lang("app.delete")'><i
        class='fa fa-trash'></i></button>
@endif
@if ($type == 'ajax-delete')
<button data-route="{{$route}}"  data-value="{{$row->id}}" onclick="ajaxDelete(this, '{{$src}}')" class='btn-sm btn btn-danger mb-2' data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.cannot-undo')" title='@lang("app.delete")'><i class='fa fa-trash' style="vertical-align: middle;"></i></button>
@endif
@if ($type == 'view')
<a href="{{route($route.'.show', $row->id)}}" class=' btn btn-sm btn-secondary mb-2' data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.show-details')" title="@lang('app.show-details')"><i class='fa fa-eye'></i></a>
@endif

@if ($type == 'impersonate')
@canBeImpersonated($row)
<a href="{{route('panel.impersonate',$row->id)}}" class="btn btn-success mb-2" target="_blank" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('user.impersonate-user')" title="@lang('user.impersonate-user')"><i class="fa btn-white fa-user-secret"></i></a>
@endCanBeImpersonated
@endif

@if ($type == 'log')
<a href="{{route('panel.user.activitlog',$row->id)}}" class="btn  btn-sm btn-warning mb-2" target="_blank" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('activity.log')" title="@lang('activity.log')"><i class="fa btn-white fa-history"></i></a>
@endif

@if ($type == 'status')
    <span data-route="{{$route}}"
        style="font-size: 36px;line-height: 1;vertical-align: middle;cursor: pointer;" data-bs-placement="top" data-bs-toggle="tooltip"  data-bs-original-title="@lang('app.status')"
        data-value="{{$row->status}}"
        onclick="changeStatus(this)" title="@lang('app.status')">
        @if($row->status == 1)
        <i class="fa fa-toggle-on text-success"></i>
        @else
        <i class="fa fa-toggle-off text-danger"></i>
        @endif
    </span>
@endif
@if ($type == 'toggle-btn')
<label class="custom-switch form-switch mb-0" data-route="{{$route}}" data-value="{{$row->status}}" onclick="changeStatus(this)">
    <input {{$row->status == 1?'checked':''}} type="checkbox" name="switch" class="custom-switch-input">
    <span class="custom-switch-indicator custom-switch-indicator-md"></span>
</label>
@endif
