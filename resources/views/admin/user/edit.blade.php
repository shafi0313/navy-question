<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="post"
                onsubmit="ajaxStore(event, this, 'POST', 'editModal')" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role">Permission <span class="t_r">*</span></label>
                                <select name="role" class="form-control">
                                    <option selected>Select</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected($role->id == $user->roles->first()->id)>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <div class="alert alert-danger">{{ $errors->first('role') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="t_r">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email address <span class="t_r">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile">Mobile <span class="t_r">*</span></label>
                                <input type="text" name="mobile" class="form-control"
                                    oninput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" class="form-control"
                                    value="{{ $user->mobile }}" required>
                                @if ($errors->has('mobile'))
                                    <div class="alert alert-danger">{{ $errors->first('mobile') }}</div>
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
                                <textarea name="address" class="form-control" id="comment" rows="2" required>{{ $user->address }}</textarea>
                                @if ($errors->has('address'))
                                    <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" >
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmpassword">Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation" >
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
