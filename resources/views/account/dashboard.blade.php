@extends('includes.app')
@section('content')

<style>
.container .topic {
    font-size: 30px;
    font-weight: 500;
    margin-bottom: 20px;
    color: rgba(255, 255, 255, 0.7);
}

.content .radio-button {
    display: none;
}

.saveDetails.primary-btn {
    display: block;
    border-radius: 0px;
    line-height: 38px;
    width: 100%;
    text-transform: uppercase;
    border: none;
}

.content {
    display: flex;
    justify-content: space-between;
    /* align-items: center; */
    margin: 100px 0;
}

.content .list {
    display: flex;
    flex-direction: column;
    position: relative;
    width: 20%;
    margin-right: 50px;
}

.content .list label {
    cursor: pointer;
    height: 60px;
    line-height: 60px;
    font-size: 16px;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.5);
    padding-left: 25px;
    transition: all 0.5s ease;
    z-index: 10;
    background-color: #e1e1e1;
    border-bottom: 1px solid rgb(164, 164, 164);
}

#home:checked~.list label.home,
#blog:checked~.list label.blog,
#help:checked~.list label.help,
#code:checked~.list label.code,
#about:checked~.list label.about {
    color: #22272C;
}

.content .slider {
    position: absolute;
    left: 0;
    top: 0;
    height: 60px;
    width: 100%;
    border-radius: 12px;
    transition: all 0.5s ease;
}

#home:checked~.list .slider {
    top: 0;
}

#blog:checked~.list .slider {
    top: 60px;
}

#help:checked~.list .slider {
    top: 120px;
}

#code:checked~.list .slider {
    top: 180px;
}

#about:checked~.list .slider {
    top: 240px;
}

.content .text-content {
    width: 80%;
    height: 100%;
    color: rgba(0, 0, 0, 0.7);
}

.content .text {
    display: none;
}

.content .text .title {
    font-size: 25px;
    margin-bottom: 10px;
    font-weight: 500;
}

.container .text p {
    text-align: justify;
}

.content .text-content .home {
    display: block;
}

#home:checked~.text-content .home,
#blog:checked~.text-content .blog,
#help:checked~.text-content .help,
#code:checked~.text-content .code,
#about:checked~.text-content .about {
    display: block;
}

