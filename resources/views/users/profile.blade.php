@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <section>
        <div class="row">
            <div class="col-xl-4">

                <div class="card shadow m-3">
                    <div class="card-body pt-4 d-flex flex-column align-items-center">
                        @if (auth()->user()->image)
                            <img src="{{ asset('storage/images/users/' . auth()->user()->image) }}" width="200"
                                height="200" alt="Profile" class="rounded-circle" />
                        @elseif (auth()->user()->image === null)
                            <img src="modernize/assets/images/profile/user-1.jpg" width="200" height="200"
                                alt="Profile" class="rounded-circle" />
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card shadow m-3">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            {{-- Overview --}}
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <br>
                                <h5 class="card-title">Profile Details</h5>

                                <table class="table table-borderless table-striped">

                                    <tbody>
                                        <tr>
                                            <td class="fw-bold col-md-3">Name</td>
                                            <td class="col-md-1">:</td>
                                            <td>{{ Auth::user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Username</td>
                                            <td class="col-md-1">:</td>
                                            <td>{{ Auth::user()->username }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Role</td>
                                            <td class="col-md-1">:</td>
                                            <td>{{ Auth::user()->roles }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Phone</td>
                                            <td class="col-md-1">:</td>
                                            <td>{{ Auth::user()->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Joined</td>
                                            <td class="col-md-1">:</td>
                                            <td>{{ Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Status Account</td>
                                            <td class="col-md-1">:</td>
                                            <td>
                                                @if (Auth::user()->status === 'active')
                                                    <span
                                                        class="badge bg-success rounded-3 fw-semibold text-capitalize">{{ Auth::user()->status }}
                                                    </span>
                                                @elseif (Auth::user()->status === 'inactive')
                                                    <span
                                                        class="badge bg-danger rounded-3 fw-semibold">{{ Auth::user()->status }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                            {{-- End Overview --}}

                            {{-- Edit Profile --}}
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form action="{{ route('users.update-profile') }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            @if (Auth::user()->image)
                                                <img id="preview" style="border-radius: 10px;" alt="Profile"
                                                    width="150" height="150"
                                                    src="{{ asset('storage/images/users/' . $user->image) }}" />
                                            @elseif(Auth::user()->image == null)
                                                <img id="preview" style="border-radius: 10px;" alt="Profile"
                                                    width="150" height="150"
                                                    src="modernize/assets/images/profile/user-1.jpg" />
                                            @endif
                                            <div>
                                                <input class="form-control mt-3" type="file" id="imgInp"
                                                    name="image" accept="image/*" @error('image') is-invalid @enderror>
                                                <small style="color:Tomato;">
                                                    <em>
                                                        Upload images in jpg/jpeg/png format and maximum image size
                                                        2mb
                                                    </em>
                                                </small>
                                            </div>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="name" value="{{ old('name', $user->name) }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                id="username" value="{{ old('username', $user->username) }}">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="phone"
                                                onkeypress="return isNumberKey(event)"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="password">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password_confirmation"
                                            class="col-md-4 col-lg-3 col-form-label">Confirm
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                id="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="check-password" class="col-md-4 col-lg-3 col-form-label"></label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-group">
                                                <input type="checkbox" name="check-password" id="check-password"
                                                    class="check-password" onclick="togglePassword()">
                                                <label for="check-password">Check password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                            {{-- End Edit Profile --}}

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function togglePassword() {
            var x = document.getElementById("password");
            var y = document.getElementById("password_confirmation");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection
