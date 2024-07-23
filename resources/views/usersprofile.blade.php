@extends('layouts.app')
@section('content')
<!DOCTYPE html>
    <html>
        <body>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Profile</h1>
                </div><!-- End Page Title -->
                <section class="section profile">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <img src="{{ asset('images/profile_images/' . ($profileuser->p_img ?? 'default_image/765-default-avatar.png')) }}" alt="Profile" class="rounded-circle">
                                <h2>{{ $profileuser->user->name }}</h2>
                                    <h3>{{$profileuser->user->u_num}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body pt-3">
                                <!-- Bordered Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-bordered">

                                        <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                        </li>
                                        <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                        </li>

                                    </ul>
                                    <div class="tab-content pt-2">
                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">


                                            <h5 class="card-title">Profile Details</h5> 
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                            <div class="col-lg-9 col-md-8">{{ $profileuser->user->name }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">University Number</div>
                                            <div class="col-lg-9 col-md-8">{{$profileuser->user->u_num}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Seat Number</div>
                                            <div class="col-lg-9 col-md-8">{{$profileuser->seat_num}}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Lab</div>
                                            <div class="col-lg-9 col-md-8">Web Application</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">University</div>
                                            <div class="col-lg-9 col-md-8">Swansea</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email</div>
                                            <div class="col-lg-9 col-md-8">{{$profileuser->user->email}}</div>
                                        </div>

                                    </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form id="signform" action="{{ route('profileuserupdate', $profileuser->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="{{ asset('images/profile_images/' . ($profileuser->p_img ?? 'default_image/765-default-avatar.png')) }}" alt="Profile">
                                                <div class="pt-2">
                                                    <input type="file" class="btn btn-primary btn-sm" title="Upload new profile image" id="p_img" name="p_img" accept="image/*">
                                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" class="form-control" id="name" value="{{ old('name', $profileuser->user->name) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="email" value="{{ old('email', $profileuser->user->email) }}">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>


                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form>

                                        <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="currentPassword">
                                        </div>
                                        </div>

                                        <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                                        </div>
                                        </div>

                                        <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                        </div>
                                        </div>

                                        <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                    </div>

                                </div><!-- End Bordered Tabs -->

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </body>
    </html><!-- End #main -->
  @endsection