#blog:checked~.text-content .home,
#help:checked~.text-content .home,
#code:checked~.text-content .home,
#about:checked~.text-content .home {
    display: none;
}
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h3 class="text-dark"><strong>Welcome back {{ Auth::user()->name }}</strong></h3>
                <nav class="d-flex align-items-center">
                    <a href="#">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Dashboard</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="feature-area">
    <div class="container">

        <div class="topic">CSS Vertical Tab</div>

        <div class="content">
            <input type="radio" name="slider" class="radio-button" checked id="home">
            <input type="radio" name="slider" class="radio-button" id="blog">
            <input type="radio" name="slider" class="radio-button" id="help">
            <input type="radio" name="slider" class="radio-button" id="code">
            <input type="radio" name="slider" class="radio-button" id="about">

            <div class="list">
                <label for="home" class="home">
                    <span><i class="bi bi-person"></i> Account Details</span>
                </label>
                <label for="blog" class="blog">
                    <span><i class="bi bi-bag-heart"></i> My Orders</span>
                </label>
                <label for="help" class="help">
                    <span><i class="bi bi-credit-card"></i> Credits</span>
                </label>
                <label for="code" class="code">
                    <span><i class="bi bi-heart"></i> Favourites</span>
                </label>
                <label for="about" class="about">
                    <span>About</span>
                </label>
                <div class="slider"></div>
            </div>

            <div class="text-content">
                <div class="home text">
                    <div class="title">Edit Details</div>
                    <div class="card mb-5">
                        <div class="card-header"><strong>Profile Details</strong></div>
                        <div class="card-body">
                            <form action="javascript:void(0)" id="profileForm" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Full Name" value="{{ $userDetails->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <input type="number" name="phone" id="phone" class="form-control"
                                                placeholder="Phone Number" value="{{ $userDetails->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Email" value="{{ $userDetails->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" name="gender" value="Male"
                                                        {{ $userDetails->gender == 'Male' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control"
                                                aria-label="Text input with radio button" value="Male">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" name="gender" value="Female"
                                                        {{ $userDetails->gender == 'Female' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control"
                                                aria-label="Text input with radio button" value="Female">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" value="submit" class="saveDetails primary-btn">Save
                                            Details</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><strong>Address Details</strong></div>
                        <div class="card-body">
                            <form action="javascript:void(0)" method="post" id="addressForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Street Address</label>
                                            <input type="text" name="street" id="street" class="form-control"
                                                value="{{ $userAddress->address ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Pincode</label>
                                            <input type="text" name="pincode" id="pincode" class="form-control"
                                                value="{{ $userAddress->pincode ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Locality/Town</label>
                                            <input type="text" name="locality" id="locality" class="form-control"
                                                value="{{ $userAddress->locality ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" name="city" id="city" class="form-control"
                                                value="{{ $userAddress->city ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <select name="state" id="state" class="form-control">
                                                <option value="">Select State</option>
                                                <option value="Andhra Pradesh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Andhra Pradesh' ? 'selected' : '' }}>
                                                    Andhra Pradesh
                                                </option>
                                                <option value="Arunachal Pradesh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Arunachal Pradesh' ? 'selected' : ''}}>
                                                    Arunachal Pradesh</option>
                                                <option value="Assam"
                                                    {{ isset($userAddress) && $userAddress->state == 'Assam' ? 'selected' : ''}}>Assam</option>
                                                <option value="Bihar"
                                                    {{ isset($userAddress) && $userAddress->state == 'Bihar' ? 'selected' : ''}}>Bihar</option>
                                                <option value="Chhattisgarh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Chhattisgarh' ? 'selected' : ''}}>
                                                    Chhattisgarh</option>
                                                <option value="Gujarat"
                                                    {{ isset($userAddress) && $userAddress->state == 'Gujarat' ? 'selected' : ''}}>Gujarat
                                                </option>
                                                <option value="Haryana"
                                                    {{ isset($userAddress) && $userAddress->state == 'Haryana' ? 'selected' : ''}}>Haryana
                                                </option>
                                                <option value="Himachal Pradesh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Himachal Pradesh' ? 'selected' : ''}}>
                                                    Himachal Pradesh</option>
                                                <option value="Jammu and Kashmir"
                                                    {{ isset($userAddress) && $userAddress->state == 'Jammu and Kashmir' ? 'selected' : ''}}>
                                                    Jammu and Kashmir</option>
                                                <option value="Goa" {{ isset($userAddress) && $userAddress->state == 'Goa' ? 'selected' : ''}}>
                                                    Goa</option>
                                                <option value="Jharkhand"
                                                    {{ isset($userAddress) && $userAddress->state == 'Jharkhand' ? 'selected' : ''}}>Jharkhand
                                                </option>
                                                <option value="Karnataka"
                                                    {{ isset($userAddress) && $userAddress->state == 'Karnataka' ? 'selected' : ''}}>Karnataka
                                                </option>
                                                <option value="Kerala"
                                                    {{ isset($userAddress) && $userAddress->state == 'Kerala' ? 'selected' : ''}}>Kerala
                                                </option>
                                                <option value="Madhya Pradesh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Madhya Pradesh' ? 'selected' : ''}}>
                                                    Madhya Pradesh</option>
                                                <option value="Maharashtra"
                                                    {{ isset($userAddress) && $userAddress->state == 'Maharashtra' ? 'selected' : ''}}>
                                                    Maharashtra</option>
                                                <option value="Manipur"
                                                    {{ isset($userAddress) && $userAddress->state == 'Manipur' ? 'selected' : ''}}>Manipur
                                                </option>
                                                <option value="Meghalaya"
                                                    {{ isset($userAddress) && $userAddress->state == 'Meghalaya' ? 'selected' : ''}}>Meghalaya
                                                </option>
                                                <option value="Mizoram"
                                                    {{ isset($userAddress) && $userAddress->state == 'Mizoram' ? 'selected' : ''}}>Mizoram
                                                </option>
                                                <option value="Nagaland"
                                                    {{ isset($userAddress) && $userAddress->state == 'Nagaland' ? 'selected' : ''}}>Nagaland
                                                </option>
                                                <option value="Odisha"
                                                    {{ isset($userAddress) && $userAddress->state == 'Odisha' ? 'selected' : ''}}>Odisha
                                                </option>
                                                <option value="Punjab"
                                                    {{ isset($userAddress) && $userAddress->state == 'Punjab' ? 'selected' : ''}}>Punjab
                                                </option>
                                                <option value="Rajasthan"
                                                    {{ isset($userAddress) && $userAddress->state == 'Rajasthan' ? 'selected' : ''}}>Rajasthan
                                                </option>
                                                <option value="Sikkim"
                                                    {{ isset($userAddress) && $userAddress->state == 'Sikkim' ? 'selected' : ''}}>Sikkim
                                                </option>
                                                <option value="Tamil Nadu"
                                                    {{ isset($userAddress) && $userAddress->state == 'Tamil Nadu' ? 'selected' : ''}}>Tamil
                                                    Nadu</option>
                                                <option value="Telangana"
                                                    {{ isset($userAddress) && $userAddress->state == 'Telangana' ? 'selected' : ''}}>Telangana
                                                </option>
                                                <option value="Tripura"
                                                    {{ isset($userAddress) && $userAddress->state == 'Tripura' ? 'selected' : ''}}>Tripura
                                                </option>
                                                <option value="Uttarakhand"
                                                    {{ isset($userAddress) && $userAddress->state == 'Uttarakhand' ? 'selected' : ''}}>
                                                    Uttarakhand</option>
                                                <option value="Uttar Pradesh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Uttar Pradesh' ? 'selected' : ''}}>Uttar
                                                    Pradesh</option>
                                                <option value="West Bengal"
                                                    {{ isset($userAddress) && $userAddress->state == 'West Bengal' ? 'selected' : ''}}>West
                                                    Bengal</option>
                                                <option value="Andaman and Nicobar Islands"
                                                    {{ isset($userAddress) && $userAddress->state == 'Andaman and Nicobar Islands' ? 'selected' : ''}}>
                                                    Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh"
                                                    {{ isset($userAddress) && $userAddress->state == 'Chandigarh' ? 'selected' : ''}}>
                                                    Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli"
                                                    {{ isset($userAddress) && $userAddress->state == 'Dadra and Nagar Haveli' ? 'selected' : ''}}>
                                                    Dadra and Nagar Haveli</option>
                                                <option value="Daman and Diu"
                                                    {{ isset($userAddress) && $userAddress->state == 'Daman and Diu' ? 'selected' : ''}}>Daman
                                                    and Diu</option>
                                                <option value="Delhi"
                                                    {{ isset($userAddress) && $userAddress->state == 'Delhi' ? 'selected' : ''}}>Delhi</option>
                                                <option value="Lakshadweep"
                                                    {{ isset($userAddress) && $userAddress->state == 'Lakshadweep' ? 'selected' : ''}}>
                                                    Lakshadweep</option>
                                                <option value="Puducherry"
                                                    {{ isset($userAddress) && $userAddress->state == 'Puducherry' ? 'selected' : ''}}>
                                                    Puducherry</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" value="submit" class="saveDetails primary-btn">Save
                                            Address</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="blog text">
                    <div class="title">My Orders</div>
                    @foreach($orders as $order)
                    @foreach($order->orderItems as $item)
                    <a href="{{ route('orderDetails',['order' => encrypt($order->id)]) }}">
                        <div class="card mb-3">
                            <div class="card-body text-dark">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ url('public/product_images/' . $item->product->images->first()->images ?? 'default.png') }}"
                                            class="img-fluid" style="height: 100px" alt="{{ $item->product->title }}">
                                    </div>
                                    <div class="col-md-4">
                                        <h5>{{ $item->product->title }}</h5>
                                        <p>Price: <strong>₹{{ number_format($item->product->new_price, 2) }}</strong>
                                        </p>
                                        <p>Quantity: <strong>{{ $item->quantity }}</strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <p>Order ID: #{{ $order->id }}</p> -->
                                        <p>Payment Status: <span
                                                class="badge bg-success">{{ ucfirst($order->status) }}</span></p>
                                        <!-- <p>Payment ID: <strong>{{ $order->razorpay_payment_id }}</strong> </p> -->
                                        <p>Amount Paid: <strong> ₹{{ number_format($order->total_amount, 2) }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endforeach

                </div>
                <div class="help text">
                    <div class="title">Help</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, laborum? Dolorem voluptates modi
                        porro magni dicta, id minus commodi mollitia saepe unde, iure omnis culpa, praesentium dolorum
                        debitis reiciendis impedit veritatis hic cum reprehenderit assumenda possimus temporibus. Nemo
                        sint cum soluta vitae odit tempore ipsum similique, consectetur quos veritatis voluptatibus.</p>
                </div>
                <div class="code text">
                    <div class="title">Code</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore ullam, voluptatem, mollitia amet
                        iure sequi sapiente reprehenderit consectetur a saepe error molestiae vitae pariatur delectus
                        repudiandae ipsa aspernatur eveniet quo maiores dignissimos. Officiis, molestias velit accusamus
                        ipsa consectetur exercitationem voluptatem natus quisquam soluta facilis. Quas, autem harum?
                        Consequuntur blanditiis quasi consequatur, omnis debitis odio ratione excepturi nulla fugit
                        mollitia itaque esse fuga, soluta eos aspernatur? Modi delectus quasi dicta veritatis. Vero,
                        expedita mollitia veritatis magni aperiam maxime ipsum. Ut, debitis.</p>
                </div>
                <div class="about text">
                    <div class="title">About</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate, quia repudiandae quisquam
                        nam molestiae non. Itaque repudiandae quam, sed maxime voluptate quos ipsam optio odio ab
                        molestiae facilis numquam repellendus, natus maiores vel soluta accusantium placeat nihil ad
                        cupiditate consequuntur reprehenderit deserunt nam tempora. Voluptates non quia corporis
                        temporibus tempora.</p>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@section('customJS')

<script>
$(document).ready(function() {
    // Update Profile Form
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#profileForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('account.updateProfile') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    notyf.success(response.message);
                    location.reload();
                } else {
                    notyf.error('Failed to update profile.');
                }
            },
            error: function(xhr) {
                notyf.error('Something went wrong. Please try again.');
            }
        });
    });

    // Update Address Form
    $("#addressForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('account.updateAddress') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                notyf.success(response.message);
                location.reload();
            },
            error: function(xhr) {
                notyf.error('Failed to update address. ' + (xhr.responseJSON?.message ||
                    'Please try again.'));
            }
        });
    });

});
</script>

@endsection