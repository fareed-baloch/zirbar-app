@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class="fas fa-cart-arrow-down"></i> Purchases Page</h1>
    </div>
    <div class="col-md-7">


    </div>
</div>
<form class="form form-inline" target="_blank" action="{{route('purchase-fish-print')}}" method="post">
    @csrf
    From date: &nbsp;<input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
    &nbsp;
    To date: &nbsp;<input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
    &nbsp;

    <select name="fishid" required class="form-control">
        <option value="" selected disabled>---------Please Select Type---------</option>
        <option value="Petrol">Petrol</option>
        <option value="Diesel">Diesel</option>
    </select>
    &nbsp;
    <button class="btn btn-danger" type="submit">Print</button>
</form>
<hr>

<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#PurchaseModal">Add New Purchase</button>


<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all purchases</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Remaining Liters</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Status</th>
                        {{-- <th>Payment</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Remaining Liters</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Status</th>
                        {{-- <th>Payment</th> --}}
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($purchases as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                        <td>{{$data->type}}</td>
                        <td>{{floor($data->liters/210)}} Drums
                            {{ number_format(($data->liters/210 - floor($data->liters/210))*210,2) }} Liters</td>
                        <td>
                            <?php 
                            $purchase_details = \App\Models\PurchaseDetails::where('purchaseid',$data->id)->get();
                            $liters = 0.00;
                          
                            foreach ($purchase_details as $row ) {
                               $liters +=  $row->liters;
                            }
                            $liters_left = $data->liters - $liters;
                            ?>

                            {{number_format($liters_left,2)}}

                        </td>
                        <td>{{number_format($data->amount,2)}}</td>
                        {{-- @if($data->party == 0)
                        <td>Individual</td>
                        @else
                        <td>
                            <?php $party =  \App\Models\Party::where('id',$data->party)->first(); ?>
                            {{$party->name}}
                        </td>
                        @endif --}}
                        <td>{{$data->note}}</td>
                        @if($data->status == 0)
                        <td>in Stock</td>
                        @elseif($data->status == 1)
                        <td>In use</td>
                        @elseif($data->status == 2)
                        <td>Sold Out</td>
                        @endif
                        {{-- <td>
                            @if($data->paid == 0)
                            <span class="badge badge-danger">Unpaid</span>
                            @else
                            <span class="badge badge-success">Paid</span>
                            @endif
                        </td> --}}
                        <td>
                            <a class="btn btn-success" href="/purchaseDetails/{{$data->id}}">Details</a>
                            @if(auth()->user()->isadmin && $data->status != 2)
                    <button class="btn btn-danger" data-id="{{$data->id}}" data-action="{{route('delete_purchase')}}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></button>    
                            @endif
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Add Purchase Modal -->
<div class="modal fade" id="PurchaseModal" tabindex="-1" role="dialog" aria-labelledby="PurhcaseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PurhcaseModalLabel">Add New Purchase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('add_purchase') }}">
                    @csrf
                    <div class="row">
                    <div class="form-group col-6">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" value="{{date('Y-m-d')}}" required
                            class="form-control">
                    </div>
                    <div class="form-group col-6">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control" required="required">
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="type">Currency</label>
                        <select name="currency" id="currency" class="form-control" required="required">
                            <option value="TOMAN">TOMAN</option>
                            <option value="PKR">PKR</option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="qtydrum">Quantity-Drum</label>
                        <input id="qtydrum" name="qtydrum" class="form-control" value="0" min="0" type="number"
                            required>
                    </div>
                    <div class="form-group col-6">
                        <label for="qtyliter">Quantity-Liter</label>
                        <input id="qtyliter" name="qtyliter" class="form-control" value="0" min="0" max="209"
                            type="number" required>
                    </div>
                    <div id="ratecon" class="form-group col-6">
                        <label for="rate">Toman Rate:</label>
                        <input id="rate" class="form-control" type="number" name="rate"  required>
                       
                    </div>
                    <div id="pricecon" class="form-group col-6">
                        <label for="price">Price per drum(Toman):</label>
                        <input id="price" class="form-control amount-field" type="number" name="price" required>
                        <small class="form-text text-primary text-center" ></small>
                        
                    </div>

                    <div id="pricepkrcon" style="display: none" class="form-group col-6">
                        <label for="pricepkr">Price per drum(PKR):</label>
                        <input id="pricepkr" class="form-control amount-field" type="number" name="pricepkr">
                        <small class="form-text text-primary text-center" ></small>
                        
                    </div>

                    <div class="form-group col-12">
                        <small class="form-text text-primary text-center" id="pricecal">Total Amount: 0 Total Quantity:
                            0</small>
                    </div>

                    <div class="form-group col-12">
                        <label for="note">Note:</label>
                        <input id="note" class="form-control" type="text" name="note" required>
                        
                    </div>

                    <div class="form-group col-12" style="display: none">
                        <label for="party">Party</label>
                        <select class="form-control selectpicker" data-live-search="true"  name="party" id="party">
                            <option value="0" selected>None</option>
                            <?php $allparty =  \App\Models\Party::where('type','Supplier')->get(); ?>
                            @foreach($allparty as $party)
                            <option value="{{$party->id}}">{{$party->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12" id="statuscontainer">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" selected>Paid</option>
                            <option value="0">Unpaid</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit">Add Purchase</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    const drum = $('#qtydrum');
    const currencyselector = $('#currency');
    const liter = $('#qtyliter');
    const price = $('#price');
    const pricepkr = $('#pricepkr');
    const tomin_rate = $('#rate');

    price.on('input', calculate)
    pricepkr.on('input', calculate)
    drum.on('input', calculate)
    liter.on('input', calculate)
    tomin_rate.on('input', calculate);
    currencyselector.on('change', changelayout);

    function calculate(){
        let totalqty = 0;
        let drumliter = 0;
        let priceliter = 0;
        let pkr_amount = 0;

        if(drum.val()>0){
            drumliter = parseInt(drum.val())*210;
        }
        totalqty = drumliter;
        if(liter.val()>0){
            totalqty += parseInt(liter.val())
        }
        if(price.val()>0){
            priceliter = price.val()/210;
        }
        if(currencyselector.val() == 'TOMAN'){

            let amount = numberWithCommas(Math.round(totalqty * priceliter));
            let amount2 = numberWithCommas(Math.round(totalqty * (priceliter/tomin_rate.val()) ));
            $('#pricecal').html(`Total Amount (tomin) : ${amount} || Total Amount (PKR) : ${amount2} || Total Liters: ${numberWithCommas(totalqty)}`)
        }else{
            priceliter = pricepkr.val()/210;
            let amount = numberWithCommas(Math.round(totalqty * priceliter));
            $('#pricecal').html(`Total Amount (PKR) : ${amount} || Total Liters: ${numberWithCommas(totalqty)}`)
        }
    }

    let party = $('#party');
    const status = $('#statuscontainer');
    status.hide()
    party.on('change', function(){
        if(party.val()== "0"){
            status.hide();
        }
        else{
            status.show();
        }
    })

    function changelayout() {
           let value =  $('#currency').val();
           if(value == 'PKR'){
            price.removeAttr('required');
            tomin_rate.removeAttr('required');
            pricepkr.attr('required', 'required');
            $('#ratecon').hide();
            $('#pricecon').hide();
            $('#pricepkrcon').show();

           }
           else{
            price.attr('required', 'required');
            tomin_rate.attr('required', 'required');
            pricepkr.removeAttr('required');
            $('#ratecon').show();
            $('#pricecon').show();
            $('#pricepkrcon').hide();
           }
    }
</script>


@endsection