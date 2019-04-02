@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                @if(Session::has('error'))
                    <p class="alert alert-warning">{{ Session::get('error') }}</p>
                @endif
                <div class="card-header">{{ __('Add New User') }}</div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('add_user') }}" aria-label="{{ __('Add New User') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" placeholder="Name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="surname" placeholder="Surname" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required>

                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_number" class="col-md-4 col-form-label text-md-right">{{ __('ID Number') }}</label>

                            <div class="col-md-6">
                                <input id="id_number" type="text" maxlength ="13" placeholder="ID Number" class="form-control{{ $errors->has('id_number') ? ' is-invalid' : '' }}" name="id_number" value="{{old('id_number')}}" required>
                                <div id="error" class="alert-danger" style="padding_top:10px;"></div>
                                @if ($errors->has('id_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('id_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                            <!-- set the date of birth to readonly field this should be taken from the id number -->
                            <div class="col-md-6">
                                <input id="date_of_birth"  data-date="" data-date-format="DD-MM-YYYY" type="date"  class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" required readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="post">
                                    {{ __('Post') }}
                                </button>

                                <button type="reset" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<script type="text/javascript">
    
    $("document").ready(function(){
        // restrict ID number to only accepts digits only
        $('#id_number').on("keyup",function (event) {
            var keycode = event.which;
            if ($(this).val().length == 13) {
                Validate();
            }
            if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                event.preventDefault();
            }
         });

         $("#date_of_birth").on("click", function() {
             console.log("clicked");
            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                .format( this.getAttribute("data-date-format") )
            )
        }).trigger("change");

            // validation function logic for south african ID credits goes to @stackoverflow chridam https://stackoverflow.com/users/122005/chridam
            function Validate() {
            // first clear any left over error messages
        
            var idNumber = $('#id_number').val();
            // assume everything is correct and if it later turns out not to be, just set this to false
            var correct = true;

            //Ref: http://www.sadev.co.za/content/what-south-african-id-number-made
            // SA ID Number have to be 13 digits, so check the length
            if (idNumber.length != 13 || !isNumber(idNumber)) {
                $('span#error').append('ID number does not appear to be authentic - input not a valid number');
                correct = false;
            }

            // get first 6 digits as a valid date
            var tempDate = new Date(idNumber.substring(0, 2), idNumber.substring(2, 4) - 1, idNumber.substring(4, 6));

            var id_date     = tempDate.getDate();
            var id_month    = tempDate.getMonth();
            var id_year     = tempDate.getFullYear();
            // append a zero if the date of birth is a single digit
        
            var fullDate    = id_year + "-" + pad((id_month + 1)) + "-" + id_date;

            if (!((tempDate.getYear() == idNumber.substring(0, 2)) && (id_month == idNumber.substring(2, 4) - 1) && (id_date == idNumber.substring(4, 6)))) {
                $('div#error').append('ID number does not appear to be authentic - date part not valid');
                $("#date_of_birth").val('');
                $("#post").prop("disabled",true);
                correct = false;
            }

            // get the gender
            var genderCode = idNumber.substring(6, 10);
            var gender = parseInt(genderCode) < 5000 ? "Female" : "Male";

            // get country ID for citzenship
            var citzenship = parseInt(idNumber.substring(10, 11)) == 0 ? "Yes" : "No";

            // apply Luhn formula for check-digits
            var tempTotal = 0;
            var checkSum = 0;
            var multiplier = 1;
            for (var i = 0; i < 13; ++i) {
                tempTotal = parseInt(idNumber.charAt(i)) * multiplier;
                if (tempTotal > 9) {
                    tempTotal = parseInt(tempTotal.toString().charAt(0)) + parseInt(tempTotal.toString().charAt(1));
                }
                checkSum = checkSum + tempTotal;
                multiplier = (multiplier % 2 == 0) ? 1 : 2;
            }
            if ((checkSum % 10) != 0) {
                $('div#error').append('<p>ID number does not appear to be authentic - check digit is not valid</p>');
                $("#date_of_birth").val('');
                $("#post").prop("disabled",true);
                correct = false;
            };

            // if no error found, hide the error message
            if (correct) {
            
                // and put together a result message
                $("#date_of_birth").val(fullDate);
                $("#post").prop("disabled",false);
                $('div#error').html('');
                //console.log('<p>South African ID Number:   ' + idNumber + '</p><p>Birth Date:   ' + fullDate + '</p><p>Gender:  ' + gender + '</p><p>SA Citizen:  ' + citzenship + '</p>');
            }
            // otherwise, show the error
            else {
                console.log("error");
                //error.css('display', 'block');
            }

            return false;
            }

            function isNumber(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }

            function pad(number) {
                return (number < 10 ? '0' : '') + number
            }

            $("#post").prop("disabled",true);
            function check_validation() {
		
                var counter = 0;
			setTimeout(function (){
                   
					  $('input').not('#date_of_birth').each(function(i,val) {

									
										if (val.value !='' && val.id !='') {
											if ($("#"+val.id).hasClass('is-invalid')) {
												$("#"+val.id).removeClass("is-invalid");
												$("#"+val.id).addClass("is-valid");
                                                counter++;
											} else {
												$("#"+val.id).addClass("is-valid");
                                                counter++;
											}
										
										} else if (val.value =='' && val.id) {
										   if ($("#"+val.id).hasClass('is-valid')) {
                                                $("#"+val.id).removeClass("is-valid");
                                                $("#"+val.id).addClass("is-invalid");
                                                counter--;
                                            }
										
										} 
                                     
										if (counter == 3 && $("#id_number").val().length == 13 && $("#date_of_birth").val() != '') {
											$("#post").prop("disabled",false);
										} else {
											$("#post").prop("disabled",true);
										}
							
							});
					}, 600);

        }
        $("input").keydown(function() {
            check_validation();
        });
            });
</script>