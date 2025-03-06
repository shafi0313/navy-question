<div class="modal fade" id="user-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="post"
                onsubmit="ajaxStore(event, this, 'POST', 'user-add')" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="permission">Permission <span class="t_r">*</span></label>
                                <select name="permission" class="form-control" required>
                                    <option selected>Select</option>
                                    @foreach (config('var.permission') as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('permission'))
                                    <div class="alert alert-danger">{{ $errors->first('permission') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="t_r">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="Enter name" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email address <span class="t_r">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="Enter Email" required>
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile">Mobile </label>
                                <input type="text" name="mobile" class="form-control"
                                    oninput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" class="form-control"
                                    value="{{ old('mobile') }}" placeholder="Enter mobile">
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
                                <label for="comment">Address</label>
                                <textarea name="address" class="form-control" id="comment" rows="2">

                            </textarea>
                                @if ($errors->has('address'))
                                    <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password <span class="t_r">*</span></label>
                                <input type="password" name="password" class="form-control" id="password" required>
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmpassword">Confirm Password <span class="t_r">*</span></label>
                                <input class="form-control" type="password" name="password_confirmation" required>
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
