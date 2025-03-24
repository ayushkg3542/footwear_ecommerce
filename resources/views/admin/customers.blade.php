@extends('admin.includes.app')
@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dashboard</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-bold flex-wrap font-text1">
            <a href="javascript:;"><span class="me-1">All</span><span
                    class="text-secondary">({{ $customerList }})</span></a>
            <a href="javascript:;"><span class="me-1">New</span><span
                    class="text-secondary">({{ $newCustomerCount }})</span></a>
            <a href="javascript:;"><span class="me-1">Subscribers</span><span class="text-secondary">(163)</span></a>
            <a href="javascript:;"><span class="me-1">Top Reviews</span><span class="text-secondary">(8)</span></a>
        </div>

        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <input class="form-control px-5" id="searchCustomer" type="search" placeholder="Search Customers">
                    <span
                        class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">
                <div class="btn-group position-static">
                    <div class="btn-group position-static">
                        <select name="state" id="state" class="form-control">
                            <option value="">Select State</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Goa">Goa</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                            <option value="Daman and Diu">Daman and Diu</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Puducherry">Puducherry</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <button class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Export</button>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input class="form-check-input" type="checkbox">
                                    </th>
                                    <th>Customers</th>
                                    <th>Email</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                    <th>Location</th>
                                    <th>Last Seen</th>
                                    <th>Last Order</th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody">
                                @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a class="d-flex align-items-center gap-3" href="javascript:;">
                                            <p class="mb-0 customer-name fw-bold">{{ $customer->name }}</p>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="font-text1">{{ $customer->email }}</a>
                                    </td>
                                    <td>{{ $customer->orders_count }}</td>
                                    <td>${{ number_format($customer->orders_sum_total_amount, 2) }}</td>
                                    <td class="customer-state">{{ $customer->state }}, {{ $customer->country }}</td>
                                    <td>{{ $customer->last_seen }}</td>
                                    <td>{{ $customer->last_order_date }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<!--end main wrapper-->

@endsection

@section('customJS')
<script>
$(document).ready(function() {
    $("#searchCustomer").on("keyup", function() {
        let searchQuery = $(this).val();

        $.ajax({
            url: "{{ route('customers') }}",
            type: "GET",
            data: {
                search: searchQuery
            },
            success: function(response) {
                let tableBody = $("#customerTableBody");
                tableBody.empty();

                if (response.customers.length > 0) {
                    response.customers.forEach(customer => {
                        let lastOrderDate = customer.last_order_date !== "N/A" ? customer.last_order_date : "N/A";
                        let lastSeen = customer.last_seen !== "N/A" ? customer.last_seen : "N/A";

                        let customerRow = `
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>
                                    <a class="d-flex align-items-center gap-3" href="javascript:;">
                                        <p class="mb-0 customer-name fw-bold">${customer.name}</p>
                                    </a>
                                </td>
                                <td><a href="javascript:;" class="font-text1">${customer.email}</a></td>
                                <td>${customer.orders_count}</td>
                                <td>$${parseFloat(customer.orders_sum_total_amount).toFixed(2)}</td>
                                <td>${customer.state}, ${customer.country}</td>
                                <td>${lastSeen}</td>
                                <td>${lastOrderDate}</td>
                            </tr>
                            `;
                        tableBody.append(customerRow);
                    });
                } else {
                    tableBody.append(
                        '<tr><td colspan="8" class="text-center">No customers found</td></tr>'
                    );
                }
            }
        })
    });

    function filterByState() {
        let selectedState = $("#state").val().toLowerCase();
        let rows = $("#customerTableBody tr");

        rows.each(function() {
            let state = $(this).find(".customer-state").text().toLowerCase();

            if (selectedState === "" || state.includes(selectedState)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Apply filtering when the state dropdown changes
    $("#state").on("change", filterByState);

})
</script>

@endsection

<!--  -->