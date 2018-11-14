@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg mt-5">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="user-cp-tab" data-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="true">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="user-cp-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">User Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                            <div class="inner-tab-content mt-5">
                                <table class="table table-hover">
                                    <!-- appointments table -->
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Cancel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">30/10/2018</th>
                                        <td>radiological</td>
                                        <td>12:30</td>
                                        <td><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">31/10/2018</th>
                                        <td>pediatric</td>
                                        <td>09:45</td>
                                        <td><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- appointments table ENDS-->
                                <!-- confirmation Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ConfirmationModalLabel">Do you want to cancel the appointment ?</h5>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">No</button>
                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of confirmation Modal -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="inner-tab-content">
                                <form class="form-signin">
                                    <label for="inputEmail" class="mt-3">Email address</label>
                                    <input type="email" class="form-control" value="mail@example.com" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your email')" required autofocus>
                                    <label for="inputPassword" class="mt-3">Password</label>
                                    <input type="password" class="form-control mt-1" placeholder="Password">
                                    <label for="inputPasswordRe-enter" class="mt-3">Re-enter Password</label>
                                    <input type="password" class="form-control mt-1" placeholder="Re-enter Password">
                                    <label for="inputPhone" class="mt-3">Phone</label>
                                    <input type="number" class="form-control mt-1" value="094525831" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your phone number')" required autofocus>
                                    <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
