@extends('layout.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="/teste" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">Step 3: Review Details</div>

                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <td>Product Name:</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Product Amount:</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>Product status:</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>Product Description:</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>Product Stock:</td>
                                <td>5</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-md-6 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection