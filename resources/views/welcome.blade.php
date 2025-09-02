@extends('layouts.app')

@section('content')
<div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Digital Prescription Management</h1>
        <p class="lead mb-5">Upload your prescriptions, get instant quotations from pharmacies, and manage your medication orders online.</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                <p class="lead text-muted">Simple, fast, and secure prescription management</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="text-center">
                    <h4 class="fw-bold mb-4 text-primary">For Patients</h4>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">📋</div>
                            <div>
                                <h5>1. Upload Prescription</h5>
                                <p class="text-muted">Take photos of your prescription and upload up to 5 images with delivery details.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">💰</div>
                            <div>
                                <h5>2. Receive Quotation</h5>
                                <p class="text-muted">Get detailed quotations from pharmacies with medication prices and availability.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">✅</div>
                            <div>
                                <h5>3. Accept & Order</h5>
                                <p class="text-muted">Review and accept quotations to proceed with your medication order.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="text-center">
                    <h4 class="fw-bold mb-4 text-success">For Pharmacies</h4>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">👁️</div>
                            <div>
                                <h5>1. View Prescriptions</h5>
                                <p class="text-muted">Access uploaded prescription images and patient delivery requirements.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">📊</div>
                            <div>
                                <h5>2. Create Quotations</h5>
                                <p class="text-muted">Prepare detailed quotations with medication prices and quantities.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <div class="d-flex">
                            <div class="me-3" style="font-size: 3rem;">📧</div>
                            <div>
                                <h5>3. Get Notifications</h5>
                                <p class="text-muted">Receive instant email notifications when patients respond to quotations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3" style="font-size: 3rem;">🔒</div>
                        <h5>Secure Upload</h5>
                        <p class="text-muted">Your prescription images are safely stored and accessible only to authorized pharmacies.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3" style="font-size: 3rem;">⚡</div>
                        <h5>Quick Response</h5>
                        <p class="text-muted">Get quotations quickly and choose your preferred delivery time slot.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3" style="font-size: 3rem;">📱</div>
                        <h5>Easy Management</h5>
                        <p class="text-muted">Track all your prescriptions and orders from a simple, user-friendly dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-6 fw-bold mb-3">Ready to Get Started?</h2>
        <p class="lead mb-4">Join thousands of patients and pharmacies using our platform for seamless prescription management.</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Register Now</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
            </div>
        </div>
    </div>
</section>
@endsection