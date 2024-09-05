@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact
                Us</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form bg-light p-30">
                    <div id="success"></div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('danger'))
                        <div class="alert alert-danger">{{ session('danger') }}</div>
                    @endif
                    <form method="POST" action="{{ route('messages') }}">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Your Name" />
                            <p class="help-block text-danger">
                                @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                @endif
                            </p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" name="email" placeholder="Your Email"
                                value="{{ old('email') }}" />
                            <p class="help-block text-danger">
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" name="subject" value="{{ old('subject') }}"
                                placeholder="Subject" />
                            <p class="help-block text-danger">
                                @if ($errors->has('subject'))
                                    {{$errors->first('subject')}}
                                @endif
                            </p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" rows="8" name="message" placeholder="Message">{{ old('message') }}</textarea>
                            <p class="help-block text-danger">
                                @if ($errors->has('message'))
                                    {{$errors->first('message')}}
                                @endif
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-30">

                          <iframe style="width: 100%; height: 250px;" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1566557.0797729308!2d48.92409325!3d39.92613665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1str!2saz!4v1725539835022!5m2!1str!2saz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="bg-light p-30 mb-3">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
