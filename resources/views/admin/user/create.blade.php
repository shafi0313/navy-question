<div class="modal fade" id="user-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.user.store') }}" method="post" onsubmit="ajaxStore(event, this, 'POST', 'user-add')" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <div id="permissionShow">
                            <label for="permission">Permission <span class="t_r">*</span></label>
                            <select name="permission" id="" class="form-control @error('permission') is-invalid @enderror">
                                <option selected >Select</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('permission')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <span class="t_r">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter name" required>
                            @if ($errors->has('name'))
                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Designation </label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="Designation">
                            @if ($errors->has('designation'))
                                <div class="alert alert-danger">{{ $errors->first('designation') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email address <span class="t_r">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter Email" required>
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone <span class="t_r">*</span></label>
                            <input type="text" name="phone" class="form-control" oninput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" class="form-control" value="{{ old('phone') }}" placeholder="Enter phone" required>
                            @if ($errors->has('phone'))
                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="d_o_b">Date of birth <span class="t_r">*</span></label>
                            <input type="date" name="d_o_b" class="form-control" value="{{ old('d_o_b') }}" required >
                            @if ($errors->has('d_o_b'))
                                <div class="alert alert-danger">{{ $errors->first('d_o_b') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Image </label>
                            <input type="file" name="image" class="form-control">
                            @if ($errors->has('image'))
                                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">Address <span class="t_r">*</span></label>
                            <textarea name="address" class="form-control" id="comment" rows="2" required>

                            </textarea>
                            @if ($errors->has('address'))
                                <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password <span class="t_r">*</span></label>
                            <input type="password" name="password" class="form-control" id="password" autocomplete="new-password" required>
                            @if ($errors->has('password'))
                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmpassword">Confirm Password <span class="t_r">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password" required>
                            @if ($errors->has('password'))
                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>
