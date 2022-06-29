
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('app.update')  @lang('role.permission')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('admin.permission.update', $permission->id) }}" autocomplete="off">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="module" value="{{$permission->module}}">
                    <input type="search" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" value="{{$permission->name}}" placeholder="@lang('role.permission') {{ __('app.name') }}">
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">@lang('app.close')</button>
                <button class="btn btn-primary" type="submit">@lang('app.update')</button>

            </div>
        </form>
      </div>
    </div>
  </div>